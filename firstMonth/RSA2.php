<?php
/**
 * Name: RSA 1024 私钥加密
 * User: Scrpersist
 * Date: 2018/12/26 23:27
 * @string $json
 * @string $private_key
 * @return bool|string
 */
function privateEncrypt($json,$private_key)
{
    $encrypted = '';
    $pi_key = openssl_pkey_get_private($private_key);//这个函数可用来判断私钥是否是可用的，可用返回资源id Resource id
    //最大允许加密长度为117，得分段加密
    $plainData = str_split($json, 100);//生成密钥位数 1024 bit key
    foreach($plainData as $chunk)
    {
        $partialEncrypted = '';
        $encryptionOk = openssl_private_encrypt($chunk,$partialEncrypted,$pi_key);//私钥加密
        if($encryptionOk === false)
        {
            return false;
        }
        $encrypted .= $partialEncrypted;
    }
    $encrypted = base64_encode($encrypted);//加密后的内容通常含有特殊字符，需要编码转换下，在网络间通过url传输时要注意base64编码是否是url安全的
    $encrypted = str_replace(array('+','/','='),array('-','_',''),$encrypted);//base64url安全处理
    return $encrypted;

}

/**
 * Name: RSA 1024 私钥解密
 * User: Scrpersist
 * Date: 2018/12/26 23:28
 * @param $data
 * @param $private_key
 * @return bool|string
 */
function privateDecrypt($data,$private_key)
{
    $decrypted = '';
    $pi_key = openssl_pkey_get_private($private_key);
    $plainData = str_split(base64_decode($data), 128);
    foreach($plainData as $chunk)
    {
        $str = '';
        $decryptionOk = openssl_private_decrypt($chunk,$str,$pi_key);//私钥解密
        if($decryptionOk === false)
        {
            return false;
        }
        $decrypted .= $str;
    }
    return $decrypted;
}

/**
 * Name: RSA 1024 公钥加密
 * User: Scrpersist
 * Date: 2018/12/26 23:27
 * @string $json
 * @string $private_key
 * @return bool|string
 */
function publicEncrypt($json,$public_key)
{
    $encrypted = '';
    $pi_key = openssl_pkey_get_public($public_key);//这个函数可用来判断私钥是否是可用的，可用返回资源id Resource id
    //最大允许加密长度为117，得分段加密
    $plainData = str_split($json, 100);//生成密钥位数 1024 bit key
    foreach($plainData as $chunk)
    {
        $partialEncrypted = '';
        $encryptionOk = openssl_public_encrypt($chunk,$partialEncrypted,$pi_key);//私钥加密
        if($encryptionOk === false)
        {
            return false;
        }
        $encrypted .= $partialEncrypted;
    }

    $encrypted = base64_encode($encrypted);//加密后的内容通常含有特殊字符，需要编码转换下，在网络间通过url传输时要注意base64编码是否是url安全的
    $encrypted = str_replace(array('+','/','='),array('-','_',''),$encrypted);//base64url安全处理
    return $encrypted;

}

/**
 * Name: RSA 1024 公钥解密
 * User: Scrpersist
 * Date: 2018/12/26 23:28
 * @param $data
 * @param $private_key
 * @return bool|string
 */
function publicDecrypt($data,$public_key)
{
    $decrypted = '';
    $pi_key = openssl_pkey_get_public($public_key);
    $plainData = str_split(base64_decode($data), 128);
    foreach($plainData as $chunk)
    {
        $str = '';
        $decryptionOk = openssl_public_decrypt($chunk,$str,$pi_key);//私钥解密
        if($decryptionOk === false)
        {
            return false;
        }
        $decrypted .= $str;
    }
    return $decrypted;
}

/**
 * Name: 让进行过url安全处理的base64字符串正常化
 * User: Scrpersist
 * Date: NOW_TIME
 * @param $string
 * @return mixed|string
 */
function base64_url_safe_decode($string)
{
    $data = str_replace(array('-','_'),array('+','/'),$string);
    $mod4 = strlen($data) % 4;
    if ($mod4)
    {
        $data .= substr('====', $mod4);
    }
    return $data;
}