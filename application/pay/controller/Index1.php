<?php
namespace app\pay\controller;
use think\Controller;
use think\Db;
use think\Request;
use AlipayTradeWap\AlipayTradeWapPayContentBuilder;
include EXTEND_PATH . 'alipay/pay/service/AlipayWapPayTradeService.php';
include EXTEND_PATH . 'alipay/pay/buildermodel/AlipayTradeWapPayContentBuilder.php';
include EXTEND_PATH . 'alipay/pay/buildermodel/AlipayTradeQueryContentBuilder.php';
include EXTEND_PATH . 'alipay/pay/service/AlipayTradeService.php';
class Index extends Controller
{
   public  function  index(){
    $result=$this->pay();
       return "$result";
   }
    public function pay(){
        // 2.构造参数
        $payRequestBuilder = new AlipayTradeWapPayContentBuilder();
        $payRequestBuilder->setSubject("测试0004");
        $payRequestBuilder->setOutTradeNo("3453420180720144402");
        $payRequestBuilder->setTotalAmount(0.01);
        $payRequestBuilder->setTimeExpress('1m');
        // 3.获取配置
        $config = config('queue');
        $payResponse = new \AlipayWapPayTradeService($config);
        //4.进行请求
        $result=$payResponse->wapPay($payRequestBuilder,$config['return_url'],$config['notify_url']);
        return json($result);
    }
}
