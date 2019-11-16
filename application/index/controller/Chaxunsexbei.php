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
header("content-type:text/html;charset=utf8");
/**
 * 奖励明细
 * Class Order
 * @package app\admin\controller
 */
class Chaxun extends Controller
{
  public function wangji()
    {
      return $this->fetch();
    }
    public function index()
    {
      $uid=session('uid');
      $p_id=input('p_id');
       $xing=array('赵','钱','王','姜','刘','李','管','彭','徐','许','曹','李','王','吴','帅','燕','蒋','古','王','李','徐','陈','曹','王','李','李','程','匡','罗','杨','高','郭','陶','陈','田','朱','黄','徐','彭','江');
        $this->assign('xing',$xing);
         $price=input('price');
        // dump($price);die;
        $this->assign('price',$price);
        $this->assign('p_id',$p_id);
        $this->assign('uid',$uid);
      if(!empty($p_id)){
       $product=db('product')->where('id','=',$p_id)->select();
        $productss=db('product')->where('id','=',$p_id)->find();
        if($productss['a_g_id'] == 2 ){
        	 if($productss['price'] > 40 ){
        		 echo '<p style="font-size:100px;text-align: center;margin-top:500px;">该链接已失效，请重新获取</p>';
               die;
       		 }
        }
         if($productss['a_g_id'] == 3 ){
        	 if($productss['price'] > 50 ){
        		 echo '<p style="font-size:100px;text-align: center;margin-top:500px;">该链接已失效，请重新获取</p>';
                die;
       		 }
        }
        if(!empty($productss['uid'])){

          session('ppp_id',$productss['uid']);
        }
       $this->assign('product',$product);
      }
       $goods=db('product')->order('descc asc')->where('define','=',1)->select();
       $this->assign('goods',$goods);
      return $this->fetch();
    }
     //示例报告
    public function yangshi2()
    {
        return $this->fetch();
    }
    //示例报告
    public function yangshi1()
    {
        return $this->fetch();
    }
    //查询订单状态
  public function order_query(){
    $out_trade_no=input('order_no');
    $result=Db::name("sales")->where(array("out_trade_no"=>$out_trade_no))->find();
    if ($result["status"]==1){
      echo base64_encode(base64_encode($result['id']));//$result['id'];
      exit();
    }else{
      echo "0";
      exit();
    }
  }
     //支付
    public function pay()
    {
        //查询价格
        $price=input('price');
        //版本id
        $pid=input('pid');
        //dump($pid);die;
        //查询人id
        $uid=input('uid');
        //版本信息
        $product=db('product')->where('id','=',$pid)->find();
        //dump($pid);die;
         //被扫码人信息
        $sao_user=db('user')->where('id','=',$uid)->find();
        if($product){
          //插入订单表
           $time=time();
           $ordernumber="D".$uid.$time;
           $order_no=mt_rand().time();
            $params = 
              [
                    'body' =>$ordernumber,
                    'out_trade_no' => $order_no,
                    'total_fee' =>$price*100, //$price*100
                    'product_id' =>$time,
                  'pid' =>$pid,
                  'uid' =>$uid,
                  'status' =>1,//测试状态为1
                   'sessionid' =>$uid,
                   'sessionfpid' =>$product['uid']//被扫码人的id
                ];
            //$sales_id=db('sales')->insertGetId($params);
            $sales_id='8697';
            $sales_s=db('sales')->where('id','=',$sales_id)->find();
            $order_no_s=$sales_s['out_trade_no'];
          //插入查询表查询表
           $chaxun_data=[
                'ordernumber'=>$ordernumber,
                'uid'=>$uid,
                'dates'=>$time,
                'remarks'=>0,
                'pid'=>$pid,
                'price'=>$price,
                'sid'=>$sales_id,
                'names'=>$sao_user['names'],
                'idcard'=>$sao_user['idcard'],
                'tel'=>$sao_user['mobile'],
                'ma_id'=>$product['uid']
              ];
              //$chaxun_id=db('chaxun')->insertGetId($chaxun_data);
              $chaxun_id='1407';
              //手机三要素验证（三网合一 A 版）接口 
          // $yunyingshang=$this->yunyingshang();
          // //在网时长
          // $phone=$this->phone();
          // //个人涉诉信息查询接口
          // $geren=$this->geren();
          // //多头借贷与逾期记录综合查询接口
          // $duotou=$this->duotou();
          // //金融黑名单查询接口
          // $jinron=$this->jinron();
          // //百融查询接口
          // $bairo=$this->bairo();
          //     //插入查询返回信息表
          //  $bairo_data=[
          //       'chaxunid'=>$chaxun_id,
          //       'json'=>$bairo,
          //       'tianyan_duotou'=>$duotou,
          //       'tianyan_geren'=>$geren,
          //       'tianyan_jinro'=>$jinron,
          //       'tianyan_mobile'=>$yunyingshang,
          //       'tianyan_phone'=>$phone,
                //'tianyan_tonghua'=>$sao_user['names']
              //];
              //$bairo_id=db('bairo')->insert($bairo_data);
              $bairo_id='1';
        }
         $this->assign("order_no_s",$order_no_s);
        //dump($bairo_data);die;
        return $this->fetch();
    }
   //查询结果
    public function view()
    {
      $dingdanid=input('dingdanid');
      $session_uid=session('uid');
      $this->assign("session_uid", $session_uid);
      $dingdanids=base64_decode(base64_decode($dingdanid));
      //$dingdanids=8697;
      $chaxun=db('chaxun')->where('sid','=',$dingdanids)->find();
      //查询手机号今天是否查询过运营商
      //如果今天已经查询过直接拿数据
     $time_jin=time();
      
      $chaxun_jin=db('chaxun')->where('tel','=',$chaxun['tel'])->where('tel','=',$chaxun['tel'])->where('id','neq',$chaxun['id'])->order('id desc')->find();
      $cha_time=$time_jin-$chaxun_jin['dates'];
      $bairo_new=db('bairo')->where('chaxunid','=',$chaxun['id'])->find();
      if(empty($bairo_new['tianyan_tonghua'])){
      if($cha_time < 86400){
         $bairo_jin=db('bairo')->where('chaxunid','=',$chaxun_jin['id'])->find();
        if($bairo_jin){
        	$json_jin['tianyan_tonghua']=$bairo_jin['tianyan_tonghua'];
          $json_jin['chaxunid']=$chaxun['id'];
          	$eidt_json=db('bairo')->where('chaxunid','=',$chaxun['id'])->update($json_jin);
        }
      }
      }
   
      
      
      $this->assign("chaxun", $chaxun);
      $this->assign("dingdanids", $dingdanids);
      //个人信息
      $op=substr_replace($chaxun['tel'],'****',3,4);
      $opnames=substr_replace($chaxun['names'],'*',3,3);
      $opcard=substr_replace($chaxun['idcard'],'********',6,8);
      $user=db('user')->where("id","=",$chaxun['ma_id'])->find();
      $dizhi=db('user')->where("mobile","=",$chaxun['tel'])->find();
      $agent=db('agent')->where("id","=",$user['agent_class'])->find();
      
      $this->assign("agent", $agent);
      $this->assign("dizhi", $dizhi);
      $this->assign("op", $op);
      $this->assign("opnames", $opnames);
      $this->assign("opcard", $opcard);
      $product=db('product')->where("id","=",$chaxun['pid'])->find();
      $priceid=$product['a_g_id'];
      //$priceid=3;
      $this->assign("priceid", $priceid);
      //百融
      $bairo=db('bairo')->where('chaxunid','=',$chaxun['id'])->find();
      $temp_res_arr=$bairo['json'];
      //$matches=preg_match_all('/'.$find.'/', $temp_res_arr);
      $temp_res = json_decode($temp_res_arr,true);
      $temp_res['scorecashon']=$this->pingfen($temp_res);
      $this->assign("temp_res", $temp_res);
      //在网时长
      $tianyan_phone=$bairo['tianyan_phone'];
      $phone = json_decode($tianyan_phone,true);
      if(isset($phone['result'])){
      $all_user_phone=$phone['result'];
      }else{
        $all_user_phone=array();
      }
      //$all_user_phone = $phone['result'];
      $this->assign("all_user_phone", $all_user_phone);
      //实名制
      $tianyan_mobile=$bairo['tianyan_mobile'];
      $mobile = json_decode($tianyan_mobile,true);
      //$all_user_mobile = $mobile['result'];
       if(isset($mobile['result'])){
      $all_user_mobile=$mobile['result'];
      }else{
        $all_user_mobile=array();
      }
      $this->assign("all_user_mobile", $all_user_mobile);
      //个人不良信息
      $tianyan_geren=$bairo['tianyan_geren'];
      $all_user_geren = json_decode($tianyan_geren,true);
      $this->assign("all_user_geren", $all_user_geren);
      //dump($all_user_geren);die;
     if(isset($all_user_geren['result']['lawSuitInfo']['allList'])){
      $all_user_geren_alllist=$all_user_geren['result']['lawSuitInfo']['allList'];
      }else{
        $all_user_geren_alllist=array();
      }
      $this->assign("all_user_geren_alllist", $all_user_geren_alllist);
      //金融黑名单
      $tianyan_jinro=$bairo['tianyan_jinro'];
      $jinro = json_decode($tianyan_jinro,true);
      if(isset($jinro['result'])){
      $all_user_jinro=$jinro['result'];
      }else{
        $all_user_jinro=array();
      }
     // $all_user_jinro = $jinro['result'];
      $this->assign("all_user_jinro", $all_user_jinro);
      //多头注册
      $tianyan_duotou=$bairo['tianyan_duotou'];
      $duotou = json_decode($tianyan_duotou,true);
      //省市
      if(isset($duotou['result']['province'])){
            if(isset($duotou['result']['city'])){
                  $sheng_city['sheng']=$duotou['result']['province'];
                  $sheng_city['shi']=$duotou['result']['city'];
            }else{
                  $sheng_city['shi']=$duotou['result']['city'];
            }
            $up_chaxun=db('chaxun')->where('sid','=',$dingdanids)->update($sheng_city);
      }else{
            //查询查询人的信息
            $up_chaxun=db('user')->where("mobile","=",$chaxun['tel'])->find();
            $user_up['sheng']=$up_chaxun['province'];
            $user_up['shi']=$up_chaxun['city'];
            $up_chaxun=db('chaxun')->where('sid','=',$dingdanids)->update($user_up);
      }
       $this->assign("duotou", $duotou);
      $doutuo_s=$duotou['result']['detail'];
       if(isset($duotou['result']['detail'])){
      $doutuo_s=$duotou['result']['detail'];
      }else{
        $doutuo_s=array();
      }
      $num=count($doutuo_s);
      if($num == 0){
        $all_user_duotou_zhuce=array();
         $this->assign("all_user_duotou_zhuce", $all_user_duotou_zhuce);
        $all_user_duotou_shengqin=array();
        $this->assign("all_user_duotou_shengqin", $all_user_duotou_shengqin);
        $all_user_duotou_fangkuan=array();
        $this->assign("all_user_duotou_fangkuan", $all_user_duotou_fangkuan);
        $all_user_duotou_bohui=array();
        $this->assign("all_user_duotou_bohui", $all_user_duotou_bohui);
        $all_user_duotou_yuqi=array();
        $this->assign("all_user_duotou_yuqi", $all_user_duotou_yuqi);
        $all_user_duotou_qiankaun=array();
        $this->assign("all_user_duotou_qiankaun", $all_user_duotou_qiankaun);
      }
      
      $all_user_duotou_zhuce=array();
      $all_user_duotou_shengqin=array();
      $all_user_duotou_fangkuan=array();
       $all_user_duotou_bohui=array();
       $all_user_duotou_yuqi=array();
         $all_user_duotou_qiankaun=array();
      for($i=0;$i<$num;$i++){
        if($doutuo_s[$i]['type']=='TYD002'){
            $all_user_duotou_zhuce=$doutuo_s[$i]['data'];
          }
        if($doutuo_s[$i]['type']=='TYD004'){
            $all_user_duotou_shengqin=$doutuo_s[$i]['data'];
        }
        if($doutuo_s[$i]['type']=='TYD007'){
            $all_user_duotou_fangkuan=$doutuo_s[$i]['data'];
        }
        if($doutuo_s[$i]['type']=='TYD009'){
            $all_user_duotou_bohui=$doutuo_s[$i]['data'];
        }
        if($doutuo_s[$i]['type']=='TYD012'){
            $all_user_duotou_yuqi=$doutuo_s[$i]['data'];
        }
        if($doutuo_s[$i]['type']=='TYD013'){
            $all_user_duotou_qiankaun=$doutuo_s[$i]['data'];
        } 
      }
      $this->assign("all_user_duotou_zhuce", $all_user_duotou_zhuce);
      $this->assign("all_user_duotou_shengqin", $all_user_duotou_shengqin);
      $this->assign("all_user_duotou_fangkuan", $all_user_duotou_fangkuan);
      $this->assign("all_user_duotou_bohui", $all_user_duotou_bohui);
      $this->assign("all_user_duotou_yuqi", $all_user_duotou_yuqi);
      $this->assign("all_user_duotou_qiankaun", $all_user_duotou_qiankaun);
        //通话记录
        $tianyan_tonghua=$bairo['tianyan_tonghua'];
         $ress=str_replace("\\","",$tianyan_tonghua); 
         //$resss_1=substr($ress, 1, -1);
         $tianyan_tonghuas=json_decode($ress);
         if(isset($tianyan_tonghuas->success)){
            $su=$tianyan_tonghuas->success;
         }else{
          $su=false;
         }
         //dump($tianyan_tonghuas);die;
         if($su == true){
            $tonghuas=$tianyan_tonghuas->data;
            $tonghua_pd=1;
          }else{
              $tonghuas=array();
              $tonghua_pd=0;
         }
         //dump($tonghuas->active_degree_detail->no_call_day_1m);die;
         //$this->assign("tianyan_tonghuas", $tianyan_tonghuas);
         $this->assign("tonghuas", $tonghuas);
         $this->assign("tonghua_pd", $tonghua_pd);
            if(isset($tianyan_tonghuas->data->friend_circle->call_num_top3_3m)){
                $call_num_top3_3m=$tianyan_tonghuas->data->friend_circle->call_num_top3_3m;
              }else{
                $call_num_top3_3m=array();
              }
                //dump($call_num_top3_3m[0]->peer_number);die;
                $this->assign("call_num_top3_3m", $call_num_top3_3m);
            //dump($tonghuas->friend_circle->active_degree_detail->no_call_day_1m);die;
             if(isset($tianyan_tonghuas->data->friend_circle->call_num_top3_6m)){
                $call_num_top3_6m=$tianyan_tonghuas->data->friend_circle->call_num_top3_6m;
                }else{
                  $call_num_top3_6m=array();
                }
                $this->assign("call_num_top3_6m", $call_num_top3_6m);
                //dump($call_num_top3_6m);die;
             if(isset($tianyan_tonghuas->data->friend_circle->call_contact_detail)){
                $call_contact_detail=$tianyan_tonghuas->data->friend_circle->call_contact_detail;
              }else{
                $call_contact_detail=array();
                $call_contact_detail_s=array();
              }
                $nums=count($call_contact_detail);
               $shuliang= $agent['nums'];
                for($a=0;$a<$nums;$a++){
                    if($a<$shuliang){
                        $call_contact_detail_s[$a]=$call_contact_detail[$a];
                    }
                }
                $this->assign("call_contact_detail_s", $call_contact_detail_s);
                //dump($call_contact_detail_s);die;
            //dump($tonghuas);die;
        ///dump($tianyan_tonghuas->success);dump($tianyan_tonghuas);die;
        // $ress=str_replace("\\","",$res); 
        //  $resss_1=substr($ress, 1, -1);
        //  $gr1=json_decode($resss_1);
      //dump($doutuo_s);die;
      return $this->fetch('view');
    }
    public function pingfen($temp_res)
    {
                if(isset($temp_res['als_m12_id_bank_allnum'])){
              if(isset($temp_res['als_m12_id_nbank_allnum'])){
                  $max=$temp_res['als_m12_id_bank_allnum'] + $temp_res['als_m12_id_nbank_allnum'];
              }else{
                $max=$temp_res['als_m12_id_bank_allnum'];
              }
          }else{
              if(isset($temp_res['als_m12_id_nbank_allnum'])){
                  $max=$temp_res['als_m12_id_nbank_allnum'];
              }else{
                $max=0;
              }
          }
            
                if(!empty($max))
              {
                $fen=100 -$max -5;
                if($fen<28)
                {
                  $fen=28;
                }
              }else{
                $fen=95;
              }
            
             
            //法院执行人
            if(isset($temp_res['flag_execution']))
            {
                 if($temp_res['flag_execution'] == 1){
                  
                      $fen=$fen/2;
                  }
            }
         return $fen;
         
    }
    //发送短信
    public function send()
    {
      $password=input('fuwuma');
      $token=input('token');
      //$token=$this->token();
      $dingdanid=input('dingdanid');
      $dingdanids=base64_decode(base64_decode($dingdanid));
      $chaxun=db('chaxun')->where('sid','=',$dingdanids)->find();
      $account=$chaxun['tel'];
      $idCard=$chaxun['idcard'];
      $realName=$chaxun['names'];
     // return $dingdanids;
      $tradeNo=$this->yanzhengma($token,$account,$password,$idCard,$realName);
      return $tradeNo;
      //return 1111;
    }
  	//发送短信
    public function sendss()
    {
      $password=input('fuwuma');
      $token=input('token');
      //$token=$this->token();
      $dingdanid=input('dingdanid');
      $dingdanids=base64_decode(base64_decode($dingdanid));
      $chaxun=db('chaxun')->where('id','=',$dingdanids)->find();
      $account=$chaxun['tel'];
      $idCard=$chaxun['idcard'];
      $realName=$chaxun['names'];
     // return $dingdanids;
      $tradeNo=$this->yanzhengma($token,$account,$password,$idCard,$realName);
      return $tradeNo;
      //return 1111;
    }
     //接收查询短信
    public function codes()
    {
        //查询价格
        //$price=input('price');
        //版本id
        //$pid=input('pid');
        //查询人id
        //$uid=input('uid');
        $dingdanids=input('dingdanids');
        $dingdanid=base64_encode(base64_encode($dingdanids));
        //$dingdanids=base64_decode(base64_decode($dingdanid));
        $chaxun=db('chaxun')->where('sid','=',$dingdanids)->find();
        //dump($chaxun);die;
        //版本信息
         $token=$this->token();
        // $tradeNo=$this->yanzhengma($token);
        // $token='90cc208298a8e26754fc18c4e69902985c6cb9f70cf234aacce2dc32';
        // $tradeNo='201902201022478348703004';
        // $mobile=$chaxun['tel'];
        // $idcard=$chaxun['idcard'];
        // $name=$chaxun['names'];
        //  $tonghua=$this->tonghua($token,$tradeNo,$mobile,$idcard,$name);
        // dump($tonghua);die;
        //dump($token);dump($tradeNo);die;230337
        $this->assign("token",$token);
        // $this->assign("tradeNo",$tradeNo);
        $this->assign("dingdanid",$dingdanid);
        return $this->fetch();
    }
   //接收查询短信
    public function codesss()
    {
        //查询价格
        //$price=input('price');
        //版本id
        //$pid=input('pid');
        //查询人id
        //$uid=input('uid');
        $dingdanids=input('dingdanids');
      $this->assign("dingdanids",$dingdanids);
        $dingdanid=base64_encode(base64_encode($dingdanids));
        //$dingdanids=base64_decode(base64_decode($dingdanid));
        $chaxun=db('chaxun')->where('sid','=',$dingdanids)->find();
        //dump($chaxun);die;
        //版本信息
         $token=$this->token();
        // $tradeNo=$this->yanzhengma($token);
        // $token='90cc208298a8e26754fc18c4e69902985c6cb9f70cf234aacce2dc32';
        // $tradeNo='201902201022478348703004';
        // $mobile=$chaxun['tel'];
        // $idcard=$chaxun['idcard'];
        // $name=$chaxun['names'];
        //  $tonghua=$this->tonghua($token,$tradeNo,$mobile,$idcard,$name);
        // dump($tonghua);die;
        //dump($token);dump($tradeNo);die;230337
        $this->assign("token",$token);
        // $this->assign("tradeNo",$tradeNo);
        $this->assign("dingdanid",$dingdanid);
        return $this->fetch();
    }
    //.查询状态
     function zhuangtai(){
        header("content-type:text/html;charset=utf8");
        $token=input('token');
        //$token='90cc208298a8e26754fc18c4e69902985c9c45e20cf212844b1e97bd';
        $tradeNo=input('tradeNo');
        //$tradeNo='201903281156240136415652';
        //return $tradeNo;
      
        $content="application/x-www-form-urlencoded";
        $headers=array(
              'token:'.$token,
              'content-type:'.$content
        );
       // $code_data['app_id']=$app_id;
        //$code_data['tradeNo']=$tradeNo;
        $url = 'https://b.shumaidata.com/api/v1/carrier/getTaskStatus';
        $tonghua_data['app_id']= 'YL9SiL2TeabDRAja';
       // $tonghua_data['month']='2019-01';
        $tonghua_data['tradeNo']=$tradeNo;//'201902170931188508454214';
        $res = $this->get_url($tonghua_data,$headers,$url);   // ($tonghua_data,$headers,$url);
        //dump($res);die;
        //插入通话记录
         $ress=str_replace("\\","",$res); 
         //$resss_1=substr($ress, 1, -1);
         $gr1=json_decode($ress);
         //dump($gr1);die;
        $value=$gr1->success;
        //dump($value);die;
       // return $value;
        if($value == true){
          return $value=$gr1->data->description;
        }else{
          return 0;
        }
    }
    //.查询通话
     function tonghuass(){
        header("content-type:text/html;charset=utf8");
        $token=input('token');
        //$token='90cc208298a8e26754fc18c4e69902985c9c45e20cf212844b1e97bd';
        $tradeNo=input('tradeNo');
        //$tradeNo='201903281156240136415652';
        //return $tradeNo;
        $dingdanid=input('dingdanid');
        $dingdanids=base64_decode(base64_decode($dingdanid));
        $chaxun=db('chaxun')->where('id','=',$dingdanids)->find();
       $bairo=db('bairo')->where('chaxunid','=',$chaxun['id'])->find();
         $tianyan_tonghua=$bairo['tianyan_tonghua'];
         $ress=str_replace("\\","",$tianyan_tonghua); 
         //$resss_1=substr($ress, 1, -1);
         $tianyan_tonghuas=json_decode($ress);
         if(isset($tianyan_tonghuas->success)){
            $su=$tianyan_tonghuas->success;
           if($su == true){
             return 1;
          }
           
         }
       // / return $dingdanids;
        $content="application/x-www-form-urlencoded";
        $headers=array(
              'token:'.$token,
              'content-type:'.$content
        );
       // $code_data['app_id']=$app_id;
        //$code_data['tradeNo']=$tradeNo;
        $url = 'https://b.shumaidata.com/api/v1/carrier/report/info';
        $tonghua_data['app_id']= 'YL9SiL2TeabDRAja';
         $tonghua_data['mobile']=$chaxun['tel'];//'13437155623';
         $tonghua_data['idcard']=$chaxun['idcard'];//'421126199512026319 ';
         $tonghua_data['name']=$chaxun['names'];//'王升';
       // $tonghua_data['month']='2019-01';
        $tonghua_data['orderNo']=$tradeNo;//'201902170931188508454214';
        $res = $this->Get($tonghua_data,$headers,$url);
        //插入通话记录
         $bairo_data['tianyan_tonghua']=$res;
        $bairo_id=db('bairo')->where('chaxunid','=',$chaxun['id'])->update($bairo_data);
        $data['tianyan_tonghua']=$res;
         $ress=str_replace("\\","",$res); 
         //$resss_1=substr($ress, 1, -1);
         $gr1=json_decode($ress);
         //dump($gr1);die;
        $value=$gr1->success;
       // return $value;
        if($value == false){
          return 3;
        }
        if($value == true){
          return 1;
        }else{
          return 0;
        }
        //插入通话数据  
        //$chaxun_id=db('bairo')->where('chaxunid','=',$chaxun['id'])->update($data);
        // if($bairo_id){
        //   return 1;
        // }else{
        //    return 0;
        // }
        // $gr1=json_decode($res);
        // dump($headers);dump($url);dump($tonghua_data);
        // dump(json_decode($gr1));die;
    }
    //.查询通话
     function tonghua(){
        header("content-type:text/html;charset=utf8");
        $token=input('token');
        //$token='90cc208298a8e26754fc18c4e69902985c6cb9f70cf234aacce2dc32';
        $tradeNo=input('tradeNo');
        //$tradeNo='201902201022478348703004';
        //return $tradeNo;
        $dingdanid=input('dingdanid');
        $dingdanids=base64_decode(base64_decode($dingdanid));
        $chaxun=db('chaxun')->where('sid','=',$dingdanids)->find();
       $bairo=db('bairo')->where('chaxunid','=',$chaxun['id'])->find();
         $tianyan_tonghua=$bairo['tianyan_tonghua'];
         $ress=str_replace("\\","",$tianyan_tonghua); 
         //$resss_1=substr($ress, 1, -1);
         $tianyan_tonghuas=json_decode($ress);
         if(isset($tianyan_tonghuas->success)){
            $su=$tianyan_tonghuas->success;
           if($su == true){
             return 1;
          }
           
         }
       // / return $dingdanids;
        $content="application/x-www-form-urlencoded";
        $headers=array(
              'token:'.$token,
              'content-type:'.$content
        );
       // $code_data['app_id']=$app_id;
        //$code_data['tradeNo']=$tradeNo;
        $url = 'https://b.shumaidata.com/api/v1/carrier/report/info';
        $tonghua_data['app_id']= 'YL9SiL2TeabDRAja';
         $tonghua_data['mobile']=$chaxun['tel'];//'13437155623';
         $tonghua_data['idcard']=$chaxun['idcard'];//'421126199512026319 ';
         $tonghua_data['name']=$chaxun['names'];//'王升';
       // $tonghua_data['month']='2019-01';
        $tonghua_data['orderNo']=$tradeNo;//'201902170931188508454214';
        $res = $this->Get($tonghua_data,$headers,$url);
        //插入通话记录
         $bairo_data['tianyan_tonghua']=$res;
        $bairo_id=db('bairo')->where('chaxunid','=',$chaxun['id'])->update($bairo_data);
        $data['tianyan_tonghua']=$res;
         $ress=str_replace("\\","",$res); 
         //$resss_1=substr($ress, 1, -1);
         $gr1=json_decode($ress);
         //dump($gr1);die;
        $value=$gr1->success;
       // return $value;
        if($value == false){
          return 3;
        }
        if($value == true){
          return 1;
        }else{
          return 0;
        }
        //插入通话数据  
        //$chaxun_id=db('bairo')->where('chaxunid','=',$chaxun['id'])->update($data);
        // if($bairo_id){
        //   return 1;
        // }else{
        //    return 0;
        // }
        // $gr1=json_decode($res);
        // dump($headers);dump($url);dump($tonghua_data);
        // dump(json_decode($gr1));die;
    }
     //得到token
       public function token()
    {
        header("content-type:text/html;charset=utf8");

         $appid="YL9SiL2TeabDRAja";
         $appSecurity="YL9SiL2TeabDRAja0LV1XQdzUrg9Nolw";
         $timestamp=time();
         //app_id={app_id}&app_security={app_security}&timestamp={tim estamp} 进行 md5 加密计算即可得到 sign 签名。 
         $one='app_id='.$appid.'&app_security='.$appSecurity.'&timestamp='.$timestamp;
        // $token=session('token');
       // if(empty($token)){
        
         $sign=md5($one);
          $PostArry2 = array(
              "app_id" => $appid,
              "timestamp" => $timestamp,
              "sign" => $sign
              );
           $request1_url="https://b.shumaidata.com/api/authorize";
          $return1 = $this->Post($PostArry2, $request1_url);  //发送请求到服务器，并输出返回结果。
        $json=json_decode($return1,true);
        //dump($json);die;
          $token=$json['result']['token'];
          return $token;
    }
    //接收验证码
       public function yanzhengma($token,$account,$password,$idCard,$realName)
    {
        header("content-type:text/html;charset=utf8");
        $url = 'https://b.shumaidata.com/api/v1/carrier/task';
        $post_data['app_id']       = 'YL9SiL2TeabDRAja';
        $post_data['account']      = $account;//'13437155623';
        $post_data['password'] = $password;//'797735';
        $post_data['idCard']    = $idCard;//'421126199512026319';
        $post_data['realName']    =$realName;// '王升升';
        $post_data['notifyUrl']    = '';
        $content="application/x-www-form-urlencoded";
        $headers=array(
              'token:'.$token,
              'content-type:'.$content
        );
        
        $res = $this->request_post($headers,$url, $post_data);  
         $ress=str_replace("\\","",$res); 
         $gr1=json_decode($ress);
          
         $su=$gr1->success;
         //return $su;
         if($su  ==  true){
            $tradeNo=$gr1->data->tradeNo;
            return $tradeNo;
        }else{
            return 0;
        }
        // dump($headers);dump($url);dump($post_data);dump($res);dump($ress);dump($resss);dump($resss_1);dump($resss_1);
        // dump($gr1);die;
    }
    //.提交验证码
     function code(){
      $token=input('token');
      $tradeNo=input('tradeNo');
      $yanzhengma=input('yanzhengma');
     // return $yanzhengma;
        $content="application/x-www-form-urlencoded";
        $headers=array(
              'token:'.$token,
              'content-type:'.$content
        );
       // $code_data['app_id']=$app_id;
        //$code_data['tradeNo']=$tradeNo;
        $url = 'https://b.shumaidata.com/api/v1/carrier/submitCode';
        $code_data['app_id']= 'YL9SiL2TeabDRAja';
        $code_data['tradeNo']=$tradeNo;
        $code_data['code']=$yanzhengma;
        $res = $this->request_post($headers,$url, $code_data);   
         $ress=str_replace("\\","",$res); 
        //return  $ress;
         //$resss_1=substr($ress, 1, -1);
         $gr1=json_decode($ress);
       $su=$gr1->success;
       //return  $su;
        if($su  ==  true){
            $value=$gr1->data->value;
       
        	return  $value;
        }else{
            return 0;
        }
        
        // $gr1=json_decode($res);
        // dump($headers);dump($url);dump($code_data);
        // dump(json_decode($gr1));die;
    } 
    //信息填写
    public function query()
    {
      $price=input('price');
      //dump($price);die;
      $sid=input('pid');
      $pid=session('pid');
      $product=db('product')->where('id','=',$sid)->find();
      $goods=db('goods')->where('id','=',$product['a_g_id'])->find();
      if(empty($pid)){
        $pid=76;
      }
     // dump($goods);die;
       $this->assign('product',$product);
       $this->assign('goods',$goods);
        $this->assign('price',$price);
       $this->assign('sid',$sid);
      $this->assign('pid',$pid);
        return $this->fetch();
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
    function get_url($PostArry,$array,$url){

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
}