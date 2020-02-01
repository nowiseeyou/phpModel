## OpenSSL AES-128-CBC加密 ##

    class AesWithOpenssl
	{   
	    public static $key; // 秘钥
	    public static $iv; // 偏移量
	    
	    public function __construct()
	    {    
	        self::$key = 'D2o4XyQeIFobJ4tS';
	        self::$iv  = 'sciCuBC7orQtDhTO';
	    }
	    
	    public function encryptWithOpenssl($data = '')
	    {   
	        return base64_encode(openssl_encrypt($data, "AES-128-CBC", self::$key, OPENSSL_RAW_DATA, self::$iv));
	    }
	    
	    public function decryptWithOpenssl($data = '')
	    {   
	        
	        return openssl_decrypt(base64_decode($data), "AES-128-CBC", self::$key, OPENSSL_RAW_DATA, self::$iv);
	    }
	}
	// 使用
	$arr = ['status' => '1', 'info' => 'success', 'data' => [['id' => 1, 'name' => '大房间', '2' => '小房间']]];
	$str = json_encode($arr);
	
	$obj = new AesWithOpenssl();
	
	$encrypt_str = $obj->encryptWithOpenssl($str);
	var_dump($encrypt_str);
	echo '<hr/>';
	$decrypt_str = $obj->decryptWithOpenssl($encrypt_str);
	var_dump($decrypt_str);