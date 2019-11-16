<?php

namespace app\index\controller;

use Corebairo\Corebairo;
use think\Controller;

class Xnutify extends Controller
{

    /**
     * 此为主函数, 即处理自己业务的函数, 重写后, 框架会自动调用
     *
     * @param array $data 微信传递过来的参数数组
     * @param string $msg 错误信息, 用于记录日志
     */
    public function NotifyProcess($params = '')
    {
        if(empty($params)){
            $params = $this->request->param();
        }
      
        $sign = md5(join('',[$params['aoid'], $params['order_id'], $params['pay_price'], $params['pay_time'], '974ff4c5219c48b3b6bf373905e58893']));
        if($sign != $params['sign']){
            return false;
        }
			
        $data = json_decode(htmlspecialchars_decode($params['detail']),true);
        // 3.去本地服务器检查订单状态(强烈建议需要)
        $order = $this->getOrder(['out_trade_no'=>$params['order_id']]);
        if(empty($order)) {
            return false;
        }
        // 4.检查订单状态
        if($this->checkOrderStatus($order)) {
            return true;
        }

        // 订单状态未修改情况下, 进行处理业务
        $result = $this->processOrder($order, $data);
        if(!$result) {
            return false;
        }
        return 'ok';
    }


    /**
     * 查询订单
     * @param $data
     * @return array|false|\PDOStatement|string|\think\Model
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function getOrder($data)
    {
        // 可根据商户订单号进行查询
        // 例如:
        $order = db('sales')->where('out_trade_no', $data['out_trade_no'])->find();
        return $order;
    }


    /**
     * 查询订单状态
     * @param $order
     * @return bool
     */
    public function checkOrderStatus($order)
    {
        // 检查还未修改, 则返回true, 检查已经修改过了, 则返回false
        // 例如:
        return $order['status'] == 1 ? true : false;
    }



    /**
     * 处理核心业务
     * @param  array $order 订单信息
     * @param  array $data 通知数组
     * @return Bollean
     */
    public function processOrder($order, $data)
    {
        // 进行核心业务处理, 如更新状态, 发送通知等等
        // 处理成功, 返回true, 处理失败, 返回false
        // 例如:
        //查询有没有订单进来sales表
      
        $sales = db('sales')->where('id', '=', $order['id'])->find();
        //如果有，查询改订单是否已经有为1的状态
        if ($sales) {
            //执行查询
            $tag = db('sales')->where('id', '=', $order['id'])->where('status', '=', 1)->find();
            
            //如果有，就不管了，如果没有，改1，并执行其他操作
            if (!$tag) {
                $result = db('sales')->where('id', $order['id'])->update(['status' => 1, 'transaction_id' => $data['transaction_id']]);
                //return $result;
                //准备数据，准备插入查询表
                //查询用户信息
                $user = db('user')->where('id', '=', $sales['uid'])->find();
                
                //查询次数
                $user_sishu['id'] = $user['id'];
                $user_sishu['pingfeng'] = $user['pingfeng'] + 1;
                $result_sishu = db('user')->where('id', $user_sishu['id'])->update($user_sishu);
                //查询版本人信息
                $product = db('product')->where('id', '=', $sales['pid'])->find();
                $userid = session('uid');
                //插入查询表查询表
                $chaxun_data = [
                    'ordernumber' => $sales['body'],
                    'uid' => $sales['uid'],
                    'dates' => time(),
                    'remarks' => 0,
                    'pid' => $sales['pid'],
                    'price' => $sales['total_fee'] / 100,
                    'sid' => $sales['id'],
                    'names' => $user['names'],
                    'idcard' => $user['idcard'],
                    'tel' => $user['mobile'],
                    'ma_id' => $product['uid']
                ];
                $chaxun_id = db('chaxun')->insertGetId($chaxun_data);
                //$chaxun_id='1407';
                //查询版本信息
                if ($chaxun_id) {
                    $kaishitime = strtotime('- 15 day', time());
                    $bairo = db('bairo')->where('uid', '=', $sales['uid'])->where('createdAt', 'between', [$kaishitime, time()])->order('createdAt desc')->find();
                    $yunyingshang_data['chaxunid'] = $chaxun_id;
  	               
                    if (isset($bairo) && !empty($bairo)) {
                        if (in_array($product['a_g_id'], [3, 5])) {
                            // //多头借贷与逾期记录综合查询接口
                            if (!empty($bairo['top_image'])) {
                                $bairo_data['top_image'] = $bairo['top_image'];
                            } else {
                                $top_image = $this->top_image($user['names'], $user['mobile'], $user['idcard']);
                                $bairo_data['top_image'] = $top_image;
                            }
                        }
                   
                        $bairo_data['json'] = $bairo['json'];
                    }else{
                        // //多头借贷与逾期记录综合查询接口
                        if (in_array($product['a_g_id'], [3, 5])) {
                            $top_image = $this->top_image($user['names'], $user['mobile'], $user['idcard']);
                            $bairo_data['top_image'] = $top_image;
                        }
                        $bairo = $this->bairo($user['names'], $user['mobile'], $user['idcard']);
            
                        $bairo_data['json'] = $bairo;
                    }
                    $bairo_id = db('bairo')->insertGetId($yunyingshang_data);
                    if ($bairo_id) {
                        $this->fenyong($sales['id']);
                    }
                  
                    // //百融查询接口
                    $bairo_data ['uid'] = $sales['uid'];
                    $bairo_data ['createdAt'] = time();
               
                    db('bairo')->where('id', '=', $bairo_id)->update($bairo_data);

                }
                return $result;
            }
        }
    }


