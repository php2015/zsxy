<?php

namespace app\common\controller;

/**
 * RSA算法类
 * 签名及密文编码：base64字符串/十六进制字符串/二进制字符串流
 * 填充方式: PKCS1Padding（加解密）/NOPadding（解密）
 *
 * Notice:Only accepts a single block. Block size is equal to the RSA key size!
 * 如密钥长度为1024 bit，则加密时数据需小于128字节，加上PKCS1Padding本身的11字节信息，所以明文需小于117字节
 *
 */
class Rsa {

    //private $pubKey = null;
    //private $priKey   = null;
    /**
     * @param string 公钥（验证签名和加密时需要传入）
     */
    public function setPubKey($public_key) {
        $public_key = chunk_split($public_key, 64, "\n");
        $public_key = "-----BEGIN PUBLIC KEY-----\n" . $public_key . "-----END PUBLIC KEY-----\n";
        return openssl_pkey_get_public($public_key);
    }

    /**
     * @param string 私钥文件（签名和解密时传入）
     */
    public function setPrikey($private_key) {
        $private_key = chunk_split($private_key, 64, "\n");

        $private_key = "-----BEGIN RSA PRIVATE KEY-----\n" . $private_key . "-----END RSA PRIVATE KEY-----\n";
        return $private_key;
        //return openssl_get_privatekey($private_key);
        //$this -> priKey = openssl_get_privatekey($private_key);
    }

    /**
     * 私钥加密技术，公钥匹配
     * sign verify 配对，即是签名认证： 常用于各种接口，服务端存储公钥，客户端存储私钥
     */

    /**
     * 生成签名
     *
     * @param string 签名材料
     * @param string 签名编码（base64/hex/bin）
     * @return 签名值
     */
    public function sign($data, $private_key, $code = 'base64') {
        $private_key = $this->setPrikey($private_key);
        $ret = false;
        if (openssl_sign($data, $ret, $private_key, OPENSSL_ALGO_SHA1)) {
            $ret = $this->_encode($ret, $code);
        }
        return $ret;
    }

    /**
     * 验证签名
     *
     * @param string 签名材料
     * @param string 签名值
     * @param string 签名编码（base64/hex/bin）
     * @return bool
     */
    public function verify($data, $sign, $public_key, $code = 'base64') {
        $public_key = $this->setPubKey($public_key);
        $ret = false;
        $sign = $this->_decode($sign, $code);
        if ($sign !== false) {
            switch (openssl_verify($data, $sign, $public_key)) {
                case 1 :
                    $ret = true;
                    break;
                case 0 :
                case -1 :
                default :
                    $ret = false;
            }
        }
        return $ret;
    }

    /**
     * 公钥解密
     *
     * @param string 密文
     * @param string 密文编码（base64/hex/bin）
     * @param int 填充方式（OPENSSL_PKCS1_PADDING / OPENSSL_NO_PADDING）
     * @param bool 是否翻转明文（When passing Microsoft CryptoAPI-generated RSA cyphertext, revert the bytes in the block）
     * @return string 明文
     */
    public function decryptByPublic($data, $public_key, $code = 'base64', $padding = OPENSSL_PKCS1_PADDING, $rev = false) {
        $public_key = $this->setPubKey($public_key);
        $ret = false;
        $data = $this->_decode($data, $code);
        if (!$this->_checkPadding($padding, 'de'))
            $this->_error('padding error');
        if ($data !== false) {
            if (openssl_public_decrypt($data, $result, $public_key, $padding)) {
                $ret = $rev ? rtrim(strrev($result), "\0") : '' . $result;
            }
        }
        return $ret;
    }


    /***
    !!!!长的报文 需要拆分解密
     */
    public function decryptLongStrByPublic($data, $public_key, $code = 'base64', $padding = OPENSSL_PKCS1_PADDING, $rev = false){
        // $encrypted = $this->urlsafe_b64decode($encrypted);
        $public_key = $this->setPubKey($public_key);
        $ret = false;
        $data = $this->_decode($data, $code);
        if (!$this->_checkPadding($padding, 'de'))
            $this->_error('padding error');
        $maxlength = 128;
        $output = '';
        while ($data) {
            $input = substr($data, 0, $maxlength);
            $data = substr($data, $maxlength);
            if ($input !== false) {
                if (openssl_public_decrypt($input, $result, $public_key, $padding)) {
                    $ret = $rev ? rtrim(strrev($result), "\0") : '' . $result;
                    $output.=$ret;
                }
            }
        }
        return $output;
    }

    /*
     * 超长的密文解密，也可以用这个
      参考：http://blog.csdn.net/yafei450225664/article/details/64919383
     */
    public function decryptByPublic_split($data, $public_key){

        $crypto = '';
        foreach (str_split($this->urlsafe_b64decode($data), 128) as $chunk) {
            openssl_public_decrypt($chunk, $decryptData, $this->setPubKey($public_key));
            $crypto .= $decryptData;
        }

        return $crypto;
    }

    public function urlsafe_b64decode($string) {
        $data = str_replace(array('-','_'),array('+','/'),$string);
        $mod4 = strlen($data) % 4;
        if ($mod4) {
            $data .= substr('====', $mod4);
        }
        return base64_decode($data);
    }

