<?php

namespace app\index\controller;


use app\common\controller\Rsa;
use think\Controller;

class Longterm extends Controller{


    public static $config = [
        'publicKey' => "MIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQDmxc30/6Bu6Da0zILzSREgngwpR27i/CeQHWigvI3G6W08c5t7HpSFuktpSlbWpxSnAmQqz/gv86ahvXbRhcEScMyZM42frKe5XCI/YEm8C4KVHRXOI66z50THCtM2k9tiU08uBa/B7NMKvMDgnhi6tV7VrpBBgbvXmvedBUTwZwIDAQAB",
        'url' => "http://123.56.41.25:9995/CloudUIP/szrService/doInvoke",
        'privateKey' => "MIICdgIBADANBgkqhkiG9w0BAQEFAASCAmAwggJcAgEAAoGBAJAs+k28dJUFYfNtk/oy1ZP/uwZdsOLyBQvJQD4udkjCNxCw6cs7/DyaxwFPNdm2046vjhuGzya0g7lBomV8tQB1K7ZrVRptMZmz8VOQvs6j8bwAxmzBaueL9b+gNPGRZlIN5lDsj8r1K4PRl+Wi5zpnDsaNVbHB5z51nwPn1TY/AgMBAAECgYAo0BKrHsYByVxJBKP3F5zOIH5Y9vyzwb8b7wR4lb52KkRcPThxh7GHlmjvPfUIhHCu25Nmx2qskj0XnDTUddDmuOh6sFG6pKNvdK2RNZjr0iSxbR21VWQK7m+8kqugVpU2pUJERWMlpUZ9aIUpj/VIo9ONcwSlZdjvuVK+5tIuAQJBAO7dwMnnE5iVtAGpFuajlrguQU5SNGj3Yyxro2lBdm/EiLLNlYwcwkRvC5PdJf6giWi5uEe9bRVRlhQKylVS/uECQQCahHGXGjKtxwESeZyNQ7Z/rq0fF5ErK94yyzNA4jffNaPmEWzIOetR9mOAQrkrFMknc2VkJQNJlel7RC/yUHkfAkAiXroc0ykYrYHHM2NeMG/BdLZk5KMx71bPz3Ul8gturaLVx4sbLBAv9KJ/1jRfXQ4oiYCgofsOND0aCStv949BAkBLd86m93OzLpRWerE8ycqz+BO0MOWFSWrAMkD5OsQBMAi6EN6puKg3ovicJ3qbEQ7iRtlJnU5KvX6I5xfn6OgPAkEAmJaFyv1szEyO62nK0E8h9Z/DHswiD2lOUQgLKG71i1NWIf5zxE3lQOiZTnLSnj3OUH/oOIT3xp43guLRN9Im8A==",
    ];
    private $rsa;
    private $error; // 错误结果

    public function __construct() {
        /**
         * 账号配置文件
         */
        $this->rsa = new Rsa();
    }


    /**
     * 解密
     * @param $str
     * @return string
     */
    public function decryptByPublic($str) {
        return $this->rsa->decryptByPublic_split($str, self::$config['publicKey']);
    }

    /**
     * 公钥加密，私钥解密
     * @param $str
     * @return mixed
     */
    public function encryptByPublic($str) {
        //!!!!如果原始报文过长，需要分段拆分进行加密 再组装（encryptByPublic_split）
        return $this->rsa->encryptByPublic_split($str, self::$config['publicKey']);
    }



	public function cedata(){
		 $data['idno'] = '440982199102224299';
        $data['name'] = '陈建琪';
        $data['serviceCode'] = 'XLoanHistoryApplyAction';
        $arr = $this->gets($data);
        
        echo "<pre>";
        var_dump($arr);die;
	}
	
	
	 /**
     * 根据姓名，身份证获取学籍信息
     * @param $name 姓名
     * @param $idcode 身份证
     * @return []
     */
    public function gets($data) {
        // 加密参数
        //$data['idno'] = '500239198712088209';
        //$data['name'] = '刘晓涛';
        //$data['serviceCode'] = 'XLoanHistoryApplyAction';
        $enparams = $this->getEncryptParams($data);
        if (empty($enparams)) {
            $this->setError(11, "提交参数为空");
            return false;
        }
        // 发送请求
        $resxml = $this->sent($enparams);
        $res = json_decode($resxml, TRUE);
        
        return $res;
        // 解析响应
        if ($res['message']['status'] == 000000 && !empty($res['body'])) {
            //!!!!如果待解密的原始报文过长，需要分段拆分进行解密 再组装  （decryptLongStrByPublic）
            $arr = json_encode($res['body']['result_detail']) ;
        }else{
            $arr = json_encode([]) ;
        }
        return $arr;
    }


