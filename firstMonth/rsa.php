<?php
//这个是类文件直接引用就行
class rsa  {
    // 私钥;
    public $private_key = '-----BEGIN RSA PRIVATE KEY-----
我方秘钥
-----END RSA PRIVATE KEY-----';
    //公钥
    public $public_key = '-----BEGIN PUBLIC KEY-----
我方公钥
-----END PUBLIC KEY-----';
    //上游公钥
    public $xw_public_key = '-----BEGIN PUBLIC KEY-----
上游公钥
-----END PUBLIC KEY-----';
    public $pi_key;
    public $pu_key;
    public $xw_pu_key;
    //判断公钥和私钥是否可用
    public function __construct()
    {
        $this->pi_key =  openssl_pkey_get_private($this->private_key);//这个函数可用来判断私钥是否是可用的，可用返回资源id Resource id
        $this->pu_key = openssl_pkey_get_public($this->public_key);//这个函数可用来判断公钥是否是可用的
        $this->xw_pu_key = openssl_pkey_get_public($this->xw_public_key);//这个函数可用来判断公钥是否是可用的
    }
    /**
     * @param $data 待签名字符串
     * @param $privateKey
     * @return string 生成的签名
     */
    public function generateSign($data){
        $signature='';
        openssl_sign($data,$signature,$this->pi_key);
        //openssl_free_key($this->pi_key);
        return bin2hex($signature);
    }
    //公钥加密
    public function PublicEncrypt($data){
        $crypto = '';
        foreach (str_split($data, 117) as $chunk) {
            openssl_public_encrypt($chunk, $encryptData, $this->xw_pu_key, OPENSSL_PKCS1_PADDING);
            $crypto .= $encryptData;
        }
        return base64_encode($crypto);
    }
    //私钥解密
    public function PrivateDecrypt($encrypted)
    {
        $crypto = '';
        foreach (str_split(base64_decode($encrypted), 128) as $chunk) {
            openssl_private_decrypt($chunk, $decryptData, $this->pi_key);
            $crypto .= $decryptData;
        }
        return $crypto;
    }
    /**
     * @param $data 待验签数据
     * @param $sign 签名字符串
     * @param $publicKey
     * @return bool
     */
    public function veritySign($data,$sign){
        $result = openssl_verify($data,hex2bin($sign),$this->xw_pu_key);
        return (bool)$result;
    }
}