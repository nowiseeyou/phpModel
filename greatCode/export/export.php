<?php

/**
 * Class export
 * 数据量过大 LIMIT 性能消耗严重
 * 改用ID 区间进行查询 提高执行效率
 */
class export
{
    private $tableName ='';
    private $where_ary =array();
    private $redis;
    public function __construct()
    {
        $this->redis =  new Redis();
    }

    public final function exportLarge()
    {
        header("Content-type: text/html; charset=utf-8");

        $tableName = '';
        $where_ary = array();

        $position = "SELECT min(id) AS startId, max(id) AS endId FROM {$tableName}  WHERE 1 ".implode('', $where_ary);

        $executeId = uniqid();
        $cpuInfo = shell_exec("grep 'cpu cores' /proc/cpuinfo | uniq");
        $cpuCoreCount = (int)str_replace(':', '', strstr($cpuInfo, ':'));
        $executeCoreCount = 2;
        if($cpuCoreCount > 2)
        {
            //最少使用 2 Core , 最多使用 60% Core 数
            $executeCoreCount = ceil($cpuCoreCount * 0.6);
        }
        // AES 加密咨询
        $key = 'qweiopcvbnjdurtz';
        $iv = 'abcdefg15891348';

        //分割 id 区间 5000 一组
        $idRange = [];
        $totalProcesses = ceil( ($position['endId'] - $position['startId']) / 5000 );
        for($i = 0; $i < $totalProcesses; $i++)
        {
            $start = $position['startId'] + ($i * 5000);
            $end = $start + 4999;
            if($end > $position['endId'])
            {
                $end = $position['endId'];
            }
            $row = json_encode(['start' => (int)$start, 'end' => (int)$end, 'sequence' => $i]);
            $idRange[] = rtrim(strtr(base64_encode(openssl_encrypt($row, 'aes-256-xts', $key, OPENSSL_RAW_DATA, $iv)), '+/', '-_'), '=');
        }

        $this->__viewData = [
            'executeId' => $executeId,
            'executeCoreCount' => $executeCoreCount,
            'position' => $position,
            'totalProcessRows' => $totalProcesses,
            'processes' => $idRange,
        ];

        $this->display('exportView.php');
    }

    public final function exportLargeExecute()
    {
        header('Content-Type: application/json; charset=utf-8');

        if(empty($_GET['pageToken']))
        {
            echo json_encode([
                'status' => false,
                'msg' => '非法存取'
            ]);
            exit;
        }

        // AES 加密資訊
        $key = 'qweiopcvbnjdurtz';
        $iv = 'abcdefg15891348';

        $idRange = json_decode(openssl_decrypt(base64_decode(str_pad(strtr($_GET['pageToken'],'-_','+/'), strlen($_GET['pageToken']) % 4,'=',STR_PAD_RIGHT)),'aes-256-xts',$key,OPENSSL_RAW_DATA,$iv),true);

        if(empty($idRange))
        {
            echo json_encode([
                'status' => false,
                'msg' => '非法存取'
            ]);
            exit;
        }

        $tableName = 'table';
        $where_ary[] = " AND b.id >= {$idRange['start']}";
        $where_ary[] = " AND b.id <= {$idRange['end']}";
        $dataAry = "select t.id,t.age,t.name,t.intro,t.hobby,t.remark,t.hobby,t.createTime,t.actionIP from {$tableName} b WHERE 1 ".implode('', $where_ary);

        $data = [
            'data' => $dataAry
        ];

        //导航栏
        $name_ary = array('ID', '姓名', '年龄', '简介', '备注', '爱好', '添加时间', 'IP');

        $data_ary = array();
        if (count($data['data'])>0){
            foreach ($data['data'] as $each){
                $data_ary[] = array(
                    csv_format($each['id']),
                    csv_format($each['name']),
                    csv_format($each['age']),
                    csv_format($each['intro']),
                    csv_format($each['remark']),
                    csv_format($each['hobby']),
                    csv_format(date('Y-m-d H:i:s', $each['createTime'])),
                    csv_format($each['actionIP']),

                );
            }
        }

        $tmp_file = $_SERVER['DOCUMENT_ROOT'].'/export/export_'.$_GET['executeId'].'.csv';

        $file_data = '';

        if( $idRange['sequence'] == 0 ){
            //@unlink($tmp_file);
            $file_data = $file_data . csv_format(implode(',',$name_ary),true).'
        ';
        }

        $executeRows = count($data_ary);
        if ($executeRows > 0){
            foreach ($data_ary as $each){
                $file_data = $file_data . implode(',',$each).'
        ';
            }
        }

        $this->redis->set($tmp_file . $idRange['sequence'], $file_data, 7200);

        echo json_encode([
            'status' => true,
            'data' => [
                'executeRows' => $executeRows,
            ],
            'msg' => '',
        ]);

    }

    public final function exportLargeOutput()
    {
        if(empty($_GET['id']) or empty($_GET['process']) or !is_numeric($_GET['process']))
        {
            header("Content-type: text/html; charset=utf-8");
            exit('缺少必要的參數');
        }

        $tmp_file = $_SERVER['DOCUMENT_ROOT'].'/customise/export/bet_export_'.$_GET['id'].'.csv';

        $exportContent = '';
        for ($i = 0; $i < $_GET['process']; $i++) {
            $exportContent.= $this->redis->get($tmp_file.$i);
        }
        //导出csv
        header('Content-Disposition: attachment; filename=bet.csv');
        header('Content-Type: text/csv');
        echo "\xEF\xBB\xBF";
        echo $exportContent;
        //记录日志
        $this->addLog(81, "导出投注记录", '0','投注记录','');
    }


    //处理csv的特殊字符，逗号、双引号
    private function csv_format($str, $ignore_comma = false){
        $str = str_ireplace('"','"""',$str);
        if (preg_match("/,/",$str) && !$ignore_comma){
            $str = '"'.$str.'"';
        }

        return $str;
    }
}