    /**
     * 根据姓名，身份证获取学籍信息
     * @param $name 姓名
     * @param $idcode 身份证
     * @return []
     */
    public function get($data) {
        // 加密参数
        //$data['idno'] = '500239198712088209';
        //$data['name'] = '刘晓涛';
        //$data['serviceCode'] = 'XLoanHistoryApplyAction';
        $enparams = $this->getEncryptParams($data);
        if (empty($enparams)) {
            $this->setError(11, "提交参数为空");
            return false;
        }
        // 发送请求
        $resxml = $this->sent($enparams);
        $res = json_decode($resxml, TRUE);
        // 解析响应
        if ($res['message']['status'] == 000000 && !empty($res['body'])) {
            //!!!!如果待解密的原始报文过长，需要分段拆分进行解密 再组装  （decryptLongStrByPublic）
            $arr = json_encode($res['body']['result_detail']) ;
        }else{
            $arr = json_encode([]) ;
        }
        return $arr;
    }


    /**
     * 错误信息处理
     */
    public function setError($status, $data) {
        $this->error = ['status' => $status, 'data' => $data];
    }

    /**
     * 返回错误
     */
    public function getError() {
        return $this->error;
    }



    /**
     * 加密各参数
     * @param $name 姓名
     * @param $idcode 身份证
     */
    private function getEncryptParams($datas) {
        if (!is_array($datas) || empty($datas)) {
            return null;
        }
        $data['header']['orgCode'] = "hbnnx";
        $data['header']['orgName'] = "年年祥";
        $data['header']['orgUser'] = "hbnnxuser";
        $data['header']['orgPwd'] = 'hbnnxadmin';
        $data['header']['orgReqNo'] = time();
        $data['header']['serviceCode'] = $datas['serviceCode'];;
        $data['header']['key'] = self::$config['publicKey'];
        $dataa['idno'] = $datas['idno'];
        $dataa['name'] = $datas['name'];
        //如果 待加密报文 过长 ，需要分段拆分加密后 再组装
        $data['body'] = $dataa;//$this->encryptByPublic(json_encode($dataa),$data['header']['key']);
        return $data;
    }



    public function Encrypt($data, $key) {
        $decodeKey = base64_decode($key);
        $iv = substr($decodeKey, 0, 16);
        $encrypted = mcrypt_encrypt(MCRYPT_RIJNDAEL_128, $decodeKey, $data, MCRYPT_MODE_CBC, $iv);
        return $encrypted;
    }

    public function Decrypt($data, $key) {
        $decodeKey = base64_decode($key);
        $iv = substr($decodeKey, 0, 16);
        $encrypted = mcrypt_decrypt(MCRYPT_RIJNDAEL_128, $decodeKey, $data, MCRYPT_MODE_CBC, $iv);
        return $encrypted;
    }



    /**
     * 向服务端发送xml请求
     * @param $xml
     */
    private function sent($data) {
        $a['szrData'] = json_encode($data);
        $url = "http://uipcore.rongsz.com/szrService/doInvoke";

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        // 设置是否返回信息
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        // 设置超时时间
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 8);
        if (!!$data) {
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $a);
        }
        //接受返回信息
        $curl_result = curl_exec($ch);
        if (curl_error($ch))
            return false;
        curl_close($ch);
        return $curl_result;
    }




    function Post($PostArry,$request_url)
    {
        //$postData = $PostArry;
        $postDataString = http_build_query($PostArry);//格式化参数
        $curl = curl_init(); // 启动一个CURL会话
        curl_setopt($curl, CURLOPT_URL, $request_url); // 要访问的地址
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE); // 对认证证书来源的检查
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE); // 从证书中检查SSL加密算法是否存在
        curl_setopt($curl, CURLOPT_POST, true); // 发送一个常规的Post请求
        curl_setopt($curl, CURLOPT_POSTFIELDS, $PostArry); // Post提交的数据包
        curl_setopt($curl, CURLOPT_TIMEOUT, 60); // 设置超时限制防止死循环返回
        curl_setopt($curl,CURLOPT_RETURNTRANSFER,true);

        $tmpInfo = curl_exec($curl); // 执行操作
        if (curl_errno($curl)) {

            $tmpInfo = curl_error($curl);//捕抓异常
        }
        curl_close($curl); // 关闭CURL会话
        return $tmpInfo; // 返回数据
    }
}