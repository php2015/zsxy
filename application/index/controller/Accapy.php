<?php

namespace app\index\controller;

use accapys\entity\Request;
use accapys\lib\Aes;
use accapys\lib\Rsa;
use accapys\lib\CLogFileHandler;
use accapys\entity\CollBackResponse;
use accapys\lib\Log;
use accapys\entity\Utils;
use think\Controller;

class Accapy extends Controller{

    public static $accEntryConfig = [
      
        'Version' => '2.0.0',
      
        'ipsURL' => 'https://api.ips.com.cn', // 迅付网关
      
        'url_index' => '/trade/platform/pay',
      
        'merCode' => "284333", //ips商户号
      
        'accCode' => '2843330016', //ips账户号
      
        'AES_KEY' =>  'kwnfJarMrUfl8wF2', //'BaPhg6Lnq38JJLF4', //AES证书，与ips保持一致，通过商户后台——>商户设置——>商户服务生成AES密钥，并下载

        //通知地址,这是ips处理成功以后通知给商户的接口地址
        'successURL' => 'http://www.zsxycx.com/index/accapy/notify',

        //通知地址,这是ips处理完成以后通知给商户的server to server地址
        's2sURL' => 'http://www.zsxycx.com/index/accapy/notify',

        'SHA256_PRIVATE_KEY' => '/www/wwwroot/www.zsxycx.com/extend/accapys/cert/private.key.txt',

        //生成私钥时的证书密码，若没有密码则不填
        'SHA256_PRIVATE_KEY_PWD' =>  'HYBqwsx789', 

        //通过商户后台——>商户设置——>商户服务生成SHA公钥，并下载SHA公钥,
        'SHA256_PUBLIC_KEY' => '/www/wwwroot/www.zsxycx.com/extend/accapys/cert/public.key.txt',

        'MerName' => '钻石信用',
      
      	'platCode' => '1001',
    ];

  
  
  /* 获取code */
  public function index(){
  		  $appid = "wxfaa49ae1017830b7";
          $ran = rand(1,100); //预防缓存
          $REDIRECT_URI = 'http://www.zsxycx.com/index/accapy/openid?number='.$ran.''; //一定写上http://
          $scope = 'snsapi_base';
          $url = 'https://open.weixin.qq.com/connect/oauth2/authorize?appid='.$appid.'&redirect_uri='.urlencode($REDIRECT_URI).'&response_type=code&scope='.$scope.'&state=wx'.'#wechat_redirect';
          //加缓存 随机数
          header("Location:".$url);
  }
  
  
  /* 获取用户openid */
  public function openid(){
  		$appid = "wxfaa49ae1017830b7";

		$secret = "a46e1331e8382e9a51844985deace246";
   
        $code = $_GET["code"];
    
        $get_token_url = 'https://api.weixin.qq.com/sns/oauth2/access_token?appid='.$appid.'&secret='.$secret.'&code='.$code.'&grant_type=authorization_code';
    
    	$json_obj = $this->Get($get_token_url);
 
		$this->apy($json_obj['openid']);
  }
  
  
  
