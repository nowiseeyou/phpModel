## RSA TOKEN ##

	class Token {
	    private $privateKey = "MIICdwIBADANBgkqhkiG9w0BAQEFAASCAmEwggJdAgEAAoGBAKapPgB6HurIXjTj16H9wg8Sj5SDyVpbFL/AQN4KNaGi3aEEIFyHozsi5tXc17FEiv/FFTfMvtGIRpvXnQQLyD5PzGEWuVN6Qm0dvyEn95l9b9806T1QPLgoE9eg6B+irnqYmgeUwDd0j2MvQyHDf36AYHZIMRhNcJCjeUbnWTkdAgMBAAECgYAGTI1AXV0/yHTvENF8mOe1xCDTHywEEz80hCKvgblHM62mwU4r0SCVQptw59jrJUkPo7ZKlp17s+ffSgXwOjXGPUCmlrwWE4F0pKhAwn3It2B1iaCOfYtjEWsWX2esh7YfyySd7ZBH/lGuVeOPeP40tB3+sifN/+tMRblEH+R6jQJBAPkDkXI5bdPldD4ISBLmmdlH7dB750P174LxmSaXC6/Z0sJJJS6YD5FhzHNCO3eByIFL8jgjpYPFxMLweAsl8P8CQQCrVjYgc2lB9F2hGClPF+bSBpHIquvK+LDKh9wJc+nyw1gF0J5gJBFLfiKCWDGVF+PZzTkeKOx10aLyqyLeNHnjAkEAzq3Ke6703En3OEFxaNajXTeZSFB+u+aVm+5g+immFpfJmV5SkSC+0yEEK6oOZ3t96usZKMVVbFCqpk4mpMIiCwJBAJUWBS8jfZl4SuhcH8XE5IIoWT4lC9unnh39LcfD5vPoanVU3BqIB8yKyvhkSXCUQx1H58WIkojKi2Fg7IwxWUUCQGWLYff2+YSWRmc0aQ057qJRRWZ72SQgtQZsJahXGu9arK7V2ZkthXT2RdAWfqkmR85HgB3LaA3AEw83bbqke3E=";
	    private $pubKey = "MIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQCmqT4Aeh7qyF4049eh/cIPEo+Ug8laWxS/wEDeCjWhot2hBCBch6M7IubV3NexRIr/xRU3zL7RiEab150EC8g+T8xhFrlTekJtHb8hJ/eZfW/fNOk9UDy4KBPXoOgfoq56mJoHlMA3dI9jL0Mhw39+gGB2SDEYTXCQo3lG51k5HQIDAQAB";
	    
	    /**
	     * 加密
	     * @param $data         //待加密字符串
	     * @param $privateKey   //私钥
	     * @return string
	     */
	    public function encrypt($data){
	        $privateKey = "-----BEGIN RSA PRIVATE KEY-----\n" .
	            wordwrap($this->privateKey, 64, "\n", true) .
	            "\n-----END RSA PRIVATE KEY-----";
	
	        $key = openssl_get_privatekey($privateKey);
	        openssl_private_encrypt($data, $signature, $key,OPENSSL_ALGO_SHA1);
	        $sign = base64_encode($signature);
	        return $sign;
	    }
	
	    /**
	     * 解密
	     * 校验 sha1WithRSA 签名
	     * @param $data
	     * @param $sign
	     * @param $pubKey
	     * @return bool
	     */
	    public function decrypt($data){
	        $data = base64_decode($data);
	        $decrypt = "";
	        $pubKey = "-----BEGIN PUBLIC KEY-----\n" .
	            wordwrap($this->pubKey, 64, "\n", true) .
	            "\n-----END PUBLIC KEY-----";
	
	        $key = openssl_pkey_get_public($pubKey);
	        openssl_public_decrypt($data, $decrypt, $key, OPENSSL_ALGO_SHA1);
	        return $decrypt;
	    }
	
	}