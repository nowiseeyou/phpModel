<!DOCTYPE html>
<html>
<head>
    <meta charset='utf-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <title>betLogExportLarge</title>
    <style type="text/css">
        HTML,BODY,DIV,SPAN{padding: 0;margin: 0;}
        DIV,BODY{display: block;overflow: hidden;}
        BODY{width:600px; margin: 0px auto;}
        #wrap{margin-top: 10px;border : steelblue 1px solid; border-radius: 5px;padding: 10px;}
        #downloadWrap{display:none;}
        #progressWrap{height:40px;}
        #barWrap, #progress{float: left;}
        #barWrap{width:400px;height:10px;border: 1px solid #b8daff;border-radius: 5px;margin-top:15px;}
        #progressBar{background-color: #cce5ff;width:0;height:10px;}
        #progress{width:100px;margin-left: 20px;height: 40px;line-height: 40px;}
        #downloadStart{display: block;overflow: hidden;height: 40px;margin: 10px;color:#155724;text-align: center;border: solid 1px #c3e6cb;border-radius: 4px;background-color: #d4edda;line-height: 40px;text-decoration:none;}
    </style>
    <script>
        (function(_get, config)
        {
            var _get = _get || {};
            _get.total = parseInt(_get.total, 10);
            var ajaxUrl = '/exportLargeExecute?';
            var view = {};
            var loadedRows = 0;
            var processRows = 0;
            var processExecuteSended = 0;
            var queryString = '';
            var k;
            var queryParam = ['executeId=' + config.executeId];
            if(config.checkAgent)
            {
                queryParam.push('checkAgent=1');
                queryParam.push('agentUid=' + config.agentUid);
            }
            for(k in _get)
            {
                queryParam.push( encodeURIComponent(k) + '=' + encodeURIComponent(_get[k]) );
            }
            queryString = queryParam.join('&');
            ajaxUrl += queryString;

            var send = function()
            {
                if(processExecuteSended >= config.processes.length)
                {
                    return false;
                }
                var url = ajaxUrl + '&pageToken=' + config.processes[processExecuteSended];
                ajax(url);
                ++processExecuteSended;
            };

            var refreshView = function()
            {
                var rate = (Math.floor(((loadedRows/_get.total) * 10000)) / 100)  + '%';
                view.loadedRows.innerHTML = loadedRows;
                view.processRows.innerHTML = processRows;
                view.progressBar.style.width = rate;
                view.progress.innerHTML = rate;
            };

            var downloadStart = function()
            {
                var downloanLink = document.getElementById('downloadStart');
                downloanLink.href = './exportLargeOutput?id=' + config.executeId + '&process=' + config.processes.length;
                downloanLink.addEventListener('click', function()
                {
                    window.close();
                });
                document.getElementById('downloadWrap').style.display = 'block';
            };

            var result = function()
            {
                var data = JSON.parse(this.responseText);
                if(!data.status)
                {
                    alert(data.msg);
                    return;
                }
                ++processRows;
                loadedRows += data.data.executeRows;
                refreshView();
                if(processRows >= config.processes.length)
                {
                    downloadStart();
                    return;
                }
                send();
            };

            var ajax = function(url)
            {
                var xhr = new XMLHttpRequest();
                xhr.addEventListener('load', result);
                xhr.open('GET', url);
                xhr.send();
            };

            window.addEventListener('DOMContentLoaded', function()
            {
                view.loadedRows = document.getElementById('loadedRows');
                view.processRows = document.getElementById('processRows');
                view.progressBar = document.getElementById('progressBar');
                view.progress = document.getElementById('progress');
                var i = 0;
                for(i = 0; i < config.executeCoreCount; i++)
                {
                    send();
                }
            });

        })(<?php echo json_encode($_GET);?>, <?php echo json_encode($this->__viewData);?>);
    </script>
</head>
<body>
<div id="wrap">
    <div>
        导出总列数 : <?php echo $_GET['total'];?>
    </div>
    <div>
        列数进度 : <span id="loadedRows">0</span> of <?php echo $_GET['total'];?>
    </div>
    <div>
        进程进度 : <span id="processRows">0</span> of <?php echo $this->__viewData['totalProcessRows'];?>
    </div>
    <div id="progressWrap">
        <div id="barWrap">
            <div id="progressBar"></div>
        </div>
        <div id="progress">
            0%
        </div>
    </div>
    <div id="downloadWrap">
        <a id="downloadStart" href="" target="_blank">点我下载</a>
    </div>
</div>
</body>
</html>