  public function apy($openid=''){
    
    	$accConfig = self::$accEntryConfig;
    
   		$Rsa = new Rsa();
    	$Rsa->init($accConfig['SHA256_PUBLIC_KEY'],$accConfig['SHA256_PRIVATE_KEY'],$accConfig['SHA256_PRIVATE_KEY_PWD']);
    
        $data = [];
        // 获取页面请求信息
        $data['url'] = $accConfig['ipsURL'].$accConfig['url_index'];

        $data['account'] = $accConfig['accCode'];//账户号
      
        $data['trxId'] = $this->number('D'); //订单号
    
       	$data['productType'] = "9505";
    
        $data['sceneType'] = "JSAPI";
    
        $data['appId'] = 'wxfaa49ae1017830b7'; //应用ID
    
      	$data['openId'] = 'oR3FE5q9tizhKyBNOqjCs54xgD60'; //$openid;
    
      	$data['trxDtTm'] = date('Ymd');
    
        $data['trxCcyCd'] = "156";
    
        $data['trxAmt'] = "0.01";
    
        $data['notifyUrl'] = "http://www.zsxycx.com/index/accapy/notify"; 
     	 
     	$data['pageUrl'] = "http://www.zsxycx.com/index/accapy/notify";
    
      	$data['expireDtTm'] = date('YmdHis',time()+108000);
        $data['goodsDesc'] = $accConfig['MerName'];

      	$data['extFields'] = ['clientIp' => "192.168.1.1","merCategory"=>"","platUrl"=>"","orderTerminal"=>"","deviceInfo"=>"","deviceType"=>"","gitLat"=>''];

  		$signData = Aes::encode($accConfig['AES_KEY'],json_encode($data));
    
      	$data['encryptType'] = 'AES';
      	$data['format'] = 'json';
      	$data['merCode'] = $accConfig['merCode'];
        $data['nonceStr'] =   $this->userName(32); 
        $data['signType'] = 'RSA2';
      	$data['ts'] = date('YmdHis');
      	$data['version']  = $accConfig['Version'];
    	
     	$accEntryRequest = new Request($accConfig['Version'], date('YmdHis'),$accConfig['merCode'],$data['nonceStr'], 'json', 'AES',$signData, 'RSA2');

    	$object = Utils::arr2str(Utils::object_array($accEntryRequest));
   		
      	$signObject =  $Rsa->sign($object);
     
        $this->assign('data',$data);
    	$this->assign('signData',$signData);
    	$this->assign('signObject',$signObject);
        $this->fetch('index');
  }
  
  
  
  
  public function notify(){
   	 	$accConfig = self::$accEntryConfig;
     	$RSA = new RSA();
		$RSA->init($accConfig['SHA256_PUBLIC_KEY'],$accConfig['SHA256_PRIVATE_KEY'],$accConfig['SHA256_PRIVATE_KEY_PWD']);
		ini_set("error_reporting","E_ALL & ~E_NOTICE"); 
    	$accConfig = self::$accEntryConfig;
    
    
    	$data = '17c22a239d9852e33b4059cfcc44b13a196059bf96828555dee0df79d41164b413f40e5663a1601f00ff134534a29171b6566ad9618deb4e9032692e85a2fbd42fc7bbc5e13656c5e19ed71b24d822f021466dd0c6dff3364bbce6c788afa0d2fd5c7fe8bfa6dc81f6713c4c773d7585264f84dc42fa955be5a030ba6cc3cd5b94ddf4a9a5eee1210d237260f76fd089788c55a9cc96dc895bf2e1b9c0222a5e5c04fa4ee15816b891c4ddfc1eb617b13045062a66b4fa62da8f4bd3561d9eaf051edbb03b6be06fc895d3f14d610667c452f47a8c58d348c951dda6ab28f942516d6aaadd54c380f4b48b5be87d46a7bc66bafb0c17e52883272264407512adbcfbb0ac6ab895090615487ef60483be5a42dd02f364fadf497026f454e57c03a704644463e2352620be83b28fb22661b9d2c76db52aecff785f6724f2a108b1c8ac4f5ab3ad4b81d9ac32350e5892288b115402da0383614bfffdd340c84e95e2d60a83664d99e9b48a13691d70ebc02670bc7bec359fbbf8b5e571afdccf8f619015bd2e904869373553defc07773957aca6d4b50fe252d3a208a7109070222d09d6db8104b0cf799f620994bc2dc2152bb3b8a4f3fbb8096135baef3be7e0c03470aade6071d0f35de94845a24b5f3881c9d8d92272d52a7796f1a61deef5eaab864eca8075d58984e4e98f91f32b873d4a54b50f74fdf158c14280da32f24f4fc7f92b37250ea67ac731b6f01d781caed33f5c5e31321968d45a1c4175e0452e8c86f4928ee17664962b9c3f5f43e305cc5712bcb4aa596bfd0b4daedecf60774d6a98e8e545a5f507577cc793a346bc26720c2fad019d30838f4b73820b800297260d9ca546b60cd0f4ca58c80785302d33e34d655770bfd1d0dad4704cf6c10025b2eef82026470cce49e32c7478ec13ad6dfa4905e5b4183d46833fcb9a0c33b0a7c4d4652da39d043e0c149a65a4e97c845ecf987b8af743d0b84ca15b261e2fe45d7b314a546f20f7ac30743ae967b574f9d76aacad2c03e5ef0558f8092450f8201bbfb16d1646ac682c484d6a2e5b741d9489f7e8cd5910476971'; //$_REQUEST['data'];
    	$version = $_REQUEST['version'];
   	 	$merCode = $_REQUEST['merCode'];
    	$ts = $_REQUEST['ts'];
    	$nonceStr = $_REQUEST['nonceStr'];
    	$format = $_REQUEST['format'];
    	$encryptType = $_REQUEST['encryptType'];
    	$signType = $_REQUEST['signType'];
    	$notifyType = $_REQUEST['notifyType'];
    	$sign = '533bac106a5a488934a7f4b3b281535906b02fe5f1a46f15b2287ce3b134cc0111757a12a625e1430d8088280be13116aad70f0bf0473518e9e51a5c6b42b5d1e2597ae7619eaf0f000df973f15918f121a6868fb1ff2a774548930784b73914be481d1d5ccf53e7cda90c1a9e65b7bf5cc44d1674a2e28e04a7bc43c163c40de662d583edc489bc60d110e09651f8c38f78a88c7cb0b7a8005fabb957dc0aef8a60c8f0094ce94f4b8ef173f058e9d53eb4e66f48f59df0bf8835fcdf74e9d19523c4fb750c612de183a42df225f0f9a524c4e7de880f9dd3a06906a4d55c2d44fbd5bf6b73ecc45611ecf1df288b7267a822e5d62693e20da7505d4cdf8084'; //$_REQUEST['sign'];
    	$verifyObject = null;
   	 	$decryptData = null;
    	$verifyResult = false;
    
    	$decryptData = Aes::decode($accConfig['AES_KEY'],$data);
    
    	echo "<pre>";
    
    	var_dump(json_decode($decryptData,true));die;
    
    	$json_data = json_decode($decryptData,true);
   		
    	$json_payInfo = json_decode($json_data['payInfo'],true);    
    
    	$result = \wxpay\JsapiPay::wxpayHX($json_payInfo);

     	$this->assign("result", $result);
        return $this->fetch('pay');
    
    	try {
        	if ($sign != null && $sign != "") {
            	$backResponse = new CollBackResponse($version, $ts, $merCode, $nonceStr, $format, $encryptType, $data, $signType, $notifyType);
            	$verifyObject = Utils::arr2str(Utils::object_array($backResponse));
            	$verifyResult = $RSA->verify($verifyObject,$sign);
          
              
            	if ($verifyResult) {
                	$decryptData = Aes::decode($accConfig['AES_KEY'],$data);
               
            	}
              
        	}
   	 	} catch (Exception $e) {
        	echo $e->getMessage();
        	Log::DEBUG("异常信息 :".$e->getMessage());
    	}
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
  
  
  

  
   public function Post($PostArry,$request_url){
        $postData = $PostArry;
        $postDataString = http_build_query($postData);//格式化参数
        $postDataString = json_encode($postDataString);
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
  
  
  
  
  	public function pay(){
      $code = @$_GET["code"];
     	$time = time();
        $ordernumber = "D" . 123 . $time;
      	$order_no = mt_rand() . time();
      	$params = [
            'body' => $ordernumber,
            'out_trade_no' => $order_no,
            'total_fee' => 0.0001 * 100, //ice*100
            'product_id' => $time,
            'pid' => 123,
            'uid' => 123,
            'sessionid' => 123,
            'sessionfpid' => 123,
            'nonceStr' => $this->userName(32)
        ];
      $result = \accapys\HkPayJsPay::getPayParams($params,$code);
      $this->assign("result", $result);
       return $this->fetch('pay');
      
    }
  
  
 

}