    /**
     *
     * 佣金处理
     * @param $dingdanid
     * @throws \think\Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * @throws \think\exception\PDOException
     */
  
  function fenyong($dingdanid){
        //价格查询
        //$dingdanid='8697';
        //查询订单
        $sales=db('sales')->where('id','=',$dingdanid)->find();
        //dump($sales);die;
        //查询提出者信息
        $tichenguser=db('user')->where('id','=',$sales['sessionfpid'])->find();
        //dump($tichenguser);
        //代理等级信息
        $tichengagent=db('agent')->where('id','=',$tichenguser['agent_class'])->find();
    	//版本表查询
        $product=db('product')->where('id','=',$sales['pid'])->find();
        //商品表
        $goods=db('goods')->where('id','=',$product['a_g_id'])->find();
        //查询代理等级成本价格
        $tichenggoods=db('agentgoods')->where('aid','=',$tichengagent['id'])->where('gid','=',$goods['id'])->find();
        //判断代理等级成本表是否有
        //没有按goods表成本价
        //查询分成金额
        if($tichenggoods){
          $chengben=$tichenggoods['price'];
        }else{
          $chengben=$goods['price'];
        }
        //余额
        $balance=$tichenguser['money']+$chengben;
        //插入提成表
        $datayiji=[
                      'order_id'=>$sales['body'],
                      'profit_id'=>$tichenguser['id'],
                      'ratio'=>$sales['total_fee']/100,
                      'create_time'=>time(),
                      'money'=>$chengben,
                      'type'=>"直推奖励",
                      'balance'=>$balance,
                      'uid' => $sales['uid'],
                       'aid' => $product['a_g_id'],
                      ];

        $chaxun_ids=db('profit')->insertGetId($datayiji);
       	if($chaxun_ids){
        	$moneyyi['money']=$balance;
          	$moneyyi['total_achievement']=$tichenguser['total_achievement']+$chengben;
      		//$moneyyi['id']=$tichenguser['id'];
            //$updateuser=db('user')->update($moneyyi);
          	$updateuser=db('user')->where('id','=',$tichenguser['id'])->update($moneyyi);
        }
        //判断上级是否有提成权利
        $shangji=db('user')->where('id','=',$tichenguser['pid'])->find();
    	if($shangji){
          //查询代理等级成本价格
            // /dump($shangji);
            $erjiticheng = db('agentgoods')->where('aid','=',$shangji['agent_class'])->where('gid','=',$goods['id'])->find();
            if(isset($erjiticheng) and $erjiticheng['erjiprice'] > 0 ){
                $erjiprice = $erjiticheng['erjiprice'];
            }else{
                if(isset($goods) and $goods['commission'] > 0 ){
                    $erjiprice = $goods['commission'];
                }
            }
            if(isset($erjiprice) and !empty($erjiprice)){
                $balances=$shangji['money']+$erjiprice;
                $dataerji=[
                    'order_id'=>$sales['body'],
                    'profit_id'=>$shangji['id'],
                    'ratio'=>$sales['total_fee']/100,
                    'create_time'=>time(),
                    'money'=>$erjiprice,
                    'type'=>"二级奖励",
                    'balance'=>$balances,
                    'uid'=> $sales['uid'],
                    'aid' => $product['a_g_id'],
                ];
                //dump($balances);die;
                $chaxuner=db('profit')->insertGetId($dataerji);
                  if($chaxuner){
                  $moneyer['money']=$balances;
                    $moneyer['total_achievement']=$shangji['total_achievement']+$erjiprice;
                    $updateuser=db('user')->where('id','=',$shangji['id'])->update($moneyer);
                  }
              }
        }
        //余额添加
     }
  
  
  
