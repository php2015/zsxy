<?php
namespace app\api\controller;
use think\Controller;
use think\Db;
use app\index\controller\Insurance;
use think\Request;
use think\Session;
class Chaxun extends Controller
{
  public function zhucechaxun()
    { 
      $pid=session('ppp_id');
      if(empty($pid)){
     		$pid=76;
      }
      $idca=input('idcard');
      $username=input('username');
      $mobile=input('mobile');
      $password=input('password');
      $bank = input('bank');
      $usermobile=db('user')->where('mobile','=',$mobile)->find();
      $kaishi=date('Y-m-d 00:00');
      $kaishitime=strtotime($kaishi);
      $jieshu=date('Y-m-d 23:59');
      $jieshutime=strtotime($jieshu);
      $usernum = db('chaxun')->where('tel','=',$mobile)->where('dates','between',[$kaishitime, $jieshutime])->select();
      $idcard = db('chaxun')->where('idcard','=',$idca)->where('dates','between',[$kaishitime, $jieshutime])->select();
      $num=count($usernum);
      $idcard_total =count($idcard);
      if($num > 5){
        return 11;
      }
      if($idcard_total > 5){
          return 12;
      }
            if(!empty($usermobile)){
            	$data['id']=$usermobile['id'];
            	$data['idcard']=$idca;
            	if(isset($bank) && !empty($bank)){
            		$banks = $this->luhm($bank);
            		if($banks){
            			$data['banknumber'] = $bank;
            		}else{
            			return 100;
            		}
            	}
            	$update=db('user')->where("id","=",$data['id'])->update($data);
            	session('mid',$usermobile['mid']);
                      session('name',$usermobile['names']);
                      session('uid',$usermobile['id']);
            	return $usermobile['id'];
            }else{  
               $idcard=substr($idca,0,2);
           
                $city=db('city')->where('citynumber','=',$idcard)->find();
                if(empty($city['city_name'])){
                    $city['city_name']="";
                    $citys['city_name']="";
                }else{
                      $idcards=substr($idca,0,4);
                      $citys=db('city')->where('citynumber','=',$idcards)->find();
                      if(empty($citys['city_name'])){
                        $city['city_name']="";
                        $citys['city_name']="";
                      }
                }
              
              $max=db('user')->max("id");
              $max++;
              $max+=10000;
              $new_mid="M00".$max;

              $user=[
                'names'=>$username,
                'mid'=>$new_mid,
                'idcard'=>$idca,
                'mobile'=>$mobile,
                'status'=>1,
                'create_time'=>time(),
                'province'=>$city['city_name'],
                'city'=>$citys['city_name'],
                'pid'=>$pid,
                'password'=>md5($password),
                'banknumber' => isset($bank) && !empty($bank) ? $bank : '',
              ];
              $bjimg_id=db('user')->insertGetId($user);
              if(!empty($bjimg_id)){
                  session('mid',$user['mid']);
                      session('name',$user['names']);
                      session('uid',$bjimg_id);
                   return $bjimg_id;
               }else{
                   return 0;
               }
              }
      }
      
      
	public function luhm($s){
		$n = 0;
		$ns = strrev($s); // 倒序
		for ($i=0; $i <strlen($s) ; $i++) { 
		if ($i % 2 ==0) {
				$n += $ns[$i]; // 偶数位，包含校验码
		}else{
				$t = $ns[$i] * 2;
			if ($t >=10) {
				$t = $t - 9;
			}
				$n += $t;
			}
		}
		return ( $n % 10 ) == 0;
	}
	
      
      
      
      public function zhucechaxuns()
    { 
      $pid=session('ppp_id');
      if(empty($pid)){
     		$pid=76;
      }
      $idca=input('idcard');
      $username=input('username');
      $mobile=input('mobile');
      $insurance=input('insurance');
      $password=input('password');
      
       $usermobile=db('user')->where('mobile','=',$mobile)->find();
       $kaishi=date('Y-m-d 00:00');
      $kaishitime=strtotime($kaishi);
      $jieshu=date('Y-m-d 23:59');
      $jieshutime=strtotime($jieshu);
      $usernum = db('chaxun')->where('tel','=',$mobile)->where('dates','between',[$kaishitime, $jieshutime])->select();
      $idcard = db('chaxun')->where('idcard','=',$idca)->where('dates','between',[$kaishitime, $jieshutime])->select();
      $num=count($usernum);
      $idcard_total =count($idcard);
      if($num > 5){
        return 11;
      }
      if($idcard_total > 5){
          return 12;
      }
       // if($code==session('code')){
         // if($usercard){
           //   return $usercard['id'];
           // }else{
            if(!empty($usermobile)){
              $data['id']=$usermobile['id'];
              //$data['names']= $usermobile['names'];
             // $data['mobile']= $usermobile['mobile'];
              $data['idcard']=$idca;
               $update=db('user')->where("id","=",$data['id'])->update($data);
               session('mid',$usermobile['mid']);
                      session('name',$usermobile['names']);
                      session('uid',$usermobile['id']);
              return $usermobile['id'];
            }else{  
               $idcard=substr($idca,0,2);
           
                $city=db('city')->where('citynumber','=',$idcard)->find();
                if(empty($city['city_name'])){
                    $city['city_name']="";
                    $citys['city_name']="";
                }else{
                      $idcards=substr($idca,0,4);
                      $citys=db('city')->where('citynumber','=',$idcards)->find();
                      if(empty($citys['city_name'])){
                        $city['city_name']="";
                        $citys['city_name']="";
                      }
                }
              
              $max=db('user')->max("id");
              $max++;
              $max+=10000;
              $new_mid="M00".$max;

              $user=[
                'names'=>$username,
                'mid'=>$new_mid,
                'idcard'=>$idca,
                'mobile'=>$mobile,
                'status'=>1,
                'create_time'=>time(),
                'province'=>$city['city_name'],
                'city'=>$citys['city_name'],
                'pid'=>$pid,
                'password'=>md5($password)
              ];
               //return 5;
              
             //return  $user['pid'];
              $bjimg_id=db('user')->insertGetId($user);
              #var_dump($bjimg_id);exit;
               //return 4;
              if(!empty($bjimg_id)){
                  session('mid',$user['mid']);
                      session('name',$user['names']);
                      session('uid',$bjimg_id);
                   return $bjimg_id;
               }else{
                   return 0;
               }
              }
              //}
         //    }else{
         //           return 2;
         // }
      }
    
}
