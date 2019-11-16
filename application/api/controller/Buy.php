<?php
namespace app\api\controller;
use think\Controller;
use think\Db;
use think\Request;
use think\Session;
class Buy extends Controller
{
  //$pid 商品id
  //$price 商品价格
  public function buy()
    {
     $id=session('uid');
     $user=db('user')->where('id','=',$id)->find();
     if(!empty($id)){
        return 1;
          /** $pid=input('pid');
           $price=input('price');
           $time=time();
           $ordernumber="D".$id.$time;
           $data=[
                  'ordernumber'=>$ordernumber,
                  'uid'=>$id,
                  'dates'=>$time,
                  'remarks'=>0,
                  'pid'=>$pid,
                  'price'=>$price
                 ];
          $chaxunid=db('chaxun')->insertGetId($data);
          if(!empty($chaxunid)){
              $useryiji=db('user')
              ->alias('u')
              ->join('sun_agent a','u.agent_class=a.id')
              ->field('u.*,a.ratio1')
              ->where('u.id','=',$user['pid'])->find();
              $balance=$useryiji['money']+$price*$useryiji['ratio1'];

              if($useryiji){
                $datayiji=[
                  'order_id'=>$ordernumber,
                  'profit_id'=>$useryiji['id'],
                  'ratio'=>$useryiji['ratio1'],
                  'create_time'=>$time,
                  'money'=>$price*$useryiji['ratio1'],
                  'type'=>"一级奖励",
                  'balance'=>$balance
                              ];
               
                $chaxun_ids=db('profit')->insertGetId($datayiji);
                if(!empty($chaxun_ids)){
                  $moneyyi['money']=$balance;

                  $updateuser=db('user')->where("id","=",$useryiji['id'])->update($moneyyi);
                  
                  if($updateuser){
                    $usererji=db('user')
                    ->alias('u')
                    ->join('sun_agent a','u.agent_class=a.id')
                    ->field('u.*,a.ratio2')
                    ->where('u.id','=',$useryiji['pid'])->find();
                    $balances=$useryiji['money']+$price*$usererji['ratio2'];
                    if($usererji){
                      $dataerji=[
                        'order_id'=>$ordernumber,
                        'profit_id'=>$usererji['id'],
                        'ratio'=>$usererji['ratio2'],
                        'create_time'=>$time,
                        'money'=>$price*$usererji['ratio2'],
                        'type'=>"二级奖励",
                        'balance'=>$balances
                                    ];
                     
                      $chaxuner=db('profit')->insertGetId($dataerji);
                      if(!empty($chaxuner)){
                        $moneyer['money']=$balance;

                        $updateuserer=db('user')->where("id","=",$usererji['id'])->update($moneyer);
                      }
                    return 1;
                    }
                  }
                }
              }
              
          }else{
              return 0;
          }**/
       }else{
       return 11;
    }
  }
}