    public function urlsafe_b64encode($string)
    {
        $data = base64_encode($string);
        $data = str_replace(array('+', '/', '='), array('-', '_', ''), $data);
        return $data;
    }


    /**
     * 公钥加密，私钥解密
     * encrypt decrypt 配对，用于加解密
     * */

    /**
     * 公钥加密
     *
     * @param string 明文
     * @param string 密文编码（base64/hex/bin）
     * @param int 填充方式（貌似php有bug，所以目前仅支持OPENSSL_PKCS1_PADDING）
     * @return string 密文
     */
    public function encryptByPublic($data, $public_key, $code = 'base64', $padding = OPENSSL_PKCS1_PADDING) {
        $public_key = $this->setPubKey($public_key);
        $ret = false;

        openssl_public_encrypt($data, $encrypted, $public_key); //公钥加密
        $encrypted = base64_encode($encrypted);
        //  echo $encrypted, "\n";

        return $encrypted;
    }



    /****
    !!!!!长报文的加密，需要分段拆分 进行 加密 再拼装起来
    http://blog.csdn.net/yafei450225664/article/details/64919383
    http://blog.csdn.net/leedaning/article/details/51780511
    http://blog.csdn.net/httpp886/article/details/54694903
     ***/
    public function encryptByPublic_split($data, $public_key, $code = 'base64', $padding = OPENSSL_PKCS1_PADDING) {
        $public_key = $this->setPubKey($public_key);
        $ret = false;
        $crypto = '';
        foreach (str_split($data, 117) as $chunk) {
            openssl_public_encrypt($chunk, $encryptData, $public_key);
            $crypto .= $encryptData;
        }
        $encrypted = $this->urlsafe_b64encode($crypto);
        return $encrypted;
    }


    /**
     * 私钥加密
     *
     * @param string 明文
     * @param string 密文编码（base64/hex/bin）
     * @param int 填充方式（貌似php有bug，所以目前仅支持OPENSSL_PKCS1_PADDING）
     * @return string 密文
     */
    public function encryptByPrivate($data, $private_key, $code = 'base64', $padding = OPENSSL_PKCS1_PADDING) {
        $private_key = $this->setPrikey($private_key);
        $ret = false;
        if (!$this->_checkPadding($padding, 'en'))
            $this->_error('padding error');
        if (openssl_private_encrypt($data, $result, $private_key, $padding)) {
            $ret = $this->_encode($result, $code);
        }
        return $ret;
    }

    /**
     * 解密
     *
     * @param string 密文
     * @param string 密文编码（base64/hex/bin）
     * @param int 填充方式（OPENSSL_PKCS1_PADDING / OPENSSL_NO_PADDING）
     * @param bool 是否翻转明文（When passing Microsoft CryptoAPI-generated RSA cyphertext, revert the bytes in the block）
     * @return string 明文
     */
    public function decryptByPrivate($data, $private_key, $code = 'base64', $padding = OPENSSL_PKCS1_PADDING, $rev = false) {
        $private_key = $this->setPrikey($private_key);
        print_R($private_key);
        $ret = false;
        $data = $this->_decode($data, $code);
        echo $data;
        if (!$this->_checkPadding($padding, 'de'))
            $this->_error('padding error');
        if ($data !== false) {
            if (openssl_private_decrypt($data, $result, $private_key, $padding)) {
                $ret = $rev ? rtrim(strrev($result), "\0") : '' . $result;
            }
        }
        return $ret;
    }

    // 私有方法
    /**
     * 检测填充类型
     * 加密只支持PKCS1_PADDING
     * 解密支持PKCS1_PADDING和NO_PADDING
     *
     * @param int 填充模式
     * @param string 加密en/解密de
     * @return bool
     */
    private function _checkPadding($padding, $type) {
        if ($type == 'en') {
            switch ($padding) {
                case OPENSSL_PKCS1_PADDING :
                    $ret = true;
                    break;
                default :
                    $ret = false;
            }
        } else {
            switch ($padding) {
                case OPENSSL_PKCS1_PADDING :
                case OPENSSL_NO_PADDING :
                    $ret = true;
                    break;
                default :
                    $ret = false;
            }
        }
        return $ret;
    }

    private function _encode($data, $code) {
        switch (strtolower($code)) {
            case 'base64' :
                $data = base64_encode('' . $data);
                break;
            case 'hex' :
                $data = bin2hex($data);
                break;
            case 'bin' :
            default :
        }
        return $data;
    }

    private function _decode($data, $code) {
        switch (strtolower($code)) {
            case 'base64' :
                $data = base64_decode($data);
                break;
            case 'hex' :
                $data = $this->_hex2bin($data);
                break;
            case 'bin' :
            default :
        }
        return $data;
    }

    private function _hex2bin($hex = false) {
        $ret = $hex !== false && preg_match('/^[0-9a-fA-F]+$/i', $hex) ? pack("H*", $hex) : false;
        return $ret;
    }

    /**
     * 自定义错误处理
     */
    private function _error($msg) {
        $msg .= "\n";
        file_put_contents(__DIR__ . '/RSA/rsa.log', $msg);
    }

}