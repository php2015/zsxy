<?php
namespace app\api\controller;
use think\Controller;
use think\Db;
use think\Request;

class Register extends Controller
{
   
      public function register()
    {  
     
      $user=[
            'names'=>input('names'),
            'password'=>md5(input('password')),
        ];
        // $data['names']=input('names');
        // //$data=['status' => 'success','msg' => '登陆成功！'];
        // return $data;
      
        $validate= \think\loader::validate('Admin');
        if(!$validate->check($user)){
            $this->error($validate->getError());
            die;
        }
        
         if(Db::name('sun_user')->insert($user)){
            $data=['status' => 'success','msg' => '登陆成功！'];
            return $data;
        }else{
            $data=['status' => 'error','msg' => '用户名或者密码错误！'];
                return $data;
        }
       
    }
      

}
