<?php
namespace accapys;

use accapys\lib\AccEntryConfig;
use accapys\entity\Request;
use accapys\entity\CollBackResponse;
use accapys\lib\Aes;
use accapys\lib\Rsa;
use accapys\entity\Utils;
use think\Loader;
Loader::import('wxpay.lib.WxPayJsPay');
/**
 *  公众号支付/小程序支付
 * 公众号支付用法:
 * 调用 \wxpay\JsapiPay::getPayParams($params) 即可
 * 小程序支付用法:
 * 调用 \wxpay\JsapiPay::getPayParams($params, $code) 即可
 * 或
 * 调用 \wxpay\JsapiPay::getParams($params, $openId) 即可
 */
class HkPayJsPay
{
    /**
     * 获取支付参数
     * @param  array $params 订单数组
     * @param  string $code  登录凭证(公众号支付无需, 小程序支付需要)
     *
     * 小程序支付, 如果已将openId存入数据库, 可以直接调用 getParams($params, $openId)进行支付, 无需去服务器请求获取openID
     */
    public static function getPayParams($params, $code='')
    {
        $tools = new HkJsPay();
        $openId = $tools->GetOpenid($code);
        return self::getParams($params, $openId);
    }

    /**
     * 获取预支付信息
     *
     * @param array  $params 订单信息
     * @param string $params['body'] 商品简单描述
     * @param string $params['out_trade_no'] 商户订单号, 要保证唯一性
     * @param string $params['total_fee'] 标价金额, 请注意, 单位为分!!!!!
     *
     * @param string $openId 用户身份标识
     *
     * @return array 预支付信息
     */
    public static function getParams($params, $openId='')
    {
        // 1.校检参数
        $that = new self();
        $order = $that->checkParams($params,$openId);

        // 5.组装支付参数
        $tools = new HkJsPay();
        $jsApiParameters = $tools->GetJsApiParametersHX($order);

        // 6.返回支付参数
        return $jsApiParameters;
    }



    /**
     * 生成订单编号
     * @return string
     */
    public function number($stry=''){
        $str = $stry.date('YmdHis').substr(implode(NULL, array_map('ord', str_split(substr(uniqid(), 7, 13), 1))), 0, 8);
        return $str;
    }




    /**
     * 生成随机字符串
     * @return string
     */
    public static function userName($num)
    {
        $chars = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZasdfghjklqwertyuiopzxcvbnm";
        $username = "";
        for ( $i = 0; $i < $num; $i++ )
        {
            $username .= $chars[mt_rand(0, strlen($chars)-1)];
        }
        return $username;
    }


    /**
     *  下单
     * @param $params
     * @param $openId
     */
    public function checkParams($params,$openId){
            $Rsa = new Rsa();

            $Rsa->init(AccEntryConfig::SHA256_PUBLIC_KEY,AccEntryConfig::SHA256_PRIVATE_KEY,AccEntryConfig::SHA256_PRIVATE_KEY_PWD);

            $data = [];
            // 获取页面请求信息
            $data['url'] = AccEntryConfig::IPSURL .'/'. AccEntryConfig::URLINDEX;

            $data['account'] = AccEntryConfig::ACCCODE; //账户号

            $data['trxId'] = $params['body']; //$this->number('D'); //订单号

            $data['productType'] = AccEntryConfig::PRODUCTTYPE;

            $data['sceneType'] = AccEntryConfig::SCENETYPE;

            $data['appId'] = AccEntryConfig::APPID; //应用ID

            $data['openId'] = $openId; //$openid;

            $data['trxDtTm'] = date('Ymd');

            $data['trxCcyCd'] = AccEntryConfig::TRXCCYCD;

            $data['trxAmt'] = $params['total_fee'];

           // $data['notifyUrl'] = "http://www.zsxycx.com/index.php/index/pay/notifys";

            //$data['pageUrl'] = "http://www.zsxycx.com/index/accapy/notify";
      
      		$data['notifyUrl'] = AccEntryConfig::NOTIFYURL;

            //$data['pageUrl'] = AccEntryConfig::PAGEURL;

            $data['expireDtTm'] = date('YmdHis',time()+108000);

            $data['goodsDesc'] = AccEntryConfig::MERNAME;

            $data['extFields'] = ['clientIp' => "192.168.1.1","merCategory"=>"","platUrl"=>"","orderTerminal"=>"","deviceInfo"=>"","deviceType"=>"","gitLat"=>''];

            $signData = Aes::encode(AccEntryConfig::AES_KEY,json_encode($data));
          	file_put_contents("789.txt", $data['trxId']);
      
      		$sign = [];
            $sign['data'] = $signData;
            $sign['encryptType'] = AccEntryConfig::ENCRYPTTYPE;
            $sign['format'] = AccEntryConfig::FORMAT;
            $sign['merCode'] = AccEntryConfig::MERCODE;
            $sign['nonceStr'] =  $this->userName(32);
            $sign['signType'] = AccEntryConfig::SIGNTYPE;
            $sign['ts'] = date('YmdHis');
            $sign['version']  = AccEntryConfig::VERSION;

            $accEntryRequest = new Request($sign['version'], date('YmdHis'),$sign['merCode'],$sign['nonceStr'], $sign['format'],$sign['encryptType'],$signData,$sign['signType']);
            $object = Utils::arr2str(Utils::object_array($accEntryRequest));
            $signObject =  $Rsa->sign($object);
      
      		$sign['sign'] = $signObject;
    
            $json_data = $this->Post($sign,$data['url']);
      
            return $this->notify(json_decode($json_data,true),$sign);
    }

  
   //异步提交
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


  
    //环迅返回参数
    public function notify($order,$params){
        $Rsa = new Rsa();
      
        $Rsa->init(AccEntryConfig::SHA256_PUBLIC_KEY,AccEntryConfig::SHA256_PRIVATE_KEY,AccEntryConfig::SHA256_PRIVATE_KEY_PWD);
      
        ini_set("error_reporting","E_ALL & ~E_NOTICE");
      
      	$decryptData = Aes::decode(AccEntryConfig::AES_KEY,$order['data']);  
      
        $json_data = json_decode($decryptData,true);
      
        $json_payInfo = json_decode($json_data['payInfo'],true);
      
      	return $json_payInfo;
    }



   


    // 组装请求参数
    private function getPostData($params, $openId)
    {
        $input  = new \WxPayUnifiedOrder();
        $input->SetOpenid($openId);
        $input->SetTrade_type("JSAPI");
        // $input->SetGoods_tag("test");
        $input->SetBody($params['body']);
        $input->SetTotal_fee($params['total_fee']);
        $input->SetNotify_url(\WxPayConfig::NOTIFY_URL);
        $input->SetOut_trade_no($params['out_trade_no']);
        return $input;
    }
}
