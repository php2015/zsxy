<?php
namespace app\pay\controller;
use think\Controller;
use app\index\controller\Leescoreorder;
use think\Db;
use think\Request;
use think\Session;
use AlipayTradeWap\AlipayTradeWapPayContentBuilder;
include EXTEND_PATH . 'alipay/pay/service/AlipayWapPayTradeService.php';
include EXTEND_PATH . 'alipay/pay/buildermodel/AlipayTradeWapPayContentBuilder.php';
include EXTEND_PATH . 'alipay/pay/buildermodel/AlipayTradeQueryContentBuilder.php';
include EXTEND_PATH . 'alipay/pay/service/AlipayTradeService.php';

include EXTEND_PATH . 'alipay/pay/aop/AopClient.php';
include EXTEND_PATH . 'alipay/pay/aop/SignData.php';
include EXTEND_PATH . 'alipay/pay/aop/request/AlipayFundTransToaccountTransferRequest.php';
include EXTEND_PATH . 'alipay/pay/aop/request/AlipayFundTransOrderQueryRequest.php';
class Index extends Controller
{
  public  function  index(){
     //$sales_id=8723;
    $sales_id=input('sales_id');
    $sales=db('sales')->where('id','=',$sales_id)->find();
    $order_no=$sales['out_trade_no'];//'3453420180720144410';//mt_rand().time();
     // $out_trade_no=input('out_trade_no');
    
    
    
    //dump($leescoreorder);die;
    $price=$sales['total_fee']/100;//'0.01';//$leescoreorder['trade_money'];
    // if($price > 100){
   // $price=$price - 100;
   // }
    $uid=$sales['uid'];
    $time=time();
    $miao='1m';
    $ordernumber="D".$uid.$time;
    $params = [
            'body' =>$ordernumber,
            'out_trade_no' => $order_no,
            'total_fee' =>$price*100, //$price*100
            'product_id' =>$time,
            'pid' => $sales['pid'],
            'uid' =>$uid
        ];
    //$sales_id=db('sales')->insertGetId($params);

    $result=$this->pay($ordernumber,$order_no,$price,$miao);
       return "$result";
   }
    public function pay($ordernumber,$order_no,$price,$miao){
        // 2.构造参数
        
        $payRequestBuilder = new AlipayTradeWapPayContentBuilder();
        $payRequestBuilder->setSubject($ordernumber);
        $payRequestBuilder->setOutTradeNo($order_no);
        $payRequestBuilder->setTotalAmount($price);
        $payRequestBuilder->setTimeExpress($miao);
        // 3.获取配置
        $config = config('queue');
        $payResponse = new \AlipayWapPayTradeService($config);
        //4.进行请求
        $result=$payResponse->wapPay($payRequestBuilder,$config['return_url'],$config['notify_url']);
        return json($result);
    }
     //异步
     public function notify(){
         $out_trade_no=input('out_trade_no');
        //$ord_id=substr($out_trade_no,10);
        //dump($ord_id);die;
        $get_order=db('sales')->where('out_trade_no','=',$out_trade_no)->where('status','=',0)->find();
        //dump($get_order);die;
         if($get_order)
         {
           $data['status']=1;
                     //执行查询
                    $result = db('sales')->where('id', $get_order['id'])->update($data);
                    if($result){
                      $this->order_up($get_order['id']);
                        return 'success';
                    }
          }
    }  
   public function order_up($id)
    {
        // 进行核心业务处理, 如更新状态, 发送通知等等
        // 处理成功, 返回true, 处理失败, 返回false
        // 例如:
      
      //查询有没有订单进来sales表
        
        //执行查询
        //如果有，就不管了，如果没有，改1，并执行其他操作
        	$result = db('sales')->where('id','=', $id)->update(['status'=>1]);
      		$sales = db('sales')->where('id','=', $id)->find();
      		$datass['pay']=1;
          $datass['paytime']=time();
          $datass['paytype']='alipay';
          $datass['order_id']=$sales['out_trade_no'];
          $datass['trade_id']=$sales['transaction_id'];
       		$datass['status']=1;
          $resultsss = db('leescoreorder')->where('id','=', $sales['pid'])->update($datass);
          //	$user=db('user')->where('id','=',$sales['uid'])->find();
          //$user_data['numb']=$user['numb'] + 1;
         // $user_data['id']=$user['id'];
          //$user_up = db('user')->where('id','=', $user_data['id'])->update($user_data);
          	//准备数据，准备插入查询表
         //return $result;
       $Leescoreorder = new Leescoreorder();
     $Leescoreorder ->zhifuss($sales['pid']);
  
    }
  /**
  * @User 一秋
 * @param $userid  用户id
 * @param $out_biz_no 编号
 * @param $payee_account 提现的支付宝账号
 * @param $amount 转账金额
 * @param $payee_real_name 账号的真实姓名
 * @return bool|Exception
 */
public function userWithDraw(){
  				
                $aop = new \AopClient ();
                $config = config('queue');
                $aop->gatewayUrl = $config['gatewayUrl'];//'https://openapi.alipay.com/gateway.do';
                $aop->appId = $config['app_id'];// 'your app_id';
                $aop->rsaPrivateKey = $config['merchant_private_key'];//'请填写开发者私钥去头去尾去回车，一行字符串';
                $aop->alipayrsaPublicKey=$config['alipayrsaPublicKey'];//'请填写支付宝公钥，一行字符串';
                $aop->apiVersion = '1.0';
                $aop->signType = $config['sign_type'];//'RSA2';
                $aop->postCharset=$config['charset'];//'GBK';
                $aop->format='json';
                $request = new \AlipayFundTransToaccountTransferRequest ();
                $request->setBizContent("{" .
                "\"out_biz_no\":\"314232142123\"," .
                "\"payee_type\":\"ALIPAY_LOGONID\"," .
                "\"payee_account\":\"18872695647\"," .
                "\"amount\":\"1\"," .
                "\"payer_show_name\":\"王升升\"," .
                "\"payee_real_name\":\"王升升\"," .
                "\"remark\":\"转账备注\"" .
                "  }");
                $result = $aop->execute($request); 
				
                $responseNode = str_replace(".", "_", $request->getApiMethodName()) . "_response";
  
                $resultCode = $result->$responseNode->code;
  				dump($result);die;
                if(!empty($resultCode)&&$resultCode == 10000){
                echo "成功";
                } else {
                echo "失败";
                }
    }
  	public function tixian($withdraw_id){
      			$withdraw=db('withdraw')->where('id','=',$withdraw_id)->find();
      			$time=time();
      			$out_biz_no='11'.$time;
      			$payee_account=$withdraw['bankcard'];
      			$payer_show_name=$withdraw['banknames'];
      			$payee_real_name=$withdraw['banknames'];
        		$amountss=$withdraw['money'];
      			if($amountss > 9){
                $amount = $amountss*0.994;
                $amount=round($amount,2);
                }
      			$remark='提现成功';
                $aop = new \AopClient ();
                $config = config('queue');
                $aop->gatewayUrl = $config['gatewayUrl'];//'https://openapi.alipay.com/gateway.do';
                $aop->appId = $config['app_id'];// 'your app_id';
                $aop->rsaPrivateKey = $config['merchant_private_key'];//'请填写开发者私钥去头去尾去回车，一行字符串';
                $aop->alipayrsaPublicKey=$config['alipayrsaPublicKey'];//'请填写支付宝公钥，一行字符串';
                $aop->apiVersion = '1.0';
                $aop->signType = $config['sign_type'];//'RSA2';
                $aop->postCharset=$config['charset'];//'GBK';
                $aop->format='json';
                $request = new \AlipayFundTransToaccountTransferRequest ();
                $request->setBizContent("{" .
                "\"out_biz_no\":\"$out_biz_no\"," .
                "\"payee_type\":\"ALIPAY_LOGONID\"," .
                "\"payee_account\":\"$payee_account\"," .
                "\"amount\":\"$amount\"," .
                "\"payer_show_name\":\"$payer_show_name\"," .
                "\"payee_real_name\":\"$payee_real_name\"," .
                "\"remark\":\"转账备注\"" .
                "  }");
     // dump($request);die;
                $result = $aop->execute($request); 
				
                $responseNode = str_replace(".", "_", $request->getApiMethodName()) . "_response";
  
                $resultCode = $result->$responseNode->code;
  				//dump($result);die;
                if(!empty($resultCode)&&$resultCode == 10000){
                  	$w_data['status']=1;
                  $w_data['id']=$withdraw_id;
                  if(db('withdraw')->where('id','=',$withdraw_id)->update($w_data)){
                    $u_data['status']=1;
                    $uid=session('uid');
                    $w_user=db('user')->where('id','=',$uid)->find();
                  	$u_data['id']=$uid;
                    $u_data['money']=$w_user['money'] - $amountss;
                    if(db('user')->where('id','=',$uid)->update($u_data)){
                    return 1;
                    }else {
                     // echo "失败";
                        return 22;
                      }
                  } else {
               // echo "失败";
                  return 22;
                }
                  	
               // echo "成功";
                } else {
               // echo "失败";
                  return 22;
                }
    }
  //提现
     public function usertx()
    { 
          $id=session('uid');
          //查询提现人信息
          //$user=db('user')->where('id','=',$id)->where('status','=','1')->find();
         $user=db('user')
				->alias("a")
				->join("sun_banks b",'a.bid=b.id','LEFT')
				->where('a.id','=',$id)
           		->where('status','=','1')
				->field('a.*,b.bnames,b.zhanghao,b.tnames,b.ttel')
				->find();
      // dump($user);die;
          //判断是否绑定收款账号
          if(empty($user['zhanghao'])){
            return 5;
          }
          //判断是否绑定收款账号
          if(empty($user['bnames'])){
            return 11;
          }
          //查询是否有正在审核的订单
          //$sta=db('withdraw')->where('user_id','=',$id)->where('status','=','0')->find();
          //$array_id=input('array_id');
          //订单状态修改
          if(1 == 1){
            $data=[
              'user_id'=>$id,
              'money'=>input('account'),
              'type'=>$user['bnames'],
              'bankcard'=>$user['zhanghao'],
              'create_time'=>time(),
              'operator'=>'1',
              'status'=>'0',
              'banknames'=>$user['tnames']
              //'pids'=>$array_id
            ];
              //提现的钱必须小于余额
              
              if($user['money']>=$data['money']){
                //提现表插入
                 $withdraw_id=db('withdraw')->insertGetId($data);
                 if($withdraw_id)
                 {
                    
                      /*$array = explode(",",$array_id);
                      $num=count($array);
                      //订单表状态修改为1 
                      for($i=0;$i<$num;$i++){
                        $sun_profit['state']=1;
                        $sun_profit['id']=$array[$i];
                        db('profit')->update($sun_profit);
                      }*/
                    //  return 1;
                   $tixian=$this->tixian($withdraw_id);
                    return $tixian;
                  }else{
                      return 0;
                  } 
              //余额为0提示
              }elseif($user['money']==0){
                return 2;
              }else{
                return 3;
              }
          }else{
              return 4;
            } 
      }
}
