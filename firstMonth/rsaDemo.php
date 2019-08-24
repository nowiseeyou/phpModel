<?php

/**
 * 加密
 * @param $toSign       //呆加密字符串
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