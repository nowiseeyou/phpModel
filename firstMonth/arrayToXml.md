## arrayToXml ##
	
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