    function fenyongss($dingdanid)
    {
        //价格查询
        //$dingdanid='8697';
        //查询订单
        $sales = db('sales')->where('id', '=', $dingdanid)->find();
        //dump($sales);die;
        //查询提出者信息
        $tichenguser = db('user')->where('id', '=', $sales['sessionfpid'])->find();
        //dump($tichenguser);
        //代理等级信息
        $tichengagent = db('agent')->where('id', '=', $tichenguser['agent_class'])->find();
        //版本表查询
        $product = db('product')->where('id', '=', $sales['pid'])->find();
        //商品表
        $goods = db('goods')->where('id', '=', $product['a_g_id'])->find();
        //查询代理等级成本价格
        $tichenggoods = db('agentgoods')->where('aid', '=', $tichengagent['id'])->where('gid', '=', $goods['id'])->find();

        //判断代理等级成本表是否有
        //没有按goods表成本价
        //查询分成金额
        if ($tichenggoods) {
            $chengben = $tichenggoods['price'];
            $tichengs = $sales['total_fee'] / 100 - $chengben;
            // dump($tichengs); dump($sales['total_fee']);
            if ($tichengs < 0) {
                $tichengs = 0;
            }
        } else {
            $chengben = $goods['price'];
            $tichengs = $sales['total_fee'] / 100 - $chengben;
            if ($tichengs < 0) {
                $tichengs = 0;
            }
            // $tichengs=3;
        }
        //余额
        $balance = $tichenguser['money'] + $tichengs;
        //插入提成表
        $datayiji = [
            'order_id' => $sales['body'],
            'profit_id' => $tichenguser['id'],
            'ratio' => $sales['total_fee'] / 100,
            'create_time' => time(),
            'money' => $tichengs,
            'type' => "直推奖励",
            'balance' => $balance,
            'uid' => $sales['uid'],
            'aid' => $product['a_g_id'],
        ];

        $chaxun_ids = db('profit')->insertGetId($datayiji);
        if ($chaxun_ids) {
            $moneyyi['money'] = $balance;
            $moneyyi['total_achievement'] = $tichenguser['total_achievement'] + $tichengs;
            $updateuser = db('user')->where('id', '=', $tichenguser['id'])->update($moneyyi);
        }
        //判断上级是否有提成权利
        $shangji = db('user')->where('id', '=', $tichenguser['pid'])->find();
        if ($tichenguser['isStaff'] == 1 && !empty($shangji)) {
            //员工推广佣金
            $balances = $shangji['money'] + $tichengs;
            $dataerji = [
                'order_id' => $sales['body'],
                'profit_id' => $shangji['id'],
                'ratio' => $sales['total_fee'] / 100,
                'create_time' => time(),
                'money' => $tichengs,
                'type' => "员工直推",
                'balance' => $balances,
                'uid' => $sales['uid'],
                'aid' => $product['a_g_id'],
            ];
            $chaxuner = db('profit')->insertGetId($dataerji);
            if ($chaxuner) {
                $moneyer['money'] = $balances;
                $moneyer['total_achievement'] = $shangji['total_achievement'] + $tichengs;
                $updateuser = db('user')->where('id', '=', $shangji['id'])->update($moneyer);
            }

        } else if (isset($shangji) && !empty($shangji) && $tichenguser['isStaff'] != 1) {
            //查询代理等级成本价格
            // /dump($shangji);
            $erjiticheng = db('agentgoods')->where('aid', '=', $shangji['agent_class'])->where('gid', '=', $goods['id'])->find();
            if (isset($erjiticheng) and $erjiticheng['erjiprice'] > 0) {
                $erjiprice = $erjiticheng['erjiprice'];
            } else {
                if (isset($goods) and $goods['commission'] > 0) {
                    $erjiprice = $goods['commission'];
                }
            }
            if (isset($erjiprice) and !empty($erjiprice)) {
                $balances = $shangji['money'] + $erjiprice;
                $dataerji = [
                    'order_id' => $sales['body'],
                    'profit_id' => $shangji['id'],
                    'ratio' => $sales['total_fee'] / 100,
                    'create_time' => time(),
                    'money' => $erjiprice,
                    'type' => "二级奖励",
                    'balance' => $balances,
                    'uid' => $sales['uid'],
                    'aid' => $product['a_g_id'],
                ];
                //dump($balances);die;
                $chaxuner = db('profit')->insertGetId($dataerji);
                if ($chaxuner) {
                    $moneyer['money'] = $balances;
                    $moneyer['total_achievement'] = $shangji['total_achievement'] + $erjiprice;
                    $updateuser = db('user')->where('id', '=', $shangji['id'])->update($moneyer);
                }
            }

        }
        //余额添加
    }


