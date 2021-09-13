### 文件下载 ###

        //文件下载
		$url = "www.test.cn";
		$pdfName = url/xxx.pdf
        header("Content-Disposition:  attachment;  filename=" . $pdfName); //告诉浏览器通过附件形式来处理文件
        header('Content-Length: ' . filesize($pdfName)); //下载文件大小
        readfile($pdfName);  //读取文件内容