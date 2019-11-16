<?php
namespace app\index\controller;

use think\Controller;

class Xorpay extends Controller {


    protected static $config = [
        'name' => '数据查询',
        'pay_type'=> 'jsapi',
        'notify_url' => 'http://www.zsxycx.com/index/xnutify/notifyProcess',
        'more' => '',
        'expire' => '60',//单过期时间
        'secret' => '974ff4c5219c48b3b6bf373905e58893', # app secret, 在个人中心配置页面查看
        'api_url' => 'https://xorpay.com/api/pay/6581', # 付款请求接口，在个人中心配置页面查看
    ];


    /**
     * 获取用户openid
     */
    public function openid(){
       $url = 'https://xorpay.com/api/openid/6581?callback=http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
       header("Location:".$url);
    }
  
   

    /**
     * 支付
     * @param $params
     * @param string $openid
     * @return mixed
     */
    public function pay($params='',$openid = ''){
       if(empty($openid)){
           $openid = $this->openid();
        }
        $config = self::$config;
        $data = [
            'name' => $params['body'],
            'pay_type' => $config['pay_type'],
            'price' => $params['total_fee'] / 100,
            'order_id' => $params['out_trade_no'],
            'notify_url' => $config['notify_url'],
            'openid' => $openid,
            'more' => $config['more'],
            'expire' => $config['expire'],
        ];
        $secret = $config['secret'];     # app secret, 在个人中心配置页面查看
        $api_url = $config['api_url'];   # 付款请求接口，在个人中心配置页面查看

        $data['sign'] = md5(join('',[$data['name'], $data['pay_type'], $data['price'], $data['order_id'], $data['notify_url'],$secret]));

        $json = $this->Post($data,$api_url);
        $json_data = json_decode($json,true);
        //$this->assign('info',json_encode($json_data['info']));
        return json_encode($json_data['info']);
        //return $this->fetch();
    }


    /**
     * post 提交数据
     * @param $PostArry
     * @param $request_url
     * @return bool|string
     */
    public function Post($PostArry,$request_url){
        $postData = $PostArry;
        $postDataString = http_build_query($postData);//格式化参数
        $curl = curl_init(); // 启动一个CURL会话
        curl_setopt($curl, CURLOPT_URL, $request_url); // 要访问的地址
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE); // 对认证证书来源的检查
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE); // 从证书中检查SSL加密算法是否存在
        curl_setopt($curl, CURLOPT_POST, true); // 发送一个常规的Post请求
        curl_setopt($curl, CURLOPT_POSTFIELDS, $postDataString); // Post提交的数据包
        curl_setopt($curl, CURLOPT_TIMEOUT, 60); // 设置超时限制防止死循环返回
        curl_setopt($curl,CURLOPT_RETURNTRANSFER,true);
        $tmpInfo = curl_exec($curl); // 执行操作
        if (curl_errno($curl)) {
            $tmpInfo = curl_error($curl);//捕抓异常
        }
        curl_close($curl); // 关闭CURL会话
        return $tmpInfo; // 返回数据
    }
  
  
  
  /* get方式调取数据 */
  public function Get($get_token_url){
  		$ch = curl_init();
 
		curl_setopt($ch,CURLOPT_URL,$get_token_url);
 
		curl_setopt($ch,CURLOPT_HEADER,0);
 
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1 );
 
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
 
		$res = curl_exec($ch);
 
		curl_close($ch);
      
    
    echo "<pre>";
    var_dump($res);die;
    
      	$json_obj = json_decode($res,true);
    
    	return $json_obj;
  }

}