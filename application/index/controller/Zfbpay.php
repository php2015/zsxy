<?php
namespace app\index\controller;

use app\common\model\Profit as ProfitModel;
use think\Controller;
use think\Db;
use think\Session;
use PHPExcel_IOFactory;
use PHPExcel;
use Corebairo\Corebairo;
use app\index\controller\Longterm;
use app\index\controller\Reptile;
use app\index\controller\Unionpay;
use app\index\controller\Borrowing;
use Con\Con;
header("content-type:text/html;charset=utf8");
/**
 * 奖励明细
 * Class Order
 * @package app\admin\controller
 */
class Zfbpay extends Controller
{
    public function notify(){
    	#file_put_contents("5.txt",$_POST);
      	header("Content-type:text/html;charset=utf-8");
        $wap_config = array(
			//合作身份者id，以2088开头的16位纯数字
			'partner' => '2088531447004204',//'2088331380973764',
			//收款支付宝账号
			'seller_id' => '439503990@qq.com',//'18062677701@163.com',
			// 商户的私钥（后缀是.pen）文件相对路径
			'private_key_path' => '/www/wwwroot/www.xalanfeng.cn/extend/alipaywap/key/rsa_private_key.pem',
			//支付宝公钥（后缀是.pen）文件相对路径
			'ali_public_key_path' => '/www/wwwroot/www.xalanfeng.cn/extend/alipaywap/key/alipay_public_key.pem',
			//签名方式
			'sign_type' => strtoupper('MD5'),
			'key' => 'o5m2krm7383k03bwv5pw0j2dwknq9gg1',//'ef19eg11mvccjaa0q0y4y36tbz5ysvdw',
			//字符编码格式 目前支持 gbk 或 utf-8
    		'input_charset' => strtolower('utf-8'),
			//ca证书路径地址，用于curl中ssl校验
    		//请保证cacert.pem文件在当前文件夹目录中
    		'cacert' => getcwd().'/Think/Library/Org/Alipaywap/cacert.pem',
			//访问模式,根据自己的服务器是否支持ssl访问，若支持请选择https；若不支持请选择http
    		'transport' => 'http',
			//异步通知url
			'notify_url' => 'http://www.xalanfeng.cn/index/zfbpay/notify',
			//跳转通知url
			'return_url' => 'http://www.xalanfeng.cn/index/zfbpay/tiaozhuan'
			);
        //计算得出通知验证结果
        $alipayNotify = new \alipaywap\AlipayNotify($wap_config);
        $verify_result = $alipayNotify->verifyNotify();

        if($verify_result) {
            //验证成功
            $out_trade_no   = $_POST['out_trade_no'];      //商户订单号
            $trade_status   = $_POST['trade_status'];      //交易状态
            $total_fee      = $_POST['total_fee'];         //交易金额
			#file_put_contents("50.txt",$trade_status);
          	#file_put_contents("60.txt",$out_trade_no);
            if ($trade_status == 'TRADE_FINISHED' || $trade_status == 'TRADE_SUCCESS') {
                //支付成功、进行订单检查并处理
              	//查询有没有订单进来sales表
       $sales=db('sales')->where('out_trade_no','=', $out_trade_no)->find();
              #file_put_contents("70.txt",$sales);
      //如果有，查询改订单是否已经有为1的状态
      if($sales)
      {
        #file_put_contents("90.txt",$_POST['transaction_id']);
        //执行查询
        $m = ['out_trade_no'=>$out_trade_no,'status'=>1];
        $tag=db('sales')->where($m)->find();
        #file_put_contents("100.txt",$tag);
        //如果有，就不管了，如果没有，改1，并执行其他操作
        if(!$tag)
        {
          #file_put_contents("101.txt",11);
          #file_put_contents("108.txt",$sales['id']);
        	 $result = db('sales')->where('id','=', $sales['id'])->update(['status'=>1]);
          
          	#file_put_contents("80.txt",$result);
          	//return $result;
            //准备数据，准备插入查询表
          	//查询用户信息
             $user=db('user')->where('id','=', $sales['uid'])->find();
          	//查询次数
          $user_sishu['id']=$user['id'];
          $user_sishu['pingfeng']=$user['pingfeng']+1;
          $result_sishu = db('user')->where('id', $user_sishu['id'])->update($user_sishu);
			//查询版本人信息
          	$product = db('product')->where('id','=', $sales['pid'])->find();
              $userid=session('uid');
          	//插入查询表查询表
             $chaxun_data=[
                  'ordernumber'=>$sales['body'],
                  'uid'=>$sales['uid'],
                  'dates'=>time(),
                  'remarks'=>0,
                  'pid'=>$sales['pid'],
                  'price'=>$sales['total_fee']/100,
                  'sid'=>$sales['id'],
                  'names'=>$user['names'],
                  'idcard'=>$user['idcard'],
                  'tel'=>$user['mobile'],
                  'ma_id'=>$product['uid']
                ];
                $chaxun_id=db('chaxun')->insertGetId($chaxun_data);
          		#file_put_contents("121.txt",$chaxun_id);
                //$chaxun_id='25480';
                //查询版本信息
              if($chaxun_id)
              {
              	 
              			//$kaishitime = strtotime('- 7 day',time());
						//$bairo = db('bairo')->where('uid','=',$sales['uid'])->where('createdAt','between',[$kaishitime,time()])->order('createdAt desc')->find();
					
                            $yunyingshang_data['chaxunid'] = $chaxun_id;
                            if(isset($bairo) && !empty($bairo)){
                    				if($product['a_g_id'] == 3){
                    					$bairo_data['json'] = $bairo['json'];
                    				}
                    				if(in_array($product['a_g_id'],[4,5])){
                    					$bairo_data['tianyan_duotou'] = $bairo['tianyan_duotou'];
                    				}
                            }else{

                        		if($product['a_g_id'] == 3){
                    				/*$a = new Reptile();
                        			$bairo = $a->index(['identityNo' => $user['idcard'], 'name'=>$user['names'], 'mobile'=>$user['mobile']]);
                        			$bairo_data['json'] = $bairo;*/
                        			
                        			$a = new Borrowing();
                        			$bairo = $a->index(['idcard' => $user['idcard'], 'names'=>$user['names'], 'mobile'=>$user['mobile']]);
                        			$bairo_data['json'] = $bairo;
                    			}
                    	
                    			if(in_array($product['a_g_id'],[4,5])){
                    				$union = new Unionpay();
                    				$bairo = $union->index(['idcard' => $user['idcard'],'names'=>$user['names'],'mobile'=>$user['mobile'],'bank'=>$user['banknumber']]);
                    				$bairo_data['tianyan_duotou'] = $bairo;
                    			}
                    			
                            }
                
                            $bairo_id=db('bairo')->insertGetId($yunyingshang_data);
                
                            if($bairo_id){
                                $this->fenyong($sales['id']);
                            }
                            // //百融查询接口
                            $bairo_data['uid'] = $sales['uid'];
                            $bairo_data['createdAt'] = time();
                            db('bairo')->where('id','=',$bairo_id)->update($bairo_data);
              }
          	exit('success');
        }
      }
                
            }
        }

        exit('fail');
      
  }
  
