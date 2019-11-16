<?php

namespace app\index\controller;

use think\Controller;

class Reptile extends Controller
{


    public function index($params = null)
    {
        $data = [];
        $data['appId'] = '1974';
        $data['crawlerType'] = 'TongDun';
        $data['username'] = $params['mobile'];
        $data['identityName'] = $params['name'];
        $data['identityNo'] = $params['identityNo']; 
        $data['timestamp'] = time();
        $secret = 'lHgSSdJeyZalbWDiuBiJcAeUFbHQxonTGQAPihNpoyLrUqnvlrmWVPEsfcfOKHtv';
        $str = 'appId='.$data['appId'].'&crawlerType='.$data['crawlerType'].'&identityName='.$data['identityName'].'&identityNo='.$data['identityNo'].'&timestamp='.$data['timestamp'].'&username='.$data['username'].'&secret='.$secret;
        $data['sign'] = md5($str);
        $url = 'http://crawler_gateway.6ack.com/crawler-gateway/crawlers/create';
        $craw = $this->Post($data, $url);
        $craw = json_decode($craw,true);
        if($craw['code'] == '0000'){
           $status = $this->status(['crawlerId'=>$craw['crawlerId'],'crawlerToken'=>$craw['crawlerToken']]);
           if($status['status'] == 'Success'){
               $result = $this->indexs(['method'=>'CrawlerGetData','crawlerId'=>$status['crawlerId'],'crawlerToken'=>$craw['crawlerToken']]);
           }
        }else{
            if($craw['message'] == '账户余额不足'){
                $this->error('账户异常,请联系客服处理');
            }
        }
        return isset($result) ? $result : [];
    }

 


    /**
     * 获取爬起状态
     * @param $data
     * @return mixed
     */
    public function status($data){
        $status = $this->indexs(['method'=>'CrawlerGetInfo','crawlerId'=>$data['crawlerId'],'crawlerToken'=>$data['crawlerToken']]);
        $status = json_decode($status,true);
        if($status['code'] == '0000' and $status['data']['status'] != 'Success'){
            return self::status($data);
        }else{
            return $status['data'];
        }
    }


    /**
     * 获取用户数据
     * @param $data
     * @return bool|string
     */
    public function indexs($data){
        $url = 'http://crawler_gateway.6ack.com/crawler-gateway/crawlers/operate';
        return $this->Post($data, $url);
    }


    /**
     *  curl 接口对接
     * @param $PostArry
     * @param $request_url
     * @return bool|string
     */
    public function Post($PostArry, $request_url)
    {
        $postData = $PostArry;
        $postDataString = http_build_query($postData);//格式化参数
        $curl = curl_init(); // 启动一个CURL会话
        curl_setopt($curl, CURLOPT_URL, $request_url); // 要访问的地址
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE); // 对认证证书来源的检查
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE); // 从证书中检查SSL加密算法是否存在
        curl_setopt($curl, CURLOPT_POST, true); // 发送一个常规的Post请求
        curl_setopt($curl, CURLOPT_POSTFIELDS, $postDataString); // Post提交的数据包
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