    /**
     * 多头负债api
     * @param $names
     * @param $mobile
     * @param $idcard
     * @return mixed
     */
    function top_image($names, $mobile, $idcard)
    {
        $appId = '49645fcb675d2f46cbf54fbde5f543a0';
        $appSecret = 'd6c6ea8d79928a85cc016b40000cd4db';
        $url = 'https://sec2.dingxiang-inc.com/api/dataplatform/loansynchronizationquery';
        $sequenceNo = date('ymd') . uniqid();
        $timestamp = time();
        $param = array(
            'customerId' => $appId,
            'timeStamp' => $timestamp,
            'sign' => MD5($appSecret . $appId . $timestamp . $appSecret),
            'name' => $names,
            'idcard' => $idcard,
            'mobile' => $mobile,
        );

        $crawlerResult = curlPost($url, $param);
        return $crawlerResult;
    }


    /**
     * 百融数据API
     * @param $name
     * @param $mobile
     * @param $idcard
     * @return mixed
     */
    public function bairo($name,$mobile,$idcard){
        $targetList = array(
            array(
                "id" =>$idcard,
                "cell" =>$mobile,
                "name" =>$name,
                "strategy_id"=>"STR0003076",
            )
        );
        $temp_res_arr=$this->ceshi($targetList);
        return $temp_res_arr;
    }


    /** 百融API
     * @param $targetList
     * @return mixed
     */
   public function ceshi($targetList)
    {
        require_once ROOT_PATH.'bairoconfig/cons.php';
        require_once ROOT_PATH.'bairoconfig/Corebairo.php';
        $Corebairo    = new Corebairo($con['account'],$con['password'],$con['apicode'], $querys,$headerTitle);
        $Core =Corebairo::getInstance($con['account'],$con['password'],$con['apicode'], $querys,$headerTitle);
        $temp_res_arr=$Corebairo-> query($targetList);
        return $temp_res_arr;
    }

}