<?php

namespace accentry\utils;
class Aes
{
    /**
     * 解密字符串
     * @param string $data 字符串  . $key 密钥 须是16位
     * @return string
     */
    public static function decode($key,$str)
    {
        return openssl_decrypt(self::hex2Str($str),"AES-128-ECB",$key,OPENSSL_RAW_DATA);
    }

    /**
     * 加密字符串
     * @param string $data 字符串   . $key 密钥 须是16位
     * @return string
     */
    public static function encode($key,$str)
    {
        return self::str2Hex(openssl_encrypt($str,"AES-128-ECB",$key,OPENSSL_RAW_DATA));
    }
    
    
    public static function str2Hex($string){
        $hex = '';
        for ($i=0; $i<strlen($string); $i++){
            $ord = ord($string[$i]);
            $hexCode = dechex($ord);
            $hex .= substr('0'.$hexCode, -2);
        }
        return $hex;
    }
    
    public static function hex2Str($hex){
        $string='';
        for ($i=0; $i < strlen($hex)-1; $i+=2){
            $string .= chr(hexdec($hex[$i].$hex[$i+1]));
        }
        return $string;
    }

}
