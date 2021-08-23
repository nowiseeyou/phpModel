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


	function httpXmlPost($url, $xml)
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
	
	function arrayToXml($data)
    {
        if (!is_array($data) || count($data) <= 0) {
            return false;
        }
        $xml = "<xml>";
        foreach ($data as $key => $val) {
            if (is_numeric($val)) {
                $xml .= "<" . $key . ">" . $val . "</" . $key . ">";
            } else {
                $xml .= "<" . $key . "><![CDATA[" . $val . "]]></" . $key . ">";
            }
        }
        $xml .= "</xml>";
        return $xml;

    }

	$array = array();

	# 方法一
	$xml = new SimpleXMLElement('<xml/>');
	array_walk_recursive(array_flip($array), array ($xml, 'addChild'));
	var_dump($xml->asXML());exit;
	# 方法二
	$rstXml =     arrayToXml($array);
	var_dump($rstXml);die;



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


### POST JSON 普通 ###

	function postJson($url, $json){
	    $header = array('Content-Type: application/json', 'Content-Length:' . strlen($json));
	    $ch = curl_init ($url);
	    curl_setopt($ch, CURLOPT_URL, $url);
	    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // 兼容本地没有指定curl.cainfo路径的错误
	    curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
	    curl_setopt($ch, CURLOPT_POST, 1);
	    curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
	    $response = curl_exec($ch);
	    if(curl_errno($ch)){
	        // 显示报错信息；终止继续执行
	        die(curl_error($ch));
	    }
	    curl_close($ch);
	    return $response;
	}

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


### 接收文件流 ###

    $receiveStreamFile = file_get_contents("php://input")；

### raw ###

	function curl_post($url, $data_string) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'X-AjaxPro-Method:ShowList',
                'Content-Type: application/json; charset=utf-8',
                'Content-Length: ' . strlen($data_string))
        );
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
        $data = curl_exec($ch);
        curl_close($ch);
        return $data;
    }

### GET POST PUT DELETE ###

    /**
     * 发送http请求
     * @param string $url 请求地址
     * @param string $method http方法(GET POST PUT DELETE)
     * @param array $data http请求数据
     * @param array $header http请求头
     * @param Int $type 请求数据类型 0-array  1-jason
     * @return string|bool
     */
    public static function curl_api($url, $method = "POST", $data = array(), $header = array(), $type = '0')
    {
        $method = ucwords($method);
        //检查地址是否为空
        if (empty($url)) {
            return false;
        }
        //控制请求方法范围
        $httpMethod = array('GET', 'POST', 'PUT', 'DELETE');
        $method = strtoupper($method);
        if (!in_array($method, $httpMethod)) {
            return false;
        }
        //请求头初始化
        $request_headers = array();
        $User_Agent = 'Mozilla/5.0 (X11; Linux i686) AppleWebKit/537.31 (KHTML, like Gecko) Chrome/26.0.1410.43 Safari/537.31';
        $request_headers[] = 'User-Agent: ' . $User_Agent;
        if ($header) {
            foreach ($header as $v) {
                $request_headers[] = $v;
            }
        }
        $request_headers[] = 'Accept: text/html,application/json,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8';
        switch ($method) {
            case "POST":
                $request_headers[] = "X-HTTP-Method-Override: POST";
                break;
            case "PUT":
                $request_headers[] = "X-HTTP-Method-Override: PUT";
                break;
            case "DELETE":
                $request_headers[] = "X-HTTP-Method-Override: DELETE";
                break;
            default:
        }
        //发送http请求
        $ch = curl_init();

        switch ($method) {
            case "GET" :
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');//TRUE 时会设置 HTTP 的 method 为 GET，由于默认是 GET，所以只有 method 被修改时才需要这个选项。
                curl_setopt($ch, CURLOPT_HTTPGET, true);//TRUE 时会设置 HTTP 的 method 为 GET，由于默认是 GET，所以只有 method 被修改时才需要这个选项。
                $url = $url . '?' . http_build_query($data);
                break;
            case "POST":
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
                break;
            case "PUT":
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
                break;
            case "DELETE":
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
                break;
            default:
        }

        //格式化发送数据
        if ($data) {
            if ($type) {
                $dataValue = json_encode($data, JSON_UNESCAPED_UNICODE);
            } else {
                $dataValue = http_build_query($data);
            }
            curl_setopt($ch, CURLOPT_POSTFIELDS, $dataValue);
        }
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);//https
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $request_headers);
        curl_setopt($ch, CURLOPT_TIMEOUT, 50);
        //发送请求获取返回响应
        $result = curl_exec($ch);
        if (strlen(curl_error($ch)) > 1) {
            $result = false;
        }
        curl_close($ch);
        return $result;
    }