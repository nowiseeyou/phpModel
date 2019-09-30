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
