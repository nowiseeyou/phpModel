## CURL 请求 ##

    function curlPost($url,$content,$header){
		$ch = curl_init();
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($content));
        curl_setopt($ch, CURLOPT_TIMEOUT, 30); //30秒超时
        $response = curl_exec($ch);
        if($error=curl_error($ch)){
            die($error);
        }
        curl_close($ch);
        return $response;
	}

调用方法：

    	$url = 'http://api.test.com';
        //头部
        $header = array('t:1115456465','appkey:10000000');
        //参数
        $content = array(
            'name' => 'fdipzone'
        );
        $response = curlPost($url, $content, $header);
        dump($response);



## x-www-form-urlencoded ##

	function curlPost($url, $data)
	{
	    $ch = curl_init();
	    curl_setopt($ch, CURLOPT_URL, $url);
	    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
	    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 100);
	    curl_setopt($ch, CURLOPT_TIMEOUT, 100);
	    curl_setopt_array($ch, array(
	        CURLOPT_HTTPHEADER => array(
	            "content-type: application/x-www-form-urlencoded",
	        ),
	        CURLOPT_SSL_VERIFYPEER => false,
	        CURLOPT_SSL_VERIFYHOST => false,
	    ));
	
	    $result = curl_exec($ch);
	    curl_close($ch);
	    return $result;
	}


##  CURLOPT_RETURNTRANSFER 抓取数据直接返回 ##

	function http_post_data($payurl,$param,$headers){
	
	    $curl = curl_init(); // 启动一个CURL会话
	
	    curl_setopt($curl, CURLOPT_URL, $payurl); // 要访问的地址
	
	    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0); // 对认证证书来源的检查
	
	    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0); // 从证书中检查SSL加密算法是否存在
	
	    curl_setopt($curl, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']); // 模拟用户使用的浏览器
	
	    curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1); // 使用自动跳转
	
	    curl_setopt($curl, CURLOPT_AUTOREFERER, 1); // 自动设置Referer
	
	    curl_setopt($curl, CURLOPT_POST, 1); // 发送一个常规的Post请求
	
	    curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($param)); // Post提交的数据包
	
	    curl_setopt($curl, CURLOPT_TIMEOUT, 30); // 设置超时限制防止死循环
	
	    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1); //抓取结果直接返回（如果为0，则直接输出内容到页面）
	
	    curl_setopt($curl, CURLOPT_HEADER, 0); // 显示返回的Header区域内容
	
	    curl_setopt($curl, CURLOPT__POSTTRANSFER, 1); // 获取的信息以文件流的形式返回
	
	    curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
	
	    $result = curl_exec($curl); // 执行操作
	
	    if (curl_errno($curl)) $result = curl_error($curl);//捕抓异常
	
	    curl_close($curl); // 关闭CURL会话
	
	    return $result;
	
	}



