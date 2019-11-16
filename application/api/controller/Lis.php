<?php
namespace app\api\controller;
use think\Controller;
use think\Db;
use think\Request;

class Lis extends Controller
{
  
   public function lis()
    {  
      $startPage=input('startPage');
      $length=input('length');
       $id=session('uid');
        $user=db('sun_profit')->where('profit_id','=',$id)->order('id desc')->limit($startPage*$length,$length)->select();
        $arr=array();
        $data=array();
        
        foreach ($user as $key => $value) {

          $arr['create_time']=date("Y-m-d H:i:s",$value['create_time']);
          $arr['money']=$value['money'];
          $arr['type']=$value['type'];
          $arr['balance']=$value['balance'];
          $data[]=$arr;
         
        }
       
        return $data;
      }
      

}
