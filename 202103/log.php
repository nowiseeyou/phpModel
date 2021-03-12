<?php
header("Content-type: text/html;charset=utf-8");

/*
 * 1.写入内容到文件啊，追加内容到文件
 * 2.打开并读取文件内容
 */

$file = "log.test"; // 要写入文件的文件名，如果不存在则自动创建
$dateTime = date("Y-m-d H:i:s");
$content = $dateTime ."\n".  "当前操作干嘛干嘛了\n";

// 插入内容 FILE_APPEND 追加模式
$filePutContents  = file_put_contents($file,$content,FILE_APPEND);

if ($filePutContents) echo "写入记录成功";

// 读取文件内容

$contents  = file_get_contents($file);

if ( $contents ) {
    echo "日志内容如下：\n" . $contents;
}