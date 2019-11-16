<?php
namespace app\api\controller;
use think\Config;
use think\Controller;
use think\Db;
use think\Request;
use think\Session;
class Login extends Controller
{
  //登陆
   public function login()
    {  
      $names=input('mid');
      $passwordss=input('password');
      $password=md5($passwordss.Config::get('salt'));
      $user=db('user')->where('mid','=',$names)->whereOr('mobile','=',$names)->find();
     if($user)
     {
        if($user['agent_class'] > 1)
        {
          	if($user['password']==$password)
          	{
                session('mid',$user['mid']);
                session('name',$user['names']);
                session('uid',$user['id']);
                $data=['status' => 'success','msg' => '登录成功！'];
                return $data;
              
             }else
            {
                $data=['status' => 'error','msg' => '密码错误！'];
                return $data;
            }
        }else
        {
                $data=['status' => 'error','msg' => '账号不存在！'];
                return $data;
        }
      
      }else
      {
       $data=['status' => 'error','msg' => '账号不存在！'];
       return $data;
      }

    }
   public function loginss()
    {
      $data=input('post.');
      if($data['code']!=session('code'))
       {
          //验证码错误
          //return 3;
          
          return 3;
        }
         if($data['mobile']!=session('mobile'))
       {
          //手机号不是发送短信的手机号
          //return 3;
          
          return 4;
        }
        $time=time();
        $codetime=session('codetime');
        $c_time=$time - $codetime;
       //    if($c_time > 120)
       // {
       //    //验证码错误
       //    //return 3;
          
       //    return 5;
       //  }
        $user=db('user')->where('mobile','=',$data['mobile'])->find();
        if($user){
           session('mid',$user['mid']);
                      session('name',$user['names']);
                      session('uid',$user['id']);
                   return 1;
        }else{
                   return 0;
               }

    }
       public function editpd()
    {
        $psd['id']=session('uid');
        $xposswordss=input('xpossword');
        $psd['password']=md5($xposswordss.Config::get('salt'));
        //$user=db('user')->where('id','=',$psd['id'])->find();
        //$user['password']=$psd['password'];
        if(db('user')->where('id','=',$psd['id'])->update($psd))
        {
          // $clientIp = $this->request->ip();
          // Session::delete('uid');
          // Session::delete('name');
          // Session::delete('mid');
          $data=['status' => "success",'msg' => "修改密码成功！"];
          return $data;
        }else{
          $data=['status' => "error","msg" => "修改密码错误！"];
          return $data;
        }  
    }
    public function zhuce()
    { 
      $pid=session('pid');
      if(empty($pid)){
        $pid=1;
      }

       

      $idca=input('idcard');
      $username=input('username');
      $mobile=input('mobile');
      $password=input('password');
      //$code=input('code');
       $usercard=db('user')->where('idcard','=',$idca)->find();
       $usermobile=db('user')->where('mobile','=',$mobile)->find();
      
       // if($code==session('code')){
          if($usercard){
             if($usercard['mobile'] == $mobile){
                    if($usercard['agent_class'] > 1){
                        return 3;
                    }else{
                       //判断上级是否规定下级等级
                      $s_user_s=db('user')
                        ->alias("u")
                        ->field("u.*,z.maid")
                        ->join("sun_agent a","a.id=u.agent_class","LEFT")
                        ->join("sun_agentzhuce z","z.paid=u.agent_class","LEFT")
                        ->where('u.id','=',$usercard['pid'])
                        ->find();
                     if($usercard['pid'] == $pid){
                            if(!empty($s_user_s['maid'])){
                              $agent_class_s=$s_user_s['maid'];
                            }else{
                              $agent_class_s=2;
                            }
                       }else{
                       		$u_data['pid']=$pid;
                          $agent_class_s=2;
                        }
                      $u_data['agent_class']=$agent_class_s;
                      $u_data['id']=$usercard['id'];
                      $u_data['password']=md5($password.Config::get('salt'));
                      $u_data['names']=$username;
                      if(db('user')->where('id','=',$usercard['id'])->update($u_data)){
                        session('mid',$usercard['mid']);
                        session('name',$usercard['names']);
                        session('uid',$usercard['id']);
                        return 1;
                      }
                    }
              }else{
                return 3;
              }
            }else{
            if($usermobile){
              if($usermobile['mobile'] == $mobile){
                    if($usermobile['agent_class'] > 1){
                        return 4;
                    }else{
                       //判断上级是否规定下级等级
                      $s_user_ss=db('user')
                        ->alias("u")
                        ->field("u.*,z.maid")
                        ->join("sun_agent a","a.id=u.agent_class","LEFT")
                        ->join("sun_agentzhuce z","z.paid=u.agent_class","LEFT")
                        ->where('u.id','=',$usermobile['pid'])
                        ->find();
                   if($usermobile['pid'] == $pid){
                        if(!empty($s_user_ss['maid'])){
                          $agent_class_ss=$s_user_ss['maid'];
                        }else{
                          $agent_class_ss=2;
                        }
                    }else{
                       		$um_data['pid']=$pid;
                          $agent_class_ss=2;
                        }
                      $um_data['agent_class']=$agent_class_ss;
                      $um_data['id']=$usermobile['id'];
                      $um_data['password']=md5($password.Config::get('salt'));
                      $um_data['names']=$username;
                      if(db('user')->where('id','=',$usermobile['id'])->update($um_data)){
                        session('mid',$usermobile['mid']);
                        session('name',$usermobile['names']);
                        session('uid',$usermobile['id']);
                        return 1;
                      }
                    }
              }else{
                return 4;
              }
            }else{  
               $idcard=substr($idca,0,2);
           
                $city=db('city')->where('citynumber','=',$idcard)->find();
                if(empty($city['city_name'])){
                    $city['city_name']="";
                    $citys['city_name']="";
                }else{
                      $idcards=substr($idca,0,4);
                      $citys=db('city')->where('citynumber','=',$idcards)->find();
                      if(empty($citys['city_name']))
                      {
                        $citys['city_name']="";
                      }
                }
              
              $max=db('user')->max("id");
              $max++;
              $max+=10000;
              $new_mid="M00".$max;
              //判断上级是否规定下级等级
              $s_user=db('user')
                ->alias("u")
                ->field("u.*,z.maid")
                ->join("sun_agent a","a.id=u.agent_class","LEFT")
                ->join("sun_agentzhuce z","z.paid=u.agent_class","LEFT")
                ->where('u.id','=',$pid)
                ->find();
                if(!empty($s_user['maid'])){
                  $agent_class=$s_user['maid'];
                }else{
                  $agent_class=2;
                }
              $user=[
                'names'=>$username,
                'mid'=>$new_mid,
                'idcard'=>$idca,
                'mobile'=>$mobile,
                'status'=>1,
                'create_time'=>time(),
                'province'=>$city['city_name'],
                'city'=>$citys['city_name'],
                'agent_class'=>$agent_class,
                'pid'=>$pid,
                'password'=>md5($password.Config::get('salt'))
              ];
               //return 5;
              //return $agent_class;
             //return  $user['pid'];
              $bjimg_id=db('user')->insertGetId($user);
               //return 4;
              if(!empty($bjimg_id)){
                  session('mid',$user['mid']);
                      session('name',$user['names']);
                      session('uid',$bjimg_id);
                   return 1;

               }else{
                   return 0;
               }
              }
              }
         //    }else{
         //           return 2;
         // }
      }
    public function duanxin()
    {
      $data=input('post.');
      if($data['code']!=session('code'))
       {
          //验证码错误
          //return 3;
          
          return 3;
        }
         if($data['mobile']!=session('mobile'))
       {
          //手机号不是发送短信的手机号
          //return 3;
          
          return 4;
        }
        $time=time();
        $codetime=session('codetime');
        $c_time=$time - $codetime;
          if($c_time > 120)
       {
          //验证码错误
          //return 3;
          
          return 5;
        }
        $user=db('user')->where('mobile','=',$data['mobile'])->find();
        $password['password']=md5($data['password'].Config::get('salt'));
        $password['id']=$user['id'];
        if(db('user')->where('id','=',$user['id'])->update($password)){
           session('mid',$user['mid']);
                      session('name',$user['names']);
                      session('uid',$user['id']);
                   return 1;
        }else{
                   return 1;
               }

    }
      

}
