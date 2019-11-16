<?php
namespace app\api\controller;
use think\Controller;
use think\Db;
use think\Request;

class Index extends Controller
{
  
    public function weixin()
    { 
    
    
        return $this->fetch();
    }
     
        //收款方式
    public function userskfs()
    { 
          
            $id=session('uid');
            //$user=db('user')->where('id','=',$id)->where('status','=','1')->find();
            $user['banktype']=input('banktype');
            $user['banknumber']=input('banknumber');
            $user['banknames']=input('bankname');
            if(db('user')->where('id','=',$id)->update($user)){
                return 1;
            }else{
                return 0;
            }  
          
        
      } 
   //提现
     public function usertx()
    { 
          $id=session('uid');
          //查询提现人信息
          $user=db('user')->where('id','=',$id)->where('status','=','1')->find();
          //判断是否绑定收款账号
          if(empty($user['banknumber'])){
            return 5;
          }
          //查询是否有正在审核的订单
          $sta=db('withdraw')->where('user_id','=',$id)->where('status','=','0')->find();
          $array_id=input('array_id');
          //订单状态修改
          if(!$sta){
            $data=[
              'user_id'=>$id,
              'money'=>input('account'),
              'type'=>$user['banktype'],
              'bankcard'=>$user['banknumber'],
              'create_time'=>time(),
              'operator'=>'1',
              'banknames'=>$user['banknames'],
              'pids'=>$array_id
            ];
              //提现的钱必须小于余额
              if($user['money']>=$data['money']){
                //提现表插入
                 if(db('withdraw')->insert($data))
                 {
                    
                      $array = explode(",",$array_id);
                      $num=count($array);
                      //订单表状态修改为1 
                      for($i=0;$i<$num;$i++){
                        $sun_profit['state']=1;
                        $sun_profit['id']=$array[$i];
                        db('profit')->update($sun_profit);
                      }
                      return 1;
                  }else{
                      return 0;
                  } 
              //余额为0提示
              }elseif($user['money']==0){
                return 2;
              }else{
                return 3;
              }
          }else{
              return 4;
            } 
      }
}
