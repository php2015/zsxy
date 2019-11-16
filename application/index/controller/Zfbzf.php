<?php
namespace app\index\controller;
use think\Controller;
use think\Db;
use think\Request;
use AlipayTradeWap\AlipayTradeWapPayContentBuilder;
include EXTEND_PATH . 'alipay/pay/service/AlipayWapPayTradeService.php';
include EXTEND_PATH . 'alipay/pay/buildermodel/AlipayTradeWapPayContentBuilder.php';
include EXTEND_PATH . 'alipay/pay/buildermodel/AlipayTradeQueryContentBuilder.php';
include EXTEND_PATH . 'alipay/pay/service/AlipayTradeService.php';
error_reporting(0);
class Index extends Controller
{
  public function _initialize(){
        if(!session('name')){
           // $this->error('请先登录系统！','index/login/login');
          $this->redirect('index/login/login');
        }
    }


 public function pay($resall){
        // 2.构造参数
        
        $payRequestBuilder = new AlipayTradeWapPayContentBuilder();
        $payRequestBuilder->setSubject($resall['name']);
        $payRequestBuilder->setOutTradeNo($resall['orderid']);
        $payRequestBuilder->setTotalAmount($resall['money']);
        $payRequestBuilder->setTimeExpress('1m');
        // 3.获取配置
        $config = config('queue');
        //dump($config);die;
        $payResponse = new \AlipayWapPayTradeService($config);
        //4.进行请求
        $result=$payResponse->wapPay($payRequestBuilder,$config['return_url'],$config['notify_url']);
        dump($result);die;
        return $result;
        

    }
public function query(){

  // 1.设置请求参数
        $RequestBuilder = new \AlipayTradeQueryContentBuilder();
        $RequestBuilder->setTradeNo(trim('2018072121001004150579004970'));

        // 2.获取配置
        $config = config('queue');
        $aop    = new \AlipayTradeService($config);

        // 3.发起请求
        $response = $aop->Query($RequestBuilder);

        // 4.转为数组格式返回
        $response = json_decode(json_encode($response), true);

     

        return json($response);
}



  public function huiyuan()
    {
     $id=session('uid');
     $user=db('sun_user')->where('id','=',$id)->find();
       $out_trade_no=input('out_trade_no');
        $ord_id=substr($out_trade_no,10);
        //dump($ord_id);die;
        $get_order=db('sun_order')->where('id','=',$ord_id)->where('status','=',0)->find();
        //dump($get_order);die;
         if($get_order)
         {
                    if($get_order['operator']==$id){
                      $get_order['status']=1;
                      $up_order=db('sun_order')->update($get_order);
                       
                           //更改用户状态和等级
                          $user['status']=1;
                          $user['agent_class']=$get_order['product_id'];
                          $zf=db('sun_user')->update($user);
                          //开始计算提成
                          $this->buy($get_order,$ord_id);
                      // if($zf){
                      //     $this->redirect('index/index/huiyuan');
                      //   }
                    }
          }
      if(request()->isPost())
      {

          $hid=input('hid');
          $user=db('sun_user')->where('id','=',$id)->find();
          $da=db('sun_product')->where('id','=',$hid)->find();
          
          //dump($da);die;
          if($da)//判断支付
          {
            
              //插入一条订单ID
              $order=[
                  'user_id'=>$id,
                  'product_id'=>$da['id'],
                  'create_time'=>time(),
                  'status'=>0,
                  'operator'=>$id,
                  'price'=>$da['price'],
                  'reality_price'=>$da['price'],
                  'arrears'=>0,
                  'master_id'=>$id,
              ];
              $res=db('sun_order')->insert($order);

              if($res){
              $order_id=db('sun_order')->getLastInsID();
              //dump($order_id);die;
              $resall=[
                  'name'=>$da['product_name'],
                  'orderid'=>time().$order_id,
                  'money'=>0.01,
              ];

              $result=$this->pay($resall);
            }
            }


              // //开始计算提成
              // //$this->buy($order,$order_id);
              //  //更改用户状态和等级
              // $user['status']=1;
              // $user['agent_class']=$hid;
              // $zf=db('sun_user')->update($user);
       //        if($zf)
       //        {
       // //          $result=$this->pay();
       // // return "$result";
       //            //return $this->success('处理成功','index/index/user');
       //        }else
       //        {
       //            //退款
       //            return $this->error(' 处理失败');
       //        }
          }
          
        
      
      
      $da=db('sun_product')->where('id','=',$user['agent_class'])->find();
      $this->assign('user',$da);
      $this->assign('data',$user);
      //dump($user);die;
        return $this->fetch();
      
      
    }