  public function notifytest(){
       $out_trade_no   = input('oid');
    	#var_dump($out_trade_no);exit;
       $sales=db('sales')->where('out_trade_no','=', $out_trade_no)->find();
       if($sales)
      {
        //执行查询
        $m = ['out_trade_no'=>$out_trade_no,'status'=>1];
        $tag=db('sales')->where($m)->find();
        //如果有，就不管了，如果没有，改1，并执行其他操作
        if(!$tag)
        {
        	$result = db('sales')->where('id','=', $sales['id'])->update(['status'=>1]);
            //准备数据，准备插入查询表
          	//查询用户信息
            $user=db('user')->where('id','=', $sales['uid'])->find();
          	//查询次数
            $user_sishu['id']=$user['id'];
            $user_sishu['pingfeng']=$user['pingfeng']+1;
            $result_sishu = db('user')->where('id', $user_sishu['id'])->update($user_sishu);
			//查询版本人信息
          	$product=db('product')->where('id','=', $sales['pid'])->find();
            $userid=session('uid');
          	//插入查询表查询表
            $chaxun_data=[
                  'ordernumber'=>$sales['body'],
                  'uid'=>$sales['uid'],
                  'dates'=>time(),
                  'remarks'=>0,
                  'pid'=>$sales['pid'],
                  'price'=>$sales['total_fee']/100,
                  'sid'=>$sales['id'],
                  'names'=>$user['names'],
                  'idcard'=>$user['idcard'],
                  'tel'=>$user['mobile'],
                  'ma_id'=>$product['uid']
                ];
                $chaxun_id=db('chaxun')->insertGetId($chaxun_data);
                //查询版本信息
              	if($chaxun_id)
              	{
                	#file_put_contents("111.txt",$chaxun_id);
				 	//手机三要素验证（三网合一 A 版）接口 
                   #$tianyan_mobile=$this->yunyingshang($user['names'],$user['mobile'],$user['idcard']);
                   $yunyingshang_data['chaxunid']=$chaxun_id;
                   $yunyingshang_data['tianyan_mobile']=1;
                   $bairo_id=db('bairo')->insertGetId($yunyingshang_data);
                  	#var_dump($bairo_id);
                	if($bairo_id){
                      $this->fenyong($sales['id']);
                    }
                  // //在网时长
                   #$phone=$this->phone($user['names'],$user['mobile'],$user['idcard']);
                   $phone_data['tianyan_phone']=1;
                   db('bairo')->where('id','=',$bairo_id)->update($phone_data);
                  // //个人涉诉信息查询接口
                  if($product['a_g_id'] == 0){
                   $geren=$this->geren($user['names'],$user['mobile'],$user['idcard']);
                   $geren_data['tianyan_geren']=$geren;
                   db('bairo')->where('id','=',$bairo_id)->update($geren_data);
                 }
                 if($product['a_g_id'] == 3){
                  // //多头借贷与逾期记录综合查询接口
                   $duotou=$this->duotou($user['names'],$user['mobile'],$user['idcard']);
                   $top_image = $this->top_image($user['names'],$user['mobile'],$user['idcard']);
                   $duotou_data['top_image'] = $top_image;
                   $duotou_data['tianyan_duotou']=$duotou;
                   db('bairo')->where('id','=',$bairo_id)->update($duotou_data);
                  }
                  // //金融黑名单查询接口
                 //  $jinron=$this->jinron($user['names'],$user['mobile'],$user['idcard']);
                 //  $jinron_data['tianyan_jinro']=$jinron;
                   //db('bairo')->where('id','=',$bairo_id)->update($jinron_data);
                  // //百融查询接口
                   $bairo=$this->bairo($user['names'],$user['mobile'],$user['idcard']);
                   $bairo_data['json']=$bairo;
                   db('bairo')->where('id','=',$bairo_id)->update($bairo_data);
                  //     //插入查询返回信息表
                    $bairo_data=[
                         'chaxunid'=>$chaxun_id,
                         'json'=>$bairo,
                         'tianyan_duotou'=>$duotou,
                         'tianyan_geren'=>$geren,
                         'tianyan_jinro'=>$jinron,
                         'tianyan_mobile'=>$yunyingshang,
                         'tianyan_phone'=>$phone,
                      	 'top_image' => isset($top_image)?$top_image:'',
                         'tianyan_tonghua'=>$sao_user['names']
                      ];
                     //$bairo_id=db('bairo')->insertGetId($bairo_data);
                	
              }
        }
      }
      
  }
  
  
  
