<?php
namespace app\index\controller;
use think\Controller;
use think\Db;
use think\Session;
use app\index\model\Admin;
use app\common\controller\SignatureHelper;
header("content-type:text/html;charset=utf8");
class Login extends Controller
{


     public function login()
    {      
      $jl=input('jl');
      $p_id=input('p_id');
      //dump($jl);die;
      
         $this->assign('jl',$jl);
         $this->assign('p_id',$p_id);
        return $this->fetch();
      }
     public function loginss()
    {      
     $p_id=input('p_id');
       $this->assign('p_id',$p_id);
        return $this->fetch();
      }
     public function daili()
    {      
         $qpid=input('pid');
      if(!empty($qpid)){
            session('pid',$qpid);
        }
       $this->assign('pid',$qpid);
        return $this->fetch();
    }
   public function zcdl()
    { 
    
    
        return $this->fetch();
    }
     public function duanxin()
    { 
    
    
        return $this->fetch();
    }
     public function weixin()
    { 
    
        $jl=input('jl');
      //dump($jl);die;
         $this->assign('jl',$jl);
        return $this->fetch();
    }

      public function editpd()
    { 
      return $this->fetch();
    }


      public function tuichu()
    { 
      $clientIp = $this->request->ip();
     
      Session::delete('name');
       Session::delete('uid');
      if(!session('name')){
            $this->redirect('index/index/index');
        }
    }



    public function zhuce()
    { 
      $qpid=input('pid');
      if(!empty($qpid)){
            session('pid',$qpid);
        }
       $this->assign('pid',$qpid);
       return $this->fetch();
  }
  public function protocol()
    { 
     
       return $this->fetch();
  }
  //查询结果
    public function view()
    {
      $dingdanids=input('dingdanids');
      //$dingdanids=base64_decode(base64_decode($dingdanid));
      //$dingdanids=8697;
      $session_uid=session('uid');
      $this->assign("session_uid", $session_uid);
      $chaxun=db('chaxun')->where('id','=',$dingdanids)->find();
      $this->assign("dingdanids", $dingdanids);
       $this->assign("chaxun", $chaxun);
       //年龄查询$idcards=substr($idca,0,4);421126199512026319
       $sex=substr($chaxun['idcard'],6,4);
       $kaishi=date('Y');
       $ningling=$kaishi-$sex;
       //性别
       $sexss=substr($chaxun['idcard'],16,1);
       $shuzi=array(1,3,5,7,9);
       if(in_array($sexss,$shuzi)){
          $ren='男';
       }else{
          $ren='女';
       }
       $this->assign("ren", $ren);
       $this->assign("ningling", $ningling);
       //dump($ren);die;
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
      //dump($all_user_geren_alllist);die;
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
  //查询结果
    public function viewss()
    {
      $dingdanids=input('dingdanids');
      $p_id=input('p_id');
      $this->assign("p_id", $p_id);
      //$dingdanids=base64_decode(base64_decode($dingdanid));
      //$dingdanids=8697;
      $session_uid=session('uid');
      $this->assign("session_uid", $session_uid);
      $chaxun=db('chaxun')->where('id','=',$dingdanids)->find();
      $this->assign("dingdanids", $dingdanids);
       $this->assign("chaxun", $chaxun);
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
      //dump($all_user_geren_alllist);die;
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
            $up_chaxun=db('chaxun')->where('id','=',$dingdanids)->update($sheng_city);
      }else{
            //查询查询人的信息
            $up_chaxun=db('user')->where("mobile","=",$chaxun['tel'])->find();
            $user_up['sheng']=$up_chaxun['province'];
            $user_up['shi']=$up_chaxun['city'];
            $up_chaxun=db('chaxun')->where('id','=',$dingdanids)->update($user_up);
      }
      $this->assign("duotou", $duotou);
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
      return $this->fetch('viewss');
    }
  public function pingfen($temp_res)
    {
        if(isset($temp_res['als_m12_id_bank_allnum']))
        {
              if(isset($temp_res['als_m12_id_nbank_allnum']))
              {
                  $max=$temp_res['als_m12_id_bank_allnum'] + $temp_res['als_m12_id_nbank_allnum'];
              }else
              {
                  $max=$temp_res['als_m12_id_bank_allnum'];
              }
        }else
        {
              if(isset($temp_res['als_m12_id_nbank_allnum']))
              {
                  $max=$temp_res['als_m12_id_nbank_allnum'];
              }else
              {
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
              }else
              {
                $fen=95;
              }
         return $fen;
    }
}