    //处理分成流程
  private function buy($data,$order_id){
    $user_info=Db::name("sun_user")->where(array("id"=>$data["user_id"]))->find();
    if ($user_info["pid"]){
      $up_user_info=Db::name("sun_user")->where(array("id"=>$user_info["pid"]))->find();
      $up_user_agent=Db::name("sun_agent")->where(array("id"=>$up_user_info["agent_class"]))->find();
      if ($up_user_agent){
        //更新上级提成
        $up_user_money=$data["reality_price"]*$up_user_agent["ratio1"];
        $save=array();
        $save["order_id"]=$order_id;
        $save["profit_id"]=$up_user_info["id"];
        $save["ratio"]=$up_user_agent["ratio1"];
        $save["create_time"]=time();
        $save["money"]=$up_user_money;
        $save["balance"]=$up_user_info["money"]+$up_user_money;
        $save["type"]="一级奖励";
        $save["cid"]="1";
        if($up_user_money>0)
        {
        Db::name("sun_profit")->insert($save);
        }
        $save=array();
        $save["money"]=$up_user_info["money"]+$up_user_money;
        Db::name("sun_user")->where(array("id"=>$up_user_info["id"]))->update($save);
        unset($save);
      }
      if ($up_user_info["pid"]){
        $second_user_info=Db::name("sun_user")->where(array("id"=>$up_user_info["pid"]))->find();
        $second_user_agent=Db::name("sun_agent")->where(array("id"=>$second_user_info["agent_class"]))->find();
        if ($second_user_agent){
          //更新二级上级提成
          $second_user_money=$data["reality_price"]*$second_user_agent["ratio2"];
          $save=array();
          $save["order_id"]=$order_id;
          $save["profit_id"]=$second_user_info["id"];
          $save["ratio"]=$second_user_agent["ratio2"];
          $save["create_time"]=time();
          $save["money"]=$second_user_money;
          $save["balance"]=$second_user_info["money"]+$second_user_money;
          $save["type"]="二级奖励";
          $save["cid"]="1";
          if($up_user_money>0)
          {
          Db::name("sun_profit")->insert($save);
          }
          $save=array();
          $save["money"]=$second_user_info["money"]+$second_user_money;
          Db::name("sun_user")->where(array("id"=>$second_user_info["id"]))->update($save);
          unset($save);
        }
      }
      //团队奖励开始
      $this->team($order_id,$data["price"],$data["reality_price"],$up_user_info["id"],0,0,0,0);
      $this->success('成功');
    }
  }
 

  
  //团队奖励
  /*
  *order_id             订单ID
  *price              业绩金额
  *real_price           实收金额
  *parent_id            上级ID
  *is_level             平级奖励是否占用
  *is_up              封顶奖励是否占用
  *front_ratio          前一级比率
  *front_total_achievement    前一级总业绩
  */
  private function team($order_id,$price,$real_price,$parent_id,$is_level,$is_up,$front_ratio,$front_total_achievement){
    //提取用户信息
    $user_info=Db::name("sun_user")->where(array("id"=>$parent_id))->find();
    //取小于DESC 10的用户参与分成
    $user_agent=Db::name("sun_agent")->where(array("id"=>$user_info["agent_class"],"rank"=>array("lt",10)))->find();
    if ($user_agent){
      //判断当前用户层级
      if ($user_info["total_achievement"]>50000000){
        $team_ratio="team_ratio6";
      }elseif($user_info["total_achievement"]>24000000){
        $team_ratio="team_ratio5";
      }elseif($user_info["total_achievement"]>12000000){
        $team_ratio="team_ratio4";
      }elseif($user_info["total_achievement"]>6000000){
        $team_ratio="team_ratio3";
      }elseif($user_info["total_achievement"]>2000000){
        $team_ratio="team_ratio2";
      }else{
        $team_ratio="team_ratio1";
      }
      //获取当前分成比率
      $user_ratio=$user_agent[$team_ratio];
      if ($user_ratio>$front_ratio){
        //进行分成
        $current_ratio=$user_ratio-$front_ratio;
        $addition_money=$real_price*$current_ratio;
        $data=array();
        $data["order_id"]=$order_id;
        $data["profit_id"]=$parent_id;
        $data["ratio"]=$current_ratio;
        $data["create_time"]=time();
        $data["money"]=$addition_money;
        $data["type"]="团队奖励";
        $data["cid"]=1;
        $data["balance"]=$user_info["money"]+$addition_money;
        if($addition_money>0)
        {
          Db::name("sun_profit")->insert($data);
        }
        $save=array();
        $save["money"]=$user_info["money"]+$addition_money;
        Db::name("sun_user")->where(array("id"=>$user_info["id"]))->update($save);
        //更新参数
        $front_ratio=$user_ratio;
      }else{
        //是否平级奖
        if (!$is_level){
          //得3%平级奖
          $current_ratio=0.03;
          $addition_money=$real_price*$current_ratio;
          $data=array();
          $data["order_id"]=$order_id;
          $data["profit_id"]=$parent_id;
          $data["ratio"]=$current_ratio;
          $data["create_time"]=time();
          $data["money"]=$addition_money;
          $data["type"]="团队奖励-首次平级";
          $data["cid"]=1;
          $data["balance"]=$user_info["money"]+$addition_money;
          if($addition_money>0)
          {
            Db::name("sun_profit")->insert($data);
          }
          $save=array();
          $save["money"]=$user_info["money"]+$addition_money;
          Db::name("sun_user")->where(array("id"=>$user_info["id"]))->update($save);
          //更新参数
          $is_level=1;
        }else{
          //平级奖与顶级奖不可兼得
          //是否顶级奖
          if ($team_ratio=="team_ratio6"){
            if (!$is_up){
              if (($user["total_achievement"]-$front_total_achievement)>20000000){
                //得4%顶级奖
                $current_ratio=0.04;
                $addition_money=$real_price*$current_ratio;
                $data=array();
                $data["order_id"]=$order_id;
                $data["profit_id"]=$parent_id;
                $data["ratio"]=$current_ratio;
                $data["create_time"]=time();
                $data["money"]=$addition_money;
                $data["type"]="团队奖励-首次顶级";
                $data["cid"]=1;
                $data["balance"]=$user_info["money"]+$addition_money;
                if($addition_money>0)
                {
                Db::name("sun_profit")->insert($data);
                }
                $save=array();
                $save["money"]=$user_info["money"]+$addition_money;
                Db::name("sun_user")->where(array("id"=>$user_info["id"]))->update($save);
                //更新参数
                $is_up=1;
              }
            }
          }
        }
      }
    }
    //进行业绩统计
    $front_total_achievement=$user_info["total_achievement"];
    $save=array();
    $save["total_achievement"]=$user_info["total_achievement"]+$price;
    Db::name("sun_user")->where(array("id"=>$user_info["id"]))->update($save);
    if ($user_info["pid"]){
      //下一次循环
      $this->team($order_id,$price,$real_price,$user_info["pid"],$is_level,$is_up,$front_ratio,$front_total_achievement);
    }
    
  }



























