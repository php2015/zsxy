<?php
namespace app\index\controller;

use app\common\model\Profit as ProfitModel;
use think\Controller;
use think\Db;
use think\Session;
use PHPExcel_IOFactory;
use PHPExcel;
use Corebairo\Corebairo;
use Con\Con;
use wxpay\JsapiPay;
header("content-type:text/html;charset=utf8");
//require_once getcwd()."/extend/wxpay/lib/WxPayConfig.php";
include EXTEND_PATH .'wxpay/lib/WxPayConfig.php';
/**
 * 奖励明细
 * Class Order
 * @package app\admin\controller
 */

class Transfers extends Controller
{
  //获取openid
public function pay_openid(){
    $is_weixin=$this->isWeiXinBrowser();
  
// dump($WxPayConfig::MCHID);die;
    if ($is_weixin){
       $JsapiPay= new JsapiPay();
      $code=@$_GET["code"];
          if ($code){
          // $openId = \wxpay\JsapiPay::getOpenid($code);
           $openId = $JsapiPay::getOpenid($code);
                	$id=session('uid');
                    $user=db('user')->where('id','=',$id)->where('status','=','1')->find();
                    if(empty($user['bid'])){
                        $data['bnames']=input('banktype');
                        $data['zhanghao']=$openId;//input('banknumber');
                        $data['tnames']=input('banknames');
                        $bjimg_id=db('banks')->insertGetId($data);
                        $data_user['id']=$id;
                        $data_user['bid']=$bjimg_id;
                        if(db('user')->where('id','=',$id)->update($data_user)){
                             return $this->success('绑定微信成功','index/user/usertx');
                            }else{
                               return $this->error('已绑定账号无需重复绑定');
                            }  
                    }else{
                    $bank['bnames']=input('banktype');
                    $bank['zhanghao']=$openId;//input('banknumber');
                    $bank['tnames']=input('banknames');
                     // dump($bank);die;
                    if(db('banks')->where('id','=',$user['bid'])->update($bank)){
                        return $this->success('绑定微信成功','index/user/usertx');
                    }else{
                        return $this->error('已绑定账号无需重复绑定');
                    }  
                  }
                	
             /** $outTradeNo = uniqid();     //订单号
            $payAmount = 1;             //转账金额，单位:元。转账最小金额为1元
            $trueName = '王升升';         //收款人真实姓名
            $result = $this->createJsBizPackage($openId,$payAmount,$outTradeNo,$trueName);
            if($result == true){
               return $this->success('绑定微信提现方式成功','index/user/index');
            }else{
              return $this->error('请在微信端绑定微信号提现');
            }**/
           
           // dump($result);die;
          }else{
            $code='';
            $openId = $JsapiPay::getOpenid($code);
            $id=session('uid');
                    $user=db('user')->where('id','=',$id)->where('status','=','1')->find();
                    if(empty($user['bid'])){
                        $data['bnames']=input('banktype');
                        $data['zhanghao']=$openId;//input('banknumber');
                        $data['tnames']=input('banknames');
                        $bjimg_id=db('banks')->insertGetId($data);
                        $data_user['id']=$id;
                        $data_user['bid']=$bjimg_id;
                        if(db('user')->where('id','=',$id)->update($data_user)){
                             return $this->success('绑定微信成功','index/user/usertx');
                            }else{
                               return $this->error('已绑定账号无需重复绑定');
                            }  
                    }else{
                    $bank['bnames']=input('banktype');
                    $bank['zhanghao']=$openId;//input('banknumber');
                    $bank['tnames']=input('banknames');
                      dump($bank);die;
                    if(db('banks')->where('id','=',$user['bid'])->update($bank)){
                        return $this->success('绑定微信成功','index/user/usertx');
                    }else{
                        return $this->error('请在微信端绑定微信号提现');
                    }  
                  }
           /**$openId = $JsapiPay::getOpenid($code);
             $outTradeNo = uniqid();     //订单号
            $payAmount = 1;             //转账金额，单位:元。转账最小金额为1元
            $trueName = '王升升';         //收款人真实姓名
            $result = $this->createJsBizPackage($openId,$payAmount,$outTradeNo,$trueName);
             if($result == true){
               return $this->success('提现成功','index/user/index');
            }else{
              return $this->error('请在微信端绑定微信号提现');
            }**/
             //dump($result);die;
          }
    }else{
          //$wxurl="http://130.hbkckc.com";
     // $result = \wxpay\WapPay::getPayUrl($params);
         return $this->error('请在微信端绑定微信号提现');
       // $this->assign("result",$result);
    }
    
  }
//微信提现
   public function weixintixian()
    {
         $id=session('uid');
           //$user=db('user')->where('id','=',$id)->where('status','=','0')->find();
		$user=db('user')
        ->alias("a")
        ->join("sun_banks b",'a.bid=b.id','LEFT')
        ->where('a.id','=',$id)
		->field('a.*,b.bnames,b.zhanghao,b.tnames,b.ttel')
        ->find();
     	 //判断是否绑定收款账号
          if(empty($user['zhanghao'])){
            return $this->success('请检查你的账户或姓名是否正确','index/user/index');//return 5;
          }
          //判断是否绑定收款账号
          if(empty($user['bnames'])){
            return $this->success('请检查你的账户或姓名是否正确','index/user/index');//return 11;
          }
     	//查询是否有正在审核的订单
          //$sta=db('withdraw')->where('user_id','=',$id)->where('status','=','0')->find();
          //$array_id=input('array_id');
          //订单状态修改
          if(1==1){
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
                // dump($withdraw_id);die;
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
                   $openId = $user['zhanghao'];
                    $outTradeNo = uniqid();     //订单号
                    $payAmountss = input('account');             //转账金额，单位:元。转账最小金额为1元
                   if($payAmountss > 9){
                $payAmount = $payAmountss*0.994;
                     $payAmount=round($payAmount,2);
                }
                    $trueName = $user['tnames'];         //收款人真实姓名
                   	 $result = $this->createJsBizPackage($openId,$payAmount,$outTradeNo,$trueName);
                  // dump($openId);dump($outTradeNo);dump($payAmount);dump($trueName);die;
                       if($result == true){
                          	$w_data['status']=1;
                            $w_data['id']=$withdraw_id;
                            if(db('withdraw')->where('id','=',$withdraw_id)->update($w_data)){
                              $u_data['status']=1;
                              $uid=session('uid');
                              $w_user=db('user')->where('id','=',$uid)->find();
                              $u_data['id']=$uid;
                              $u_data['money']=$w_user['money'] - $payAmountss;
                              if(db('user')->where('id','=',$uid)->update($u_data)){
                              return $this->success('提现成功','index/user/index');//return 1;
                              }else {
                               // echo "失败";
                                 return $this->success('请检查你的账户或姓名是否正确','index/user/index');// return 22;
                                }
                            } else {
                         // echo "失败";
                            return $this->success('请检查你的账户或姓名是否正确','index/user/index');//return 22;
                          }
                      }else{
                        return $this->success('请检查你的账户是否正确','index/user/index');//return 0;//$this->error('请在微信端绑定微信号提现');
                      }
                   //$tixian=$this->tixian($withdraw_id);
                    //return $tixian;
                  }else{
                       return $this->success('请检查你的账户是否正确','index/user/index');//return 0;
                  } 
              //余额为0提示
              }elseif($user['money']==0){
                 return $this->success('余额不足','index/user/index');//return 2;
              }else{
                 return $this->success('余额不足','index/user/index');//return 3;
              }
          }else{
               return $this->success('你的提现正在审核','index/user/index');//return 4;
            } 
     	
    }
  	//
  
  public function isWeiXinBrowser()
    {
        $user_agent = $_SERVER['HTTP_USER_AGENT'];
        if (strpos($user_agent, 'MicroMessenger') === false) {
            return false;
        } else {
            return true;
        }
    }
 
 

  public function opid()
  {
    
     
    $code=@$_GET["code"];
      header("Content-type: text/html; charset=utf-8");
    	$WxPayConfig = new \WxPayConfig();
    $is_weixin=$this->isWeiXinBrowser();
    if ($is_weixin){
    		if(!$code){
              
              $APPID= $WxPayConfig::APPID;//'wx6ed32db12189eb5b';
              $REDIRECT_URI='http://lm.hbkckc.com/index/transfers/opid';
              $scope='snsapi_base';
              $url='https://open.weixin.qq.com/connect/oauth2/authorize?appid='.$APPID.'&redirect_uri='.urlencode($REDIRECT_URI).'&response_type=code&scope='.$scope.'&state=wx'.'#wechat_redirect';
              header("Location:".$url);
          }else{
              
              $appid =$WxPayConfig::APPID;//"wx6ed32db12189eb5b";
             $secret =$WxPayConfig::APPSECRET;//"57e51fc083d315357bd27f755fd22d25";
            // $code = $_GET["code"];
             $get_token_url = 'https://api.weixin.qq.com/sns/oauth2/access_token?appid='.$appid.'&secret='.$secret.'&code='.$code.'&grant_type=authorization_code';
             $ch = curl_init();
             curl_setopt($ch,CURLOPT_URL,$get_token_url);
             curl_setopt($ch,CURLOPT_HEADER,0);
             curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1 );
             curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
             $res = curl_exec($ch);
             curl_close($ch);
             $json_obj = json_decode($res,true);
  
             //根据openid和access_token查询用户信息
             //$access_token = $json_obj['access_token'];
            // dump($code);dump($json_obj);die;
              if(isset($json_obj['openid'])){
              		 $openid = $json_obj['openid'];
                	$id=session('uid');
                    $user=db('user')->where('id','=',$id)->where('status','=','1')->find();
                    if(empty($user['bid'])){
                        $data['bnames']=input('banktype');
                        $data['zhanghao']=$openid;//input('banknumber');
                        $data['tnames']=input('banknames');
                        $bjimg_id=db('banks')->insertGetId($data);
                        $data_user['id']=$id;
                        $data_user['bid']=$bjimg_id;
                        if(db('user')->where('id','=',$id)->update($data_user)){
                             return $this->success('绑定微信成功','index/user/usertx');
                            }else{
                               return $this->error('已绑定账号无需重复绑定');
                            }  
                    }else{
                    $bank['bnames']=input('banktype');
                    $bank['zhanghao']=$openid;//input('banknumber');
                    $bank['tnames']=input('banknames');
                      dump($bank);die;
                    if(db('banks')->where('id','=',$user['bid'])->update($bank)){
                        return $this->success('绑定微信成功','index/user/usertx');
                    }else{
                        return $this->error('请在微信端绑定微信号提现');
                    }  
                  }
                	
              }else{
              		return $this->error('请在微信端绑定微信号提现');
              }
              
            /**  $get_user_info_url = 'https://api.weixin.qq.com/sns/userinfo?access_token='.$access_token.'&openid='.$openid.'&lang=zh_CN';
             
             $ch = curl_init();
             curl_setopt($ch,CURLOPT_URL,$get_user_info_url);
             curl_setopt($ch,CURLOPT_HEADER,0);
             curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1 );
             curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
             $res = curl_exec($ch);
             curl_close($ch);
             
             //解析json
             $user_obj = json_decode($res,true);
             $_SESSION['user'] = $user_obj;
             print_r($user_obj);**/
            
         }
      	}else{
            	return $this->error('请在微信端绑定微信号提现');
            }
  } 
  
    /**
     * 企业付款
     * @param string $openid 调用【网页授权获取用户信息】接口获取到用户在该公众号下的Openid
     * @param float $totalFee 收款总费用 单位元
     * @param string $outTradeNo 唯一的订单号
     * @param string $orderName 订单名称
     * @param string $notifyUrl 支付结果通知url 不要有问号
     * @param string $timestamp 支付时间
     * @return string
     */
    public function createJsBizPackage($openid, $totalFee, $outTradeNo,$trueName)
    {
      $WxPayConfig = new \WxPayConfig();
        $config = array(
            'mch_id' =>$WxPayConfig::MCHID,//'1497631742',
            'appid' => $WxPayConfig::APPID,// 'wx6ed32db12189eb5b',
            'key' => $WxPayConfig::KEY,//'hubeikuaichengwenhuachuanmeigong',
        );
      
        $unified = array(
            'mch_appid' => $config['appid'],
            'mchid' => $config['mch_id'],
            'nonce_str' => self::createNonceStr(),
            'openid' => $openid,
            'check_name'=>'FORCE_CHECK',        //校验用户姓名选项。NO_CHECK：不校验真实姓名，FORCE_CHECK：强校验真实姓名
            're_user_name'=>$trueName,                 //收款用户真实姓名（不支持给非实名用户打款）
            'partner_trade_no' => $outTradeNo,
            'spbill_create_ip' =>$WxPayConfig::IP,//$ip=self::get_client_ip(),// WxPayConfig::IP,//'47.96.96.10',
            'amount' => intval($totalFee * 100),       //单位 转为分
            'desc'=>'付款',            //企业付款操作说明信息
        );
     // dump($unified);die;
      
        $unified['sign'] = self::getSign($unified, $config['key']);
     
        $responseXml = $this->curlPost('https://api.mch.weixin.qq.com/mmpaymkttransfers/promotion/transfers', self::arrayToXml($unified));
      //dump($responseXml);die;
        $unifiedOrder = simplexml_load_string($responseXml, 'SimpleXMLElement', LIBXML_NOCDATA);
     
        if ($unifiedOrder === false) {
            //die('parse xml error');
           return false;
        }
        if ($unifiedOrder->return_code != 'SUCCESS') {
            //die($unifiedOrder->return_msg);
          return false;
        }
        if ($unifiedOrder->result_code != 'SUCCESS') {
           // die($unifiedOrder->err_code);
          return false;
        }
        return true;
    }

    public static function curlGet($url = '', $options = array())
    {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        if (!empty($options)) {
            curl_setopt_array($ch, $options);
        }
        //https请求 不验证证书和host
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        $data = curl_exec($ch);
        curl_close($ch);
        return $data;
    }

    public function curlPost($url = '', $postData = '', $options = array())
    {
        if (is_array($postData)) {
            $postData = http_build_query($postData);
        }
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,TRUE);
        curl_setopt($ch, CURLOPT_POST,TRUE);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30); //设置cURL允许执行的最长秒数
        if (!empty($options)) {
            curl_setopt_array($ch, $options);
        }
        //https请求 不验证证书和host
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);

        //第一种方法，cert 与 key 分别属于两个.pem文件
        //默认格式为PEM，可以注释
        curl_setopt($ch,CURLOPT_SSLCERTTYPE,'PEM');
        curl_setopt($ch,CURLOPT_SSLCERT,getcwd().'/extend/wxpay/cert/apiclient_cert.pem');
        //默认格式为PEM，可以注释
        curl_setopt($ch,CURLOPT_SSLKEYTYPE,'PEM');
        curl_setopt($ch,CURLOPT_SSLKEY,getcwd().'/extend/wxpay/cert/apiclient_key.pem');
        //第二种方式，两个文件合成一个.pem文件
