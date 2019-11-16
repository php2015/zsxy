<?php
namespace app\index\controller;

use think\Controller;
use think\Db;

class Insurance extends Controller{

    public static $config = [
        'adCode' => "b8d386d9",
        'url' => "http://xbbapi.data88.cn/insurance/doInsure",
        'sign' => "e80d2a7e8710132807c949cfd2db7a5c",
    ];

    public function index($params = null){
        $data = [];
        $data['adCode'] = self::$config['adCode'];
        $data['policyHolderName'] = $params['name'];
        $data['mobile'] = $params['mobile'];
        $data['policyHolderIdCard'] = $params['card'];
        $data['activityConfigNum'] = 0;
        $data['sign'] = md5($data['adCode'].self::$config['sign'].$data['mobile']);
        $data['fromIp'] = $_SERVER['SERVER_ADDR'];
        $data['userAgent'] = $_SERVER['HTTP_USER_AGENT'];
        $url = self::$config['url'];
        $craw = $this->Post($data, $url,['Content-Type: application/json']);
        $craw = json_decode($craw,true);
        $this->create($data,$craw);
    }


    public function create($data,$json){
         $params = [];
         $params['name'] = $data['policyHolderName'];
         $params['mobile'] = $data['mobile'];
         $params['IdCard'] = $data['policyHolderIdCard'];
         $params['json'] = isset($json) && !empty($json) ? json_encode($json) : '';
         $params['message'] = isset($json['message']) && !empty($json['message']) ? $json['message'] : '失败';
         if(isset($json['status']) && !empty($json['status']) && $json['status'] == 'SUCCEEDED'){
             $params['status'] = 1;
         }else{
             $params['status'] = 0;
         }
         $params['createAt'] = time();
         Db::name('Insurance')->insertGetId($params);
    }


    /**
     *  curl 接口对接
     * @param $PostArry
     * @param $request_url
     * @return bool|string
     */
    public function Post($PostArry, $request_url,$header)
    {
        $postData = json_encode($PostArry);
        //$postDataString = http_build_query($postData);//格式化参数
        $curl = curl_init(); // 启动一个CURL会话
        curl_setopt($curl, CURLOPT_URL, $request_url); // 要访问的地址
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE); // 对认证证书来源的检查
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE); // 从证书中检查SSL加密算法是否存在
        if ( !empty($postData) ) {
            //设置POST请求方式
            curl_setopt($curl ,CURLOPT_POST ,true);
            //设置POST的数据包
            curl_setopt($curl, CURLOPT_POSTFIELDS, $postData);
        }
        if(!empty($header)){
            curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
        }
        curl_setopt($curl, CURLOPT_TIMEOUT, 60); // 设置超时限制防止死循环返回
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $tmpInfo = curl_exec($curl); // 执行操作
        if (curl_errno($curl)) {
            $tmpInfo = curl_error($curl);//捕抓异常
        }
        curl_close($curl); // 关闭CURL会话
        return $tmpInfo; // 返回数据
    }
}