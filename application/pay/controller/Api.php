<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/7/20
 * Time: 14:46
 */

namespace app\pay\controller;
use AlipayTradeWap\AlipayTradeWapPayContentBuilder;

include EXTEND_PATH . 'alipay/pay/service/AlipayWapPayTradeService.php';
include EXTEND_PATH . 'alipay/pay/buildermodel/AlipayTradeWapPayContentBuilder.php';
class Api
{
    public function pay(){
        // 2.构造参数
        $payRequestBuilder = new AlipayTradeWapPayContentBuilder();
        $payRequestBuilder->setSubject("测试0003");
        $payRequestBuilder->setOutTradeNo("34534123123134564");
        $payRequestBuilder->setTotalAmount(0.01);
        $payRequestBuilder->setTimeExpress('1m');
        // 3.获取配置
        $config = config('alipay');
        $payResponse = new \AlipayWapPayTradeService($config);
        //4.进行请求
        $result=$payResponse->wapPay($payRequestBuilder,$config['return_url'],$config['notify_url']);
        return json($result);
    }
}