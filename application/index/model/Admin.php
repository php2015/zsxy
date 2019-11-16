<?php
namespace app\index\model;
use think\Model;
use think\Db;
class Admin extends Model
{
    public function login($data){
        // $captcha = new \think\captcha\Captcha();
        // if(!$captcha->check($data['code'])){
        //     return 4;
        // }
        $user=db('user')->where('mid','=',$data['username'])->whereOr('mobile','=',$data['username'])->find();
        if($user){
            if($user['password']==md5($data['password'])){
                session('name',$user['names']);
                session('uid',$user['id']);
                session('logintime',time());
                return 3;
                 
            }else{
                return 2;
            }

        }else{
            return 1;
        }
        
    }
    
}
