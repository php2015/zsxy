<?php
namespace app\index\controller;

use accapys\entity\CollBackResponse;
use accapys\entity\Utils;
use accapys\lib\AccEntryConfig;
use accapys\lib\Aes;
use accapys\lib\Rsa;
use app\common\model\Profit as ProfitModel;
use think\Controller;
use think\Db;
use think\Session;
use PHPExcel_IOFactory;
use PHPExcel;
use Corebairo\Corebairo;
use accapys\Notify;
use Con\Con;
use app\index\controller\Insurance;
header("content-type:text/html;charset=utf8");
/**
 * 奖励明细
 * Class Order
 * @package app\admin\controller
 */
class Pay extends Controller
{
    public function notify(){
    $xml = $GLOBALS['HTTP_RAW_POST_DATA'];
      if(!$xml){
            $xml = file_get_contents("php://input");
        }
    file_put_contents("2.txt",$xml);
	file_put_contents("3.txt",'123');
    $notify = new \wxpay\Notify();
    $result=$notify->Handle();
    file_put_contents("1.txt",json_encode($result));
  }
  
  
  
 
  
  
  
  public function hxnotify(){
   		$Rsa = new Rsa();
        $Rsa->init(AccEntryConfig::SHA256_PUBLIC_KEY, AccEntryConfig::SHA256_PRIVATE_KEY, AccEntryConfig::SHA256_PRIVATE_KEY_PWD);
        ini_set("error_reporting", "E_ALL & ~E_NOTICE");
        // 获取返回数据
        $data = $_REQUEST['data'];
    	$verifyObject = null;
        $decryptData = null;
        $verifyResult = false;
        $decryptData = Aes::decode(AccEntryConfig::AES_KEY, $data);
    	$result = json_decode($decryptData,true);
        if($result['trxResultMsg'] == '支付成功'){
           	$notify = new Notify();
            $status = $notify->NotifyProcess($result);
            if($status){
                return 'ipscheckok';
            }
        }
  }
  
  
  
  public function tiaozhuan(){
    	$dingdanid=input('dingdanid');
   		Session::delete('order_no');
    	$this->assign("dingdanid",$dingdanid);
        return $this->fetch('tiaozhuan');
  }
  
  
  public function tishi(){
  	return $this->fetch();
  }
  
  
  
  //转换数据
   public function getFile($params){
    		if(!empty($params)){
    	   		$get = explode('|',$params['data']);
           		$data = [];
           		foreach($get as $key => $value){
           			$va = explode('_',$value);
                	$data[$va[0]] = $va[1]; 
          	 	}
    		}
            $data['openid'] = isset($params['openid']) && !empty($params['openid']) ? $params['openid'] :'';
         	return $data;
	}  
  
  
  public function payss(){
  	echo '<p style="font-size:100px;text-align: center;margin-top:500px;">系统升级中，预计一个小时</p>';die;
    $is_weixin=$this->isWeiXinBrowser();
    $params = $this->request->param();
    $data = $this->getFile($params);
    $order_no=mt_rand().time();
    $price = $data['price'];
    $sid = $data['pid'];
    $uid = $data['uid'];
    $product=db('product')->where('id','=',$sid)->find(); 
    $fpid=$product['uid'];
    $sessionid=$uid;
    $baseuid=base64_encode(base64_encode($uid));
    $this->assign('uid',$baseuid);
    $time=time();
    $ordernumber="D".$uid.$time;
    $params = [
            'body' =>$ordernumber,
            'out_trade_no' => $order_no,
            'total_fee' => $price * 100,
            'product_id' =>$time,
            'pid' =>$sid,
            'uid' =>$uid,
            'sessionid' =>$sessionid,
            'sessionfpid' =>$fpid,
      		'createAt' => time(),
        ];
    if($is_weixin){  
        $xorpay = new Xorpay();
      	$result = $xorpay->pay($params,$data['openid']);
       if(!empty($data['openid'])){
       		$sales_id = db('sales')->insertGetId($params);
          	$this->assign("order_no",$params['out_trade_no']);
         	$this->assign("price",$params['total_fee']);
            $this->assign("result",$result);
            return $this->fetch('pay');
    	}
    }else{
     // echo '<p style="font-size:100px;text-align: center;margin-top:500px;">请在微信客户端打开</p>';die;
      $sales_id=db('sales')->insertGetId($params);
          $s_order_no=session('order_no');
           if(empty($s_order_no)){
              //保存订单id
              session('order_no',$order_no);
               $this->assign("order_no",$order_no);
          }else{
             //删除订单id
           $sales_s=db('sales')->where('out_trade_no','=',$s_order_no)->where('status','=',1)->where('uid','=',$uid)->find();
             if(!empty($sales_s)){
               $this->assign("order_no",$sales_s['out_trade_no']);
             }else{
               $this->assign("order_no",$s_order_no);
             }
           }
        $this->assign("price",$price);
      	$this->assign("uid",$uid);
      	$this->assign("pid",$sid);
        return $this->fetch('hpay');
    }
    
  }  
  
  
  

