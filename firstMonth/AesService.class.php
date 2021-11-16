<?php

namespace Api\Service;

/**
 * mcrypt_encrypt 加密
 * php7.1开始被丢弃 可以使用openssl_encrypt
 *
 */
class AesService
{

    private $cipher = MCRYPT_RIJNDAEL_128;

    private $mode = MCRYPT_MODE_ECB;

    private $private_key = '1234567812345678';
    private $iv         = "1234567812345678";


    public function __construct($private_key = null)
    {
        if($private_key){
            $this->private_key = $private_key;
        }
    }

    /**
     * 加密
     *
     * @param string $str 需加密的字符串
     *
     * @return string
     */
    public function encode($str)
    {
        $str         = $this->addPKCS7Padding($str);
        $encrypt_str = mcrypt_encrypt($this->cipher, $this->private_key, $str, $this->mode, $this->iv);
        return base64_encode($encrypt_str);
    }

    /**
     * 解密
     *
     * @param string $str
     *
     * @return string
     */
    public function decode($str)
    {
        $str         = base64_decode($str);
        $encrypt_str = mcrypt_decrypt($this->cipher, $this->private_key, $str, $this->mode, $this->iv);
        $encrypt_str = self::removePKSC7Padding($encrypt_str);
        return $encrypt_str;

    }

    // 填充算法
    private function addPKCS7Padding($source)
    {
        $source = trim($source);
        $block  = mcrypt_get_block_size($this->cipher, $this->mode);
        //$block = 32;
        $pad = $block - (strlen($source) % $block);
        if ($pad <= $block) {
            $char   = chr($pad);
            $source .= str_repeat($char, $pad);
        }
        return $source;
    }

    // 移去填充算法
    private function removePKSC7Padding($source)
    {
        $char   = substr($source, -1);
        $num    = ord($char);
        $source = substr($source, 0, -$num);
        return $source;
    }

}