 public function tiaozhuan(){
   $out_trade_no = $_GET['out_trade_no'];
   $result=Db::name("sales")->where(array("out_trade_no"=>$out_trade_no))->find();
    if ($result["status"]==1){
      $bairo  =db('bairo')
                ->alias("b")
                ->field("b.*")
                ->join("sun_chaxun c","b.chaxunid=c.id","LEFT")
                ->join("sun_sales s","s.id=c.sid","LEFT")
               ->where('s.id','=',$result['id'])
                ->find();
      $this->assign("dingdanid",base64_encode(base64_encode($result['id'])));
    }
		Session::delete('order_no');
    
    return $this->fetch('tiaozhuan');

  }

  public function pay(){
    $order_no=mt_rand().time();
    $price=input('price');
    $sid=input('pid');
    $uid=input('uid');
    $product=db('product')->where('id','=',$sid)->find();
    if($price  != $product['price']){
		 $this->error('参数错误');
    }
    $fpid=$product['uid'];
    $sessionid=$uid;
    $baseuid=base64_encode(base64_encode($uid));
    $this->assign('uid',$baseuid);
    $time=time();
    $ordernumber="D".$uid.$time;
    $params = [
            'body' =>$ordernumber,
            'out_trade_no' => $order_no,
            'total_fee' =>$price*100, //$price*100
            'product_id' =>$time,
            'pid' =>$sid,
            'uid' =>$uid,
            'sessionid' =>$sessionid,
            'sessionfpid' =>$fpid,
						'source' => 2
        ];
		$sales_id=db('sales')->insertGetId($params);
		
		
		# 拉起支付宝
		$wap_config = array(
			//合作身份者id，以2088开头的16位纯数字
			'partner' => '2088531447004204',//'2088331380973764',
			//收款支付宝账号
			'seller_id' => '439503990@qq.com',//'18062677701@163.com',
			// 商户的私钥（后缀是.pen）文件相对路径
			'private_key_path' => '/www/wwwroot/www.xalanfeng.cn/extend/alipaywap/key/rsa_private_key.pem',
			//支付宝公钥（后缀是.pen）文件相对路径
			'ali_public_key_path' => '/www/wwwroot/www.xalanfeng.cn/extend/alipaywap/key/alipay_public_key.pem',
			//签名方式
			'sign_type' => strtoupper('MD5'),
			'key' => 'o5m2krm7383k03bwv5pw0j2dwknq9gg1',//'ef19eg11mvccjaa0q0y4y36tbz5ysvdw',
			//字符编码格式 目前支持 gbk 或 utf-8
      'input_charset' => strtolower('utf-8'),
			//ca证书路径地址，用于curl中ssl校验
      //请保证cacert.pem文件在当前文件夹目录中
      'cacert' => getcwd().'/Think/Library/Org/Alipaywap/cacert.pem',
			//访问模式,根据自己的服务器是否支持ssl访问，若支持请选择https；若不支持请选择http
      'transport' => 'http',
			//异步通知url
			'notify_url' => 'http://www.xalanfeng.cn/index/zfbpay/notify',
			//跳转通知url
			'return_url' => 'http://www.xalanfeng.cn/index/zfbpay/tiaozhuan'
		);
    
        //构造要请求的参数数组
        $parameter = array(
            "service"           => "alipay.wap.create.direct.pay.by.user",
            "partner"           => $wap_config['partner'],
            "_input_charset"    => strtolower($wap_config['input_charset']),
            "sign_type"         => $wap_config['sign_type'],
            "notify_url"        => $wap_config['notify_url'],
            "return_url"        => isset($post['return_url']) ? $post['return_url'] : $wap_config['return_url'],
            "out_trade_no"      => $order_no,//商户订单号 
            "subject"           => '大数据查询分析优化',//订单名称 
            "total_fee"         => $price,//付款金额
            "seller_id"         => $wap_config['seller_id'],
            "payment_type"      => "1", //支付类型，不能修改
            "body"              => '大数据查询分析优化',//订单描述
            "show_url"          => '',//商品展示地址
            "it_b_pay"          => '1h',//设置超时时间为1小时
        );
        if (isset($post['app_pay']) && $post['app_pay'] == 'Y') {
            $parameter['app_pay'] = 'Y'; //是否调起支付宝客户端进行支付
        }

        //建立请求
        $alipaySubmit = new \alipaywap\AlipaySubmit($wap_config);
        $html_text = $alipaySubmit->buildRequestForm($parameter,"post",'');
        // C('SHOW_PAGE_TRACE',false);
        #header("Content-type:text/html;charset=utf-8");
        echo $html_text;
				
				#$this->assign("order_no",$order_no);
				
				#$this->assign("result",$result);
				#$this->assign("price",$price);
				#return $this->fetch();
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
      if(!empty($bairo['json']) || !empty($bairo['tianyan_duotou'])){
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
      
      
      
      
      
  
  
  
  public function fenyong($dingdanid){
        //价格查询
        //$dingdanid='8697';
        //查询订单
        $sales=db('sales')->where('id','=',$dingdanid)->find();
        //dump($sales);die;
        //查询提出者信息
        $tichenguser=db('user')->where('id','=',$sales['sessionfpid'])->find();
        //dump($tichenguser);
        //代理等级信息
        $tichengagent=db('agent')->where('id','=',$tichenguser['agent_class'])->find();
        //版本表查询
        $product=db('product')->where('id','=',$sales['pid'])->find();
        //商品表
        $goods=db('goods')->where('id','=',$product['a_g_id'])->find();
        //查询代理等级成本价格
        $tichenggoods=db('agentgoods')->where('aid','=',$tichengagent['id'])->where('gid','=',$goods['id'])->find();

        //判断代理等级成本表是否有
        //没有按goods表成本价
        //查询分成金额
        if($tichenggoods){
            $chengben=$tichenggoods['price'];
            $tichengs=$sales['total_fee']/100-$chengben;
            // dump($tichengs); dump($sales['total_fee']);
            if($tichengs < 0){
                $tichengs = 0;
            }
        }else{
            $chengben=$goods['price'];
            $tichengs=$sales['total_fee']/100-$chengben;
            if($tichengs < 0){
                $tichengs = 0;
            }
            // $tichengs=3;
        }
        //余额
        $balance=$tichenguser['money']+$tichengs;
        //插入提成表
        $datayiji=[
            'order_id'=>$sales['body'],
            'profit_id'=>$tichenguser['id'],
            'ratio'=>$sales['total_fee']/100,
            'create_time'=>time(),
            'money'=>$tichengs,
            'type'=>"直推奖励",
            'balance'=>$balance,
            'uid' => $sales['uid'],
            'aid' => $product['a_g_id'],
        ];
        
       
        
         $chaxun_ids=db('profit')->insertGetId($datayiji);
          	
  	    
     
        if($chaxun_ids){
            $moneyyi['money']=$balance;
            $moneyyi['total_achievement']=$tichenguser['total_achievement']+$tichengs;
            //$moneyyi['id']=$tichenguser['id'];
            //$updateuser=db('user')->update($moneyyi);
            $updateuser=db('user')->where('id','=',$tichenguser['id'])->update($moneyyi);
        }
        //判断上级是否有提成权利
        $shangji=db('user')->where('id','=',$tichenguser['pid'])->find();

        if($tichenguser['isStaff'] == 1 && !empty($shangji)) {
            //员工推广佣金
            $balances=$shangji['money']+$tichengs;
            $dataerji=[
                'order_id'=>$sales['body'],
                'profit_id'=>$shangji['id'],
                'ratio'=>$sales['total_fee']/100,
                'create_time'=>time(),
                'money'=>$tichengs,
                'type'=>"员工直推",
                'balance'=>$balances,
                'uid'=> $sales['uid'],
                'aid' => $product['a_g_id'],
            ];
            $chaxuner=db('profit')->insertGetId($dataerji);
            if($chaxuner){
                $moneyer['money'] = $balances;
                $moneyer['total_achievement']=$shangji['total_achievement']+$tichengs;
                $updateuser=db('user')->where('id','=',$shangji['id'])->update($moneyer);
            }

        }else if(isset($shangji) && !empty($shangji) && $tichenguser['isStaff'] != 1){
            //查询代理等级成本价格
            // /dump($shangji);
            $erjiticheng = db('agentgoods')->where('aid','=',$shangji['agent_class'])->where('gid','=',$goods['id'])->find();
            if(isset($erjiticheng) and $erjiticheng['erjiprice'] > 0 ){
                $erjiprice = $erjiticheng['erjiprice'];
            }else{
                if(isset($goods) and $goods['commission'] > 0 ){
                    $erjiprice = $goods['commission'];
                }
            }
            if(isset($erjiprice) and !empty($erjiprice)){
                $balances=$shangji['money']+$erjiprice;
                $dataerji=[
                    'order_id'=>$sales['body'],
                    'profit_id'=>$shangji['id'],
                    'ratio'=>$sales['total_fee']/100,
                    'create_time'=>time(),
                    'money'=>$erjiprice,
                    'type'=>"二级奖励",
                    'balance'=>$balances,
                    'uid'=> $sales['uid'],
                    'aid' => $product['a_g_id'],
                ];
                //dump($balances);die;
                $chaxuner=db('profit')->insertGetId($dataerji);
                if($chaxuner){
                    $moneyer['money']=$balances;
                    $moneyer['total_achievement']=$shangji['total_achievement']+$erjiprice;
                    $updateuser=db('user')->where('id','=',$shangji['id'])->update($moneyer);
                }
            }

        }
        //余额添加
    }    
  
  
  
  function fenyongss($dingdanid){
        //价格查询
        //$dingdanid='8697';
        //查询订单
        $sales=db('sales')->where('id','=',$dingdanid)->find();
        //dump($sales);die;
        //查询提出者信息
        $tichenguser=db('user')->where('id','=',$sales['sessionfpid'])->find();
        //dump($tichenguser);
        //代理等级信息
        $tichengagent=db('agent')->where('id','=',$tichenguser['agent_class'])->find();
    	//版本表查询
        $product=db('product')->where('id','=',$sales['pid'])->find();
        //商品表
        $goods=db('goods')->where('id','=',$product['a_g_id'])->find();
        //查询代理等级成本价格
        $tichenggoods=db('agentgoods')->where('aid','=',$tichengagent['id'])->where('gid','=',$goods['id'])->find();
        
        //判断代理等级成本表是否有
        //没有按goods表成本价
        //查询分成金额
        if($tichenggoods){
          $chengben=$tichenggoods['price'];
          $tichengs=$sales['total_fee']/100-$chengben;
          // dump($tichengs); dump($sales['total_fee']);
          if($tichengs < 0){
            $tichengs = 0;
          }
        }else{
          $chengben=$goods['price'];
          $tichengs=$sales['total_fee']/100-$chengben;
          if($tichengs < 0){
            $tichengs = 0;
          }
         // $tichengs=3;
        }
        //余额
        $balance=$tichenguser['money']+$tichengs;
        //插入提成表
        $datayiji=[
                      'order_id'=>$sales['body'],
                      'profit_id'=>$tichenguser['id'],
                      'ratio'=>$sales['total_fee']/100,
                      'create_time'=>time(),
                      'money'=>$tichengs,
                      'type'=>"直推奖励",
                      'balance'=>$balance,
          			  'uid' => $sales['uid'],
          			 'aid' => $product['a_g_id'],
                      ];

        $chaxun_ids=db('profit')->insertGetId($datayiji);
       	if($chaxun_ids){
        	$moneyyi['money']=$balance;
          $moneyyi['total_achievement']=$tichenguser['total_achievement']+$tichengs;
      		//$moneyyi['id']=$tichenguser['id'];
            //$updateuser=db('user')->update($moneyyi);
          	$updateuser=db('user')->where('id','=',$tichenguser['id'])->update($moneyyi);
        }
        //判断上级是否有提成权利
        $shangji=db('user')->where('id','=',$tichenguser['pid'])->find();
       
        
    	if($shangji){
              //查询代理等级成本价格
              // /dump($shangji);
             $erjiticheng = db('agentgoods')->where('aid','=',$shangji['agent_class'])->where('gid','=',$goods['id'])->find();
                if(isset($erjiticheng) and $erjiticheng['erjiprice'] > 0 ){
                    $erjiprice = $erjiticheng['erjiprice'];
                }else{
                    if(isset($goods) and $goods['commission'] > 0 ){
                        $erjiprice = $goods['commission'];
                    }
                }

              if(isset($erjiprice) and !empty($erjiprice)){
                $balances=$shangji['money']+$erjiprice;
                $dataerji=[
                                      'order_id'=>$sales['body'],
                                      'profit_id'=>$shangji['id'],
                                      'ratio'=>$sales['total_fee']/100,
                                      'create_time'=>time(),
                                      'money'=>$erjiprice,
                                      'type'=>"二级奖励",
                                      'balance'=>$balances,
                  					  'uid' => $sales['uid'],
                  					 'aid' => $product['a_g_id'],
                          ];
                  //dump($balances);die;
                  $chaxuner=db('profit')->insertGetId($dataerji);
                  if($chaxuner){
                  $moneyer['money']=$balances;
                    $moneyer['total_achievement']=$shangji['total_achievement']+$erjiprice;
                  //$moneyer['id']=$shangji['id'];
                  $updateuser=db('user')->where('id','=',$shangji['id'])->update($moneyer);
                  }
              }
        }
        //余额添加
     }
  
  
  //接口查询
  //手机三要素验证（三网合一 A 版）接口 
    public function yunyingshang($name,$mobile,$idcard)
    {
        $appid="YL9SiL2TeabDRAja";
         $appSecurity="YL9SiL2TeabDRAja0LV1XQdzUrg9Nolw";
         $timestamp=time();
         //app_id={app_id}&app_security={app_security}&timestamp={tim estamp} 进行 md5 加密计算即可得到 sign 签名。 
         $one='app_id='.$appid.'&app_security='.$appSecurity.'&timestamp='.$timestamp;
         $sign=md5($one);
          $PostArry2 = array(
              "app_id" => $appid,
              "timestamp" => $timestamp,
              "sign" => $sign
              );
           $request1_url="https://b.shumaidata.com/api/authorize";
          $return1 =$this->Post($PostArry2, $request1_url);  //发送请求到服务器，并输出返回结果。
        $json=json_decode($return1,true);
       //dump($json);die;
          $token=$json['result']['token'];
          //$name='王升升';//$sun_chaxunss['names'];
          //$idcard='421126199512026319';//$sun_chaxunss['idcard'];
         // $mobile='18872695647';//$sun_chaxunss['tel'];
        $yunyingshang1url="https://b.shumaidata.com/api/v2/mobile/verify_real_name";
         $content="application/x-www-form-urlencoded";
        $yingshang1header=array(
              'token:'.$token,
              'content-type:'.$content
        );
        $datayunyingshang1 = array(
              "app_id" => $appid,
              "name" => $name,
              "idcard" => $idcard,
              "mobile" => $mobile
              );
          $yunyingshang1rture =$this->Header($datayunyingshang1,$yingshang1header, $yunyingshang1url);  //发送请求到服务器，并输出返回结果。
          //$yunyingshangs1=json_decode($yunyingshang1rture,true);
          return $yunyingshang1rture;
    }
    //在网时长
    public function phone($name,$mobile,$idcard)
    {
        $appid="YL9SiL2TeabDRAja";
         $appSecurity="YL9SiL2TeabDRAja0LV1XQdzUrg9Nolw";
         $timestamp=time();
         //app_id={app_id}&app_security={app_security}&timestamp={tim estamp} 进行 md5 加密计算即可得到 sign 签名。 
         $one='app_id='.$appid.'&app_security='.$appSecurity.'&timestamp='.$timestamp;
         $sign=md5($one);
          $PostArry2 = array(
              "app_id" => $appid,
              "timestamp" => $timestamp,
              "sign" => $sign
              );
           $request1_url="https://b.shumaidata.com/api/authorize";
          $return1 =$this->Post($PostArry2, $request1_url);  //发送请求到服务器，并输出返回结果。
        $json=json_decode($return1,true);
       //dump($json);die;
          $token=$json['result']['token'];
         // $name='王升升';//$sun_chaxunss['names'];
         // $idcard='421126199512026319';//$sun_chaxunss['idcard'];
         // $mobile='18872695647';//$sun_chaxunss['tel'];
       $yunyingshangurl="https://b.shumaidata.com/api/v2/mobile/get_online_interval";
         $content="application/x-www-form-urlencoded";
        $yingshangheader=array(
              'token:'.$token,
              'content-type:'.$content
        );
        $datayunyingshang = array(
              "app_id" => $appid,
              "name" => $name,
              "idcard" => $idcard,
              "mobile" => $mobile
              );
          $yunyingshangrture = $this->Header($datayunyingshang,$yingshangheader, $yunyingshangurl);  //发送请求到服务器，并输出返回结果。
          //$yunyingshangs=json_decode($yunyingshangrture,true);
          return $yunyingshangrture;
        //dump($yunyingshangs);die; 
    }
    //个人涉诉信息查询接口
    public function geren($name,$mobile,$idcard)
    {
        $appid="YL9SiL2TeabDRAja";
         $appSecurity="YL9SiL2TeabDRAja0LV1XQdzUrg9Nolw";
         $timestamp=time();
         //app_id={app_id}&app_security={app_security}&timestamp={tim estamp} 进行 md5 加密计算即可得到 sign 签名。 
         $one='app_id='.$appid.'&app_security='.$appSecurity.'&timestamp='.$timestamp;
         $sign=md5($one);
          $PostArry2 = array(
              "app_id" => $appid,
              "timestamp" => $timestamp,
              "sign" => $sign
              );
           $request1_url="https://b.shumaidata.com/api/authorize";
          $return1 =$this->Post($PostArry2, $request1_url);  //发送请求到服务器，并输出返回结果。
        $json=json_decode($return1,true);
       //dump($json);die;
          $token=$json['result']['token'];
         // $name='王升升';//$sun_chaxunss['names'];
         // $idcard='421126199512026319';//$sun_chaxunss['idcard'];
          //$mobile='18872695647';//$sun_chaxunss['tel'];
         $gerenurl="https://b.shumaidata.com/api/v2/lawsuit_check/get";
        $gerenheader=array(
              'token:'.$token
        );
        $datageren = array(
              "app_id" => $appid,
              "name" => $name,
              "idcard" => $idcard,
             // "platform" => $platform
              );
          $gerenretrue = $this->Get($datageren,$gerenheader, $gerenurl);  //发送请求到服务器，并输出返回结果。
          //$gerenres=json_decode($gerenretrue,true);
        //dump($gerenres);die; 
        return $gerenretrue;
    }
    //多头借贷与逾期记录综合查询接口
    public function duotou($name,$mobile,$idcard)
    {
        $appid="YL9SiL2TeabDRAja";
         $appSecurity="YL9SiL2TeabDRAja0LV1XQdzUrg9Nolw";
         $timestamp=time();
         //app_id={app_id}&app_security={app_security}&timestamp={tim estamp} 进行 md5 加密计算即可得到 sign 签名。 
         $one='app_id='.$appid.'&app_security='.$appSecurity.'&timestamp='.$timestamp;
         $sign=md5($one);
          $PostArry2 = array(
              "app_id" => $appid,
              "timestamp" => $timestamp,
              "sign" => $sign
              );
           $request1_url="https://b.shumaidata.com/api/authorize";
          $return1 =$this->Post($PostArry2, $request1_url);  //发送请求到服务器，并输出返回结果。
        $json=json_decode($return1,true);
       //dump($json);die;
          $token=$json['result']['token'];
          //$name='王升升';//$sun_chaxunss['names'];
         /// $idcard='421126199512026319';//$sun_chaxunss['idcard'];
          //$mobile='18872695647';//$sun_chaxunss['tel'];
         $duotouurl="https://b.shumaidata.com/api/v2/multi_loan/get";
        $cycle='12';
          $platform='0';
        $duotoucontent="application/x-www-form-urlencoded";
        $duotouheader=array(
              'token:'.$token,
              'content-type:'.$duotoucontent
        );
        $dataduotou = array(
              "app_id" => $appid,
              "mobile" => $mobile,
              "cycle" => $cycle,
              "platform" => $platform
              );
          $dataduoreyure = $this->Header($dataduotou,$duotouheader, $duotouurl);  //发送请求到服务器，并输出返回结果。
          //$dataduos=json_decode($dataduoreyure,true);
        //dump($dataduos);die; 
        return $dataduoreyure;
    }
    //金融黑名单查询接口
    public function jinron($name,$mobile,$idcard)
    {
        $appid="YL9SiL2TeabDRAja";
         $appSecurity="YL9SiL2TeabDRAja0LV1XQdzUrg9Nolw";
         $timestamp=time();
         //app_id={app_id}&app_security={app_security}&timestamp={tim estamp} 进行 md5 加密计算即可得到 sign 签名。 
         $one='app_id='.$appid.'&app_security='.$appSecurity.'&timestamp='.$timestamp;
         $sign=md5($one);
          $PostArry2 = array(
              "app_id" => $appid,
              "timestamp" => $timestamp,
              "sign" => $sign
              );
           $request1_url="https://b.shumaidata.com/api/authorize";
          $return1 =$this->Post($PostArry2, $request1_url);  //发送请求到服务器，并输出返回结果。
        $json=json_decode($return1,true);
       //dump($json);die;
          $token=$json['result']['token'];
         // $name='王升升';//$sun_chaxunss['names'];
          //$idcard='421126199512026319';//$sun_chaxunss['idcard'];
         // $mobile='18872695647';//$sun_chaxunss['tel'];
        $jinronurl="https://b.shumaidata.com/api/v2/blacklist/check";
        $jinroncontent="application/x-www-form-urlencoded";
         $headerjinron=array(
              'token:'.$token,
              'content-type:'.$jinroncontent
        );
       
        $datajinron = array(
              "app_id" => $appid,
              "name" => $name,
              "mobile" => $mobile,
              "idcard" => $idcard
              );
          $jinronreture =  $this->Get($datajinron,$headerjinron, $jinronurl);  //发送请求到服务器，并输出返回结果。
          //$jinronreturereture=json_decode($jinronreture,true);
        //dump($jinronreturereture);die; 
        return $jinronreture;
    }
    //
    public function bairo($name,$mobile,$idcard){
      $targetList = array(
      array(
        
        "id" =>$idcard,'421126199512026319',//$sun_chaxun['idcard'],
        "cell" =>$mobile,'18872695647',//$sun_chaxun['tel'],
              "name" =>$name,//'王升升',//$sun_chaxun['names'],
              //"id" => "310224196209243110",  
              "strategy_id"=>"STR0003076",
          //"conf_id"=>"MCP0000970",
              //"mail" => "1320220359@qq.com",
              //"bank_id" => "4367421216244199784"
        )
      );
      $temp_res_arr=$this->ceshi($targetList);
     // dump($temp_res_arr);die;
     return $temp_res_arr;
  }
     //post传值方法
         function request_post($headers,$url = '', $post_data = array()) 
        {
            if (empty($url) || empty($post_data)) {
                return false;
            }
           
            $o = "";
            foreach ( $post_data as $k => $v ) 
            { 
                $o.= "$k=" . urlencode( $v ). "&" ;
            }
            $post_data = substr($o,0,-1);
            
            
            
            $postUrl = $url;
            $curlPost = $post_data;
            $ch = curl_init();//初始化curl
            curl_setopt($ch, CURLOPT_URL,$postUrl);//抓取指定网页
            curl_setopt($ch, CURLOPT_HEADER, 0);//设置header
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE); // 对认证证书来源的检查
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE); // 从证书中检查SSL加密算法是否
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);//要求结果为字符串且输出到屏幕上
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_POST, true);//post提交方式
            curl_setopt($ch, CURLOPT_POSTFIELDS, $curlPost);
            $data = curl_exec($ch);//运行curl

            curl_close($ch);
            
            return $data;
    }
    function Header($PostArry,$array,$url)
    {

      $headers = $array;
      //$idCard="421181199110045597";
      //$idCards= json_encode($idCard);//格式化参数
      //dump($idCard);die;
      //$urls="https://b.shumaidata.com/api/v1/carrier/task?app_id=YL9SiL2TeabDRAja&account=18062677701&password=123456&idCard=".$idCard."&realName=刘伟祥&notifyUrl";
       $posturls= json_encode($url);//格式化参数
      $postData = $PostArry;
      $postDataString = http_build_query($postData);//格式化参数
      //初始化
      //dump($postDataString);die;
    $curl = curl_init();
    //dump($postDataString);die;
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE); // 对认证证书来源的检查
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE); // 从证书中检查SSL加密算法是否存在
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

    //设置头文件的信息作为数据流输出
    //curl_setopt($curl, CURLOPT_HEADER, 0);
    //设置获取的信息以文件流的形式返回，而不是直接输出。
    //curl_setopt($curl, CURLOPT_POSTFIELDS, $postDataString); // Post提交的数据包
    curl_setopt($curl, CURLOPT_TIMEOUT, 60); // 设置超时限制防止死循环返回
    //设置抓取的url
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($curl, CURLOPT_POST, true); // 发送一个常规的Post请求
    curl_setopt($curl, CURLOPT_POSTFIELDS,$postDataString);
    
    //执行命令
   $tmpInfo = curl_exec($curl); // 执行操作
        if (curl_errno($curl)) {

            $tmpInfo = curl_error($curl);//捕抓异常
        }
    //关闭URL请求
    curl_close($curl); // 关闭CURL会话
        return $tmpInfo; // 返回数据
  }
  
  function ceshi($targetList)
     {
       require_once ROOT_PATH.'bairoconfig/cons.php';
       require_once ROOT_PATH.'bairoconfig/Corebairo.php';
  /**$appSecurity="YL9SiL2TeabDRAja0LV1XQdzUrg9Nolw";
  $account = "mmapiStr";
  $password = "mmapiStr";
  $apicode = "3003045";
  $login_url = "https://api.100credit.cn/bankServer2/user/login.action";
  $querys = array(
        //  'huaxiang' => 'https://api.100credit.cn/huaxiang/v1/get_report',
         // 'haina' => 'https://api.100credit.cn/HainaApi/data/getData.action',
        //  'TrinityForceAPI' => 'https://api.100credit.cn/trinity_force/v1/get_data',
          'strategyApi'=>"https://api.100credit.cn/strategyApi/v1/hxQuery",
      );**/
     // dump($con['account']);die;
/**$targetList = array(
array(
  "id" => "310224196209243110",  
  "cell" => "15921188518",   
        "name" => "阿斯加",
        //"id" => "310224196209243110",  
        "strategy_id"=>"STR0002763",
        //"mail" => "000000@qq.com",
        //"bank_id" => "4367421216244199784"
)
);**/
   
   $Corebairo    = new Corebairo($con['account'],$con['password'],$con['apicode'], $querys,$headerTitle);
$Core =Corebairo::getInstance($con['account'],$con['password'],$con['apicode'], $querys,$headerTitle);
$temp_res_arr=$Corebairo-> query($targetList);
      return $temp_res_arr;
//dump($temp_res_arr);die;
  }
  function Post($PostArry,$request_url)
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
        curl_setopt($curl,CURLOPT_RETURNTRANSFER,true);

        $tmpInfo = curl_exec($curl); // 执行操作
        if (curl_errno($curl)) {

            $tmpInfo = curl_error($curl);//捕抓异常
        }
        curl_close($curl); // 关闭CURL会话
        return $tmpInfo; // 返回数据
    }
    function Get($PostArry,$array,$url){

      $headers = $array;
      $postData = $PostArry;
      //$postDataString = http_build_query($postData);//格式化参数
      //初始化
    $curl = curl_init();
    
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE); // 对认证证书来源的检查
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE); // 从证书中检查SSL加密算法是否存在
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    //设置头文件的信息作为数据流输出
    //curl_setopt($curl, CURLOPT_HEADER, 0);
    //设置获取的信息以文件流的形式返回，而不是直接输出。
    //curl_setopt($curl, CURLOPT_POSTFIELDS, $postDataString); // Post提交的数据包
    curl_setopt($curl, CURLOPT_TIMEOUT, 60); // 设置超时限制防止死循环返回
    //设置抓取的url
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
    //curl_setopt($curl, CURLOPT_POST, true); // 发送一个常规的Post请求
     if (is_array($postData)) {
            if (stripos($url, "?") === FALSE) {
                $url .= '?';
            }
            $url .= http_build_query($postData);
        }
    //curl_setopt($curl, CURLOPT_POSTFIELDS,$postDataString);
    curl_setopt($curl, CURLOPT_URL, $url);
    //执行命令
   $tmpInfo = curl_exec($curl); // 执行操作
        if (curl_errno($curl)) {

            $tmpInfo = curl_error($curl);//捕抓异常
        }
    //关闭URL请求
    curl_close($curl); // 关闭CURL会话
        return $tmpInfo; // 返回数据
  }
  
  
   //多头负债接口
  function top_image($names,$mobile,$idcard){
        $appId = '49645fcb675d2f46cbf54fbde5f543a0';
        $appSecret = 'd6c6ea8d79928a85cc016b40000cd4db';
        $url = 'https://sec2.dingxiang-inc.com/api/dataplatform/loansynchronizationquery';
        $sequenceNo = date('ymd').uniqid();
        $timestamp = time();
        #$token = '0315201448000VkyUKd6o186MqHL7Smc';
        $param = array(
            'customerId' => $appId,
            'timeStamp' => $timestamp,
            'sign' =>MD5($appSecret . $appId . $timestamp . $appSecret),
            'name' => $names,
            'idcard' => $idcard,
            'mobile' => $mobile,
        );

        //吴亚栋 340822199512080958  15055636776
        //张涛 620102197906026916  13893386530
        //陈微  420821198111112364  13487070044
        //echo (http_build_query($param));die;
        // var_dump($url.$getparam);exit;
        $crawlerResult = curlPost($url,$param);
        return  $crawlerResult;
        #echo "<pre>";
        #var_dump(json_decode($crawlerResult,true));
    }
  
  
}