//        curl_setopt($ch,CURLOPT_SSLCERT,getcwd().'/all.pem');
      //post提交方式
		//dump($ch);die;
        $data = curl_exec($ch);
        if($data === false)
        {
            echo 'Curl error: ' . curl_error($ch);exit();
        }        
        curl_close($ch);
        return $data;
    }

    public static function createNonceStr($length = 32)
    {
        $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        $str = '';
        for ($i = 0; $i < $length; $i++) {
            $str .= substr($chars, mt_rand(0, strlen($chars) - 1), 1);
        }
        return $str;
    }
    public static function arrayToXml($arr)
    {
        $xml = "<xml>";
        foreach ($arr as $key => $val) {
            if (is_numeric($val)) {
                $xml .= "<" . $key . ">" . $val . "</" . $key . ">";
            } else
                $xml .= "<" . $key . "><![CDATA[" . $val . "]]></" . $key . ">";
        }
        $xml .= "</xml>";
        return $xml;
    }

    public static function getSign($params, $key)
    {
        ksort($params, SORT_STRING);
        $unSignParaString = self::formatQueryParaMap($params, false);
        $signStr = strtoupper(md5($unSignParaString . "&key=" . $key));
        return $signStr;
    }
    protected static function formatQueryParaMap($paraMap, $urlEncode = false)
    {
        $buff = "";
        ksort($paraMap);
        foreach ($paraMap as $k => $v) {
            if (null != $v && "null" != $v) {
                if ($urlEncode) {
                    $v = urlencode($v);
                }
                $buff .= $k . "=" . $v . "&";
            }
        }
        $reqPar = '';
        if (strlen($buff) > 0) {
            $reqPar = substr($buff, 0, strlen($buff) - 1);
        }
        return $reqPar;
    }
  	 /**
     * 获取当前服务器的IP
     */
    private static function get_client_ip(){
        if (getenv('HTTP_CLIENT_IP') && strcasecmp(getenv('HTTP_CLIENT_IP'), 'unknown')) {
            $ip = getenv('HTTP_CLIENT_IP');
        } elseif (getenv('HTTP_X_FORWARDED_FOR') && strcasecmp(getenv('HTTP_X_FORWARDED_FOR'), 'unknown')) {
            $ip = getenv('HTTP_X_FORWARDED_FOR');
        } elseif (getenv('REMOTE_ADDR') && strcasecmp(getenv('REMOTE_ADDR'), 'unknown')) {
            $ip = getenv('REMOTE_ADDR');
        } elseif (isset($_SERVER['REMOTE_ADDR']) && $_SERVER['REMOTE_ADDR'] && strcasecmp($_SERVER['REMOTE_ADDR'], 'unknown')) {
            $ip = $_SERVER['REMOTE_ADDR'];
        }
        return preg_match('/[\d\.]{7,15}/', $ip, $matches) ? $matches [0] : '';
    }
}