    public function erweima()
    {

      return $this->fetch();
    }
    




   
   public function baodan()
    { 
       if(request()->isPost()){
        $pid=session('uid');
        $pname=session('name');
        $data=input('post.');
        $idcard=substr($data['idcard'],0,2);
        $city=db('sun_city')->where('citynumber','=',$idcard)->find();
        if(!$city){
          $city['id']=1;
        }
        $idcards=substr($data['idcard'],0,4);
        $citys=db('sun_city')->where('citynumber','=',$idcards)->find();
        if(!$citys){
          $citys['id']=2;
        }
        $max=db('sun_user')->max("id");
        $max++;
      $max+=10000;
    $new_mid="M00".$max;
        $user=[
          'names'=>$data['username'],
          'mid'=>$new_mid,
          'idcard'=>$data['idcard'],
          'mobile'=>$data['phone'],
          'status'=>0,
          'create_time'=>date('Y-m-d H:i:s',time()),
          'province'=>$city['id'],
          'city'=>$citys['id'],
          'pid'=>$pid,
          'pnames'=>$pname,
          'money'=>0,
          'agent_class'=>8,
          'operator'=>0,
          'type'=>0,
          'master_id'=>0,
          //'note'=>$data['note'],
          'password'=>md5(sha1('123456')),
          'total_achievement'=>0,
        ];
        //dump($user);die;
        $validate= \think\loader::validate('Userinsert');
        if(!$validate->scene('insert')->check($user)){
            $this->error($validate->getError());
            die;
        }
        //dump($user);die;
        $us=db('sun_user')->insert($user);;
     if($us){
             return $this->success('提交成功，默认为123456，请登录后修改密码','index/index/user');
         }else{
             return $this->error('提交失败');
         }
     
     }

      return $this->fetch();
      }

     public function userxx()
    { 
      $id=session('uid');
       if(request()->isPost()){

     $arr=request()->file('photo');
     //$id=session('uid');
     //dump($id);die;
     $data=db('sun_user')->where('id','=',$id)->find();
     if($arr){
      $info = $arr->move(ROOT_PATH. DS . 'uploads');
            $dataimg='/'.'uploads'.'/'.$info->getSaveName();
            $data['image']=$dataimg;
          }else{
            return $this->error('请选择图片');
          }
     
     //dump($data);die;
     $user=db('sun_user')->update($data);
     if($user){
             return $this->success('修改头像成功','index/index/user');
         }else{
             return $this->error('修改头像失败');
         }
     }
         
        //dump($data);die;
     $data=db('sun_user')->where('id','=',$id)->find();
     $this->assign('user',$data);
      return $this->fetch();
      }
  
 
 





