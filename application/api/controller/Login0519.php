<?php
namespace app\api\controller;
use think\Controller;
use think\Db;
use think\Request;
use think\Session;
class Login extends Controller
{
       public function login()
    {
      $names=input('mid');
      $passwordss=input('password');
      $password=md5(sha1($passwordss));
      $user=db('user')->where('mid','=',$names)->whereOr('mobile','=',$names)->find();
     if($user)
     {
        if($user['password']==$password)
        {
            session('name',$user['names']);
            session('uid',$user['id']);
            $new_time=time();
            session('logintime',$new_time);
            $data=['status' => 'success','msg' => '登陆成功！','name' => $user['names'],'uid' => $user['id'],'logintime' => $new_time,'pid' =>  $user['pid']];
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

    }
//本地存储保存session
      public function index()
    {
      $session_uid=session('uid');
      if(db('user')->where('id','=',$session_uid)->find())
      {
          return 2;
      }else{
          $name=input('name');
          $uid=input('uid');
          $logintime=time();
          $pid=input('pid');
          session('name',$name);
          session('uid',$uid);
          session('logintime',$logintime);
          session('pid',$pid);
          return 1;
      }
      
    }
   //注册
     public function zhuce()
    { 
            //判断上级上级
           // $pid=session('pid');
            //dump($pid);die;
           // if(empty($pid))
           // {
            //  $pid=1;

              //dump(1);die;
           // }else
           // {
            //  $userpid=db('user')->where('id','=',$pid)->find();
              //dump(2);die;
            //  if(empty($userpid))
            //  {
            //     $pid=1;
            //  }
           // }
		   
              $data=input('post.');
			  $yaoqingma=$data['yaoqingma'];
			  $p_user=db('user')->where('mid','=',$yaoqingma)->find();
			  if($p_user){
			  $pid=$p_user['id'];
			  }else{
			  	 $data=['status' => 'error','msg' => '请填写正确的邀请码'];
                  return $data;
			  }
                if(empty($data['password']))
              {
                //return 5;//密码为空
                 $data=['status' => 'error','msg' => '密码不能为空'];
                  return $data;
              }
              //    
              if($data['code']!=session('code'))
              {
                //验证码错误
                //return 3;
                $data=['status' => 'error','msg' => '验证码错误'];
                return $data;
              }
              //判断手机号是否已经存在
              if(db('user')->where('mobile','=',$data['nimobile'])->find())
              {
                $data=['status' => 'error','msg' => '手机号已经注册过'];
                return $data;
              }
              //判断身份证是否注册过
              

            

            $max=db('user')->max("id");
            //dump($citys);die;
            $max++;
            $max+=10000;
            $new_mid="M00".$max;
          $user=[
            'names'=>$data['username'],
            'mid'=>$new_mid,
            'mobile'=>$data['nimobile'],
            'status'=>1,
            'create_time'=>time(),
            'pid'=>$pid,
            'type'=>0,
            'password'=>md5(sha1($data['password'])),
          
           ];

           //用户注册
          $bjimg_id=db('user')->insertGetId($user);
          //$us=db('user')->insert($user);
           if(!empty($bjimg_id))
           {
            
              //成功返回
              session('name',$user['names']);
              session('uid',$bjimg_id);
              $new_time=time();
              session('logintime',$new_time);
              $data=['status' => 'success','msg' => '注册成功！','name' => $user['names'],'uid' => $bjimg_id,'logintime' => $new_time,'pid' =>  $user['pid']];
              return $data;
           }else
           {
            //注册失败
             $data=['status' => 'error','msg' => '注册失败'];
                return $data;
           }
    }
    //注册
     public function fenxiang()
    { 
            //判断上级上级
            $pid=session('pid');
            //dump($pid);die;
            if(empty($pid))
            {
              $pid=1;

              //dump(1);die;
            }else
            {
              $userpid=db('user')->where('id','=',$pid)->find();
              //dump(2);die;
              if(empty($userpid))
              {
                 $pid=1;
              }
            }
              $data=input('post.');
                if(empty($data['password']))
              {
                //return 5;//密码为空
                 $data=['status' => 'error','msg' => '密码不能为空'];
                  return $data;
              }
              //    
              if($data['code']!=session('code'))
              {
                //验证码错误
                //return 3;
                $data=['status' => 'error','msg' => '验证码错误'];
                return $data;
              }
              //判断手机号是否已经存在
              if(db('user')->where('mobile','=',$data['nimobile'])->find())
              {
                $data=['status' => 'error','msg' => '手机号已经注册过'];
                return $data;
              }
              //判断身份证是否注册过
              

            

            $max=db('user')->max("id");
            //dump($citys);die;
            $max++;
            $max+=10000;
            $new_mid="M00".$max;
          $user=[
            'names'=>$data['username'],
            'mid'=>$new_mid,
            'mobile'=>$data['nimobile'],
            'status'=>1,
            'create_time'=>time(),
            'pid'=>$pid,
            'type'=>0,
            'password'=>md5(sha1($data['password'])),
          
           ];

           //用户注册
          $bjimg_id=db('user')->insertGetId($user);
          //$us=db('user')->insert($user);
           if(!empty($bjimg_id))
           {
            
              //成功返回
              session('name',$user['names']);
              session('uid',$bjimg_id);
              $new_time=time();
              session('logintime',$new_time);
              $data=['status' => 'success','msg' => '注册成功！','name' => $user['names'],'uid' => $bjimg_id,'logintime' => $new_time,'pid' =>  $user['pid']];
              return $data;
           }else
           {
            //注册失败
             $data=['status' => 'error','msg' => '注册失败'];
                return $data;
           }
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
        $password['password']=md5(sha1($data['password']));
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