  public function pay(){
    $is_weixin=$this->isWeiXinBrowser();
    $order_no=mt_rand().time();
    $price=input('price');
    $sid=input('pid');
    $uid=input('uid');
    $insurance = input('insurance');
    if(!empty($insurance) && $insurance == 1){
    	$this->insu($insurance,$uid);
    }
    $product=db('product')->where('id','=',$sid)->find();
    $fpid=$product['uid'];
    $sessionid=$uid;
    $baseuid=base64_encode(base64_encode($uid));
    $this->assign('uid',$baseuid);
    $time=time();
    $ordernumber="D".$uid.$time;
    
    if($price < $product['price']){
    	echo '<p style="font-size:100px;text-align: center;margin-top:500px;">该链接已失效！</p>';die;
    }
    $params = [
            'body' =>$ordernumber,
            'out_trade_no' => $order_no,
            'total_fee' =>$product['price']*100, //$price*100
            'product_id' =>$time,
            'pid' =>$sid,
            'uid' =>$uid,
            'sessionid' =>$sessionid,
            'sessionfpid' =>$fpid,
            'createAt' => time(),
        ];
    $sales_id=db('sales')->insertGetId($params);
    if ($is_weixin){
    	//return $this->fetch('tishi');
     	// echo '<p style="font-size:100px;text-align: center;margin-top:500px;">系统升级中，预计半小时恢复。给您带来不便，敬请见谅！</p>';die;
      $code=@$_GET["code"];
      if ($code){
        	  $result = \wxpay\JsapiPay::getPayParams($params,$code);
        	  $this->assign("order_no",$order_no);
        	  $this->assign("result",$result);
              $this->assign("price",$price);
        	  return $this->fetch();
      }else{
        $result = \wxpay\JsapiPay::getPayParams($params);
      }
    }else{
    //	echo '<p style="font-size:100px;text-align: center;margin-top:500px;">系统升级中，预计半小时恢复。给您带来不便，敬请见谅！</p>';die;
     // $result = \wxpay\WapPay::getPayUrl($params);
          $s_order_no=session('order_no');
           if(empty($s_order_no)){
              //保存订单id
              session('order_no',$order_no);
               $this->assign("order_no",$order_no);
          }else{
             //删除订单id
           $sales_s=db('sales')->where('out_trade_no','=',$s_order_no)->where('status','=',1)->where('uid','=',$uid)->find();
           
             if(!empty($sales_s)){
               $this->assign("order_no",$sales_s['out_trade_no']);
             }else{
               $this->assign("order_no",$s_order_no);
             }
           }
      //  $this->assign("result",$result);
        $this->assign("price",$product['price']);
      	$this->assign("uid",session('uid'));
        return $this->fetch('hpay');
    }
    
  }
  
  
  public function insu($insurance='',$uid=''){
  	if(!empty($insurance) && $insurance == 1){
      		$ln = new Insurance();
      		$user = db('user')->where('id','=',$uid)->find();
      		if(!empty($user)){
      			$insu = db('Insurance')->where(['mobile'=>$user['mobile']])->find();
      			if(empty($insu)){
      				$age = date('Y') - substr($user['idcard'], 6, 4) + (date('md') >= substr($user['idcard'], 10, 4) ? 1 : 0);
                    if($age >= 25 && $age <= 50){
                    		$ln->index(['name'=>$user['names'],'card'=>$user['idcard'],'mobile'=>$user['mobile']]);
                    }
      			}
      		}
      }
  }
  
  

 
   public function hxpay(){
        $is_weixin = $this->isWeiXinBrowser();
        $order_no = mt_rand() . time();
        $price = input('price');
        $sid = input('pid');
        $uid = input('uid');
        $product = db('product')->where('id', '=', $sid)->find();
        $fpid = $product['uid'];
        $sessionid = $uid;
        $baseuid = base64_encode(base64_encode($uid));
        $this->assign('uid', $baseuid);
        $time = time();
        $ordernumber = "D" . $uid .mt_rand(). $time;
        $params = [
            'body' => $ordernumber,
            'total_fee' => $price * 100,
            'product_id' => $time,
            'pid' => $sid,
            'uid' => $uid,
            'sessionid' => $sessionid,
            'sessionfpid' => $fpid,
          	'createAt' => time(),
        ];
        if ($is_weixin) {
            // return $this->fetch('tishi');
            $code = @$_GET["code"];
            if ($code) {
                $sales_id = db('sales')->insertGetId($params);
                $result = \accapys\HkPayJsPay::getPayParams($params, $code);
                $this->assign("order_no", $ordernumber);
                $this->assign("result", $result);
                $this->assign("price", $price);
                return $this->fetch();
            } else {
                $result = \accapys\HkPayJsPay::getPayParams($params);
            }
        } else {
          $params['out_trade_no'] = $order_no;
           $sales_id = db('sales')->insertGetId($params);
            $s_order_no = session('order_no');
            if (empty($s_order_no)) {
                //保存订单id
                session('order_no', $order_no);
                $this->assign("order_no", $order_no);
            } else {
                //删除订单id
                $sales_s = db('sales')->where('out_trade_no', '=', $s_order_no)->where('status', '=', 1)->where('uid', '=', $uid)->find();
                if (!empty($sales_s)) {
                    $this->assign("order_no", $sales_s['out_trade_no']);
                } else {
                    $this->assign("order_no", $s_order_no);
                }
            }
            $this->assign("price", $price);
            $this->assign("uid", session('uid'));
            return $this->fetch('hpay');
        }
    }

