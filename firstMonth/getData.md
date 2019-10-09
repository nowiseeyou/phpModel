## 接收数据 ##


### XML ###

	$response = file_get_contents("php://input");
	$response1 = simplexml_load_string($response, 'SimpleXMLElement', LIBXML_NOCDATA);
	$response2 = json_encode($response1);
	
	$response2 = str_replace("%20"," ",$response2);