    //修改
  public function userxg()
    {  $id=session('uid');
        $user=Db::table('sun_user')
        ->alias('u')
        ->join('sun_agent a','u.agent_class=a.id')
        ->where('u.id','=',$id)->find();
        //dump($user);die;
        $this->assign('user',$user);
        return $this->fetch();
      }
    //提现
     public function usertx()
    { 
      $id=session('uid');
      $user=db('sun_user')->where('id','=',$id)->where('status','=','1')->find();
      $this->assign('user',$user);
      if(request()->isPost()){
        $sta=db('sun_withdraw')->where('user_id','=',$id)->where('status','=','0')->find();
        //dump($sta);die;
        if(!$sta){
      $data=[
        'user_id'=>$id,
        'money'=>input('money'),
        'type'=>$user['banktype'],
        'bankcard'=>$user['banknumber'],
        'create_time'=>time(),
        'operator'=>'1',
        'status'=>'0',
      ];
      //dump($data);die;
      $validate= \think\loader::validate('Usertx');
        if(!$validate->scene('edit')->check($data)){
            $this->error($validate->getError());
            die;
        }
        if($user['money']>=$data['money']){
       if(db('sun_withdraw')->insert($data)){
        
        return $this->success('提现成功','index/index/user');
        }else{
            return $this->error('提现失败');
        } 
        }elseif($user['money']==0){
          return $this->error('余额不足');
        }else{
          return $this->error('余额不足');
        } 
      }else{
          return $this->error('你的提现正在审核!');
        } 
      
    }
      return $this->fetch();
      }
    //收款方式
    public function userskfs()
    { 
      if(request()->isPost()){
        $id=session('uid');
        $user=db('sun_user')->where('id','=',$id)->where('status','=','1')->find();
        $user['banktype']=input('banktype');
        $user['banknumber']=input('banknumber');
        $validate= \think\loader::validate('Sunuser');
        if(!$validate->scene('edit')->check($user)){
            $this->error($validate->getError());
            die;
        }
        //dump($user);die;
        if($user['banktype']=='--请选择--'){
          return $this->error('请选择收款方式');
        }else{
        if(db('sun_user')->update($user)){
            return $this->success('邦定账户成功','index/index/user');
        }else{
            return $this->error('邦定账户失败');
        }  
      }
      }else{
         $id=session('uid');
        $user=db('sun_user')->where('id','=',$id)->where('status','=','1')->find();
        $this->assign('user',$user);
      return $this->fetch();
    }
      }
     public function index()
    { 
     
       
        
      return $this->fetch();
      }

       public function user()
    { 
      $id=session('uid');
      //dump($id);die;
        $user=Db::table('sun_user')
        ->alias('u')
        ->join('sun_agent a','u.agent_class=a.id')
        ->where('u.id','=',$id)->find();
        //dump($user);die;
        $this->assign('user',$user);
      return $this->fetch();
      }
        public function usertd()
    { 
        $id=session('uid');
        $user=Db::table('sun_user')
        ->alias('u')
        ->join('sun_agent a','u.agent_class=a.id')
        ->where('u.id','=',$id)->find();
       
        $this->assign('user',$user);
        return $this->fetch();
      }
         public function xiaji()
    { 
        $id=session('uid');
        //$user=db('sun_user')->where('pid','=',$id)->select();
        $user=Db::table('sun_user')
        ->alias('u')
        ->join('sun_agent a','u.agent_class=a.id')
        ->field('u.*,a.agent_name')
        ->where('u.pid','=',$id)->select();
        $list=array();
        $listsun=array();
        foreach ($user as $key => $value) 
        {
            $listsun["userid"]=$value["id"];
            $listsun["username"]=$value["names"];
            $listsun["pid"]=$value["pid"];
            $listsun["mobile"]=$value["mobile"];
            $listsun["agent_name"]=$value["agent_name"];
            //$u=db('sun_user')->where('pid','=',$value['id'])->select();
            //echo $value["id"];
            $u=Db::table('sun_user')
            ->alias('u')
            ->join('sun_agent a','u.agent_class=a.id')
            ->where('u.pid','=',$value["id"])->select();
            $listsun["user"]=$u;
            $list[]=$listsun;
        }
        //dump($list);
        //die;
        $this->assign('user',$list);
      return $this->fetch();
      }
         



}
