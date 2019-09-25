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
        $response = $this->tocurl($url, $header, $content);
        dump($response);


