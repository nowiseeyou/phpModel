<?php

/**
 * 加密
 * @param $toSign       //待加密字符串
 * @param $privateKey   //私钥
 * @return string
 */
function genSign($toSign, $privateKey){
    $privateKey = "-----BEGIN RSA PRIVATE KEY-----\n" .
        wordwrap($privateKey, 64, "\n", true) .
        "\n-----END RSA PRIVATE KEY-----";

    $key = openssl_get_privatekey($privateKey);
    openssl_sign($toSign, $signature, $key);
    openssl_free_key($key);
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
function verifySign($data, $sign, $pubKey){
    $sign = base64_decode($sign);

    $pubKey = "-----BEGIN PUBLIC KEY-----\n" .
        wordwrap($pubKey, 64, "\n", true) .
        "\n-----END PUBLIC KEY-----";

    $key = openssl_pkey_get_public($pubKey);
    $result = openssl_verify($data, $sign, $key, OPENSSL_ALGO_SHA1) === 1;
    return $result;
}



/**
 *  分段解密
 **/
function decrypt($data,$merPriKey) {
    //拼接字符串
    $priKey = "-----BEGIN RSA PRIVATE KEY-----\n" . wordwrap($merPriKey, 64, "\n", true) ."\n-----END RSA PRIVATE KEY-----";
    return $priKey;
    $decodes = str_split(base64_decode($data), 256);
    $strnull = "";
    $dcyCont = "";
    foreach ($decodes as $decode) {
        if (!openssl_private_decrypt($decode, $dcyCont, $priKey)) {
            echo "<br/>" . openssl_error_string() . "<br/>";
        }
        $strnull .= $dcyCont;
    }
    return $strnull;
}