    //查询订单状态
    public function hxorder_query()
    {
        $out_trade_no = input('order_no');
      	$result = Db::name("sales")->where(array("body" => $out_trade_no))->find();
        if ($result["status"] == 1) {
            $bairo = db('bairo')
                ->alias("b")
                ->field("b.*")
                ->join("sun_chaxun c", "b.chaxunid=c.id", "LEFT")
                ->join("sun_sales s", "s.id=c.sid", "LEFT")
                ->where('s.id', '=', $result['id'])
                ->find();
            if ($bairo) {
                return base64_encode(base64_encode($result['id']));
            } else {
                return 0;
            }
            exit();
        } else {
            return 0;
            exit();
        }
    }
  
  
  
  
  
  
  
  
  public function isWeiXinBrowser()
    {
        $user_agent = $_SERVER['HTTP_USER_AGENT'];
        if (strpos($user_agent, 'MicroMessenger') === false) {
            return false;
        } else {
            return true;
        }
    }
  //查询订单状态
  public function order_query(){
    $out_trade_no=input('order_no');
    $result=Db::name("sales")->where(array("out_trade_no"=>$out_trade_no))->find();
    if ($result["status"]==1){
      $bairo  =db('bairo')
                ->alias("b")
                ->field("b.*")
                ->join("sun_chaxun c","b.chaxunid=c.id","LEFT")
                ->join("sun_sales s","s.id=c.sid","LEFT")
               ->where('s.id','=',$result['id'])
                ->find();
      if($bairo){
    		return base64_encode(base64_encode($result['id']));//$result['id'];
      }else{
      	return 0;
      }
      exit();
    }else{
      return 0;
      exit();
    }
  }
    public function test(){
    file_put_contents("1.txt","12333333333333333333333333333333");
  }
     public function gzh()
    {
       
        return $this->fetch();
      } 
      
      
      
      public function nutify_ulr(){
          file_put_contents("111111.txt","测试完成");
      }
      
      
      public function openid(){
      		$url = 'https://xorpay.com/api/openid/6367?callback=http://www.zsxycx.com/index/pay/xpay';
      	    header("Location:".$url);
      }
      
      

      public function xpay($openid = ''){
          $data['name'] = '大数据';  # 订单商品名称
          $data['pay_type'] = 'jsapi';     # 付款方式
          $data['price'] = '0.01'; # 从 URL 获取充值金额 price
          $data['order_id'] = time();    # 自己创建的本地订单号
          $data['notify_url'] = 'http://www.zsxycx.com/index/pay/nutify_ulr';   # 回调通知地址
          $data['openid'] = $openid;
          $data['more'] = ''; //订单其他信息，回调时原样传回
          $data['expire'] = '60'; //单过期时间

          $secret = 'b2b212c510324d21a39ab15c9773e42f';     # app secret, 在个人中心配置页面查看
          $api_url = 'https://xorpay.com/api/pay/6367';   # 付款请求接口，在个人中心配置页面查看

          $data['sign'] = md5(join('',[$data['name'], $data['pay_type'], $data['price'], $data['order_id'], $data['notify_url'],$secret]));

          $json = $this->Post($data,$api_url);
          
          $json_data = json_decode($json,true);
         
          
          $this->assign('info',json_encode($json_data['info']));
          return $this->fetch('xpay');
    }


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
      
      	$json_obj = json_decode($res,true);
    
    	return $json_obj;
  }
      
      
      
      
      
      
}