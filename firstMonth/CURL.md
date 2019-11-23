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



### XML ###


	function post($url, $xml)
	{
	    $ch = curl_init();
	    curl_setopt($ch, CURLOPT_URL, $url);
	    curl_setopt($ch, CURLOPT_POST, 1);
	    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	    curl_setopt($ch, CURLOPT_HEADER, 0);
	    curl_setopt($ch, CURLOPT_POSTFIELDS, $xml);
	    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE); 
	    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
	    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/xml; charset=utf-8', 'Content-Length:' . strlen($xml)));
	    $ret = curl_exec($ch);
	    curl_close($ch);
	    return $ret;
	}
	
	function arrayToXml($arr)
	{
	    $xml = "<xml>";
	    foreach ($arr as $key => $val) {
	        if (is_array($val)) {
	            $xml .= "<" . $key . ">" . arrayToXml($val) . "</" . $key . ">";
	        } else {
	            $xml .= "<" . $key . ">" . $val . "</" . $key . ">";
	        }
	    }
	    $xml .= "</xml>";
	    return $xml;
	}
	
	function xmlToArray($xml)
	{    
	        //禁止引用外部xml实体
	    libxml_disable_entity_loader(true);
	    $values = json_decode(json_encode(simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA)), true);
	    return $values;
	}


### POST json ###

    function curlPostJson($url, $data ,$headers){
	    $ch = curl_init();
	    curl_setopt($ch, CURLOPT_POST, 1);
	    curl_setopt($ch, CURLOPT_URL, $url);
	    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
	    curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_0);
	    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
	    ob_start();
	    curl_exec($ch);
	    $return_content = ob_get_contents();
	    ob_end_clean();
	    $return_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
	    return array($return_code, $return_content);
	}

	$header = array(
	    "Content-Type: application/json; charset=utf-8",
	    "Content-Length: " . strlen(json_encode($body)),
	);

### GET ###

    function _httpGet($url=""){
        
        $curl = curl_init();

        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_TIMEOUT, 500);
        // 为保证第三方服务器与微信服务器之间数据传输的安全性，所有微信接口采用https方式调用，必须使用下面2行代码打开ssl安全校验。
        // 如果在部署过程中代码在此处验证失败，请到 http://curl.haxx.se/ca/cacert.pem 下载新的证书判别文件。
        // curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        // curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl, CURLOPT_URL, $url);

        $res = curl_exec($curl);
        curl_close($curl);

        return $res;
    }