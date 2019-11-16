<?php
namespace accapys;

use think\Loader;
use Corebairo\Corebairo;
use Con\Con;
/**
 * 异步通知处理类
 */
class Notify
{
    /**
     * 此为主函数, 即处理自己业务的函数, 重写后, 框架会自动调用
     *
     * @param array $data 微信传递过来的参数数组
     * @param string $msg 错误信息, 用于记录日志
     */
       public function NotifyProcess($data)
    {        
        
        // 3.去本地服务器检查订单状态(强烈建议需要)
        $order = $this->getOrder($data);
        if(empty($order)) {
            $msg = '本地订单不存在';
            return false;
        }
         
        // 4.检查订单状态
        if($this->checkOrderStatus($order)) {
            // 如果订单处理过, 则直接返回true
            return true;
        }

        // 订单状态未修改情况下, 进行处理业务
        $result = $this->processOrder($order, $data);
  
        if(!$result) {
            $msg = '订单处理失败';
            return false;
        }

        return true;
    }

    /**
     * 处理核心业务
     * @param  array $order 订单信息
     * @param  array $data  通知数组
     * @return Bollean
     */
    public function processOrder($order, $data)
    {
        // 进行核心业务处理, 如更新状态, 发送通知等等
        // 处理成功, 返回true, 处理失败, 返回false
        // 例如:
        //查询有没有订单进来sales表
        $sales=db('sales')->where('id','=', $order['id'])->find();
        //如果有，查询改订单是否已经有为1的状态
        if($sales)
        {
            //执行查询
            $tag= db('sales')->where('id','=', $order['id'])->where('status','=',1)->find();
            //如果有，就不管了，如果没有，改1，并执行其他操作
            if(!$tag)
            {  
              	$result = db('sales')->where('id', $order['id'])->update(['status'=>1, 'out_trade_no'=>$data['bkTrxId'],'transaction_id'=>$data['ipsTrxId']]);
                $str= db('sales')->where('id','=', $order['id'])->where('status','=',1)->find();
              
                //准备数据，准备插入查询表
                //查询用户信息
                $user=db('user')->where('id','=', $sales['uid'])->find();
                //查询次数
                $user_sishu['id'] = $user['id'];
                $user_sishu['pingfeng'] = $user['pingfeng']+1;
                $result_sishu = db('user')->where('id', $user_sishu['id'])->update($user_sishu);
                //查询版本人信息
                $product = db('product')->where('id','=', $sales['pid'])->find();
                $userid=session('uid');
                //插入查询表查询表
                $chaxun_data=[
                    'ordernumber'=>$sales['body'],
                    'uid'=>$sales['uid'],
                    'dates'=>time(),
                    'remarks'=>0,
                    'pid'=>$sales['pid'],
                    'price'=>$sales['total_fee']/100,
                    'sid'=>$sales['id'],
                    'names'=>$user['names'],
                    'idcard'=>$user['idcard'],
                    'tel'=>$user['mobile'],
                    'ma_id'=>$product['uid']
                ];
                $chaxun_id=db('chaxun')->insertGetId($chaxun_data);
                //$chaxun_id='1407';
                //查询版本信息
                if($chaxun_id)
                {
                    $kaishitime = strtotime('- 15 day',time());
                    $bairo = db('bairo')->where('uid','=',$sales['uid'])->where('createdAt','between',[$kaishitime,time()])->order('createdAt desc')->find();
                    $yunyingshang_data['chaxunid'] = $chaxun_id;
                    if(isset($bairo) && !empty($bairo)){
                        if(in_array($product['a_g_id'],[3,5])){
                            // //多头借贷与逾期记录综合查询接口
                            if(!empty($bairo['top_image'])){
                                $bairo_data['top_image'] = $bairo['top_image'];
                            }else{
                                $top_image = $this->top_image($user['names'],$user['mobile'],$user['idcard']);
                                $bairo_data['top_image'] = $top_image;
                            }
                        }

                        $bairo_data['json'] = $bairo['json'];

                    }else{

                        // //多头借贷与逾期记录综合查询接口
                        if(in_array($product['a_g_id'],[3,5])){
                            $top_image = $this->top_image($user['names'],$user['mobile'],$user['idcard']);
                            $bairo_data['top_image'] = $top_image;
                        }
                        $bairo = $this->bairo($user['names'],$user['mobile'],$user['idcard']);

                        $bairo_data['json'] = $bairo;
                    }

                    $bairo_id=db('bairo')->insertGetId($yunyingshang_data);

                    if($bairo_id){
                        $this->fenyong($sales['id']);
                    }


                    // //个人涉诉信息查询接口
                    file_put_contents("5555.txt",$product['a_g_id']);


                    // //百融查询接口
                    $bairo_data ['uid'] = $sales['uid'];
                    $bairo_data ['createdAt'] = time();
                    db('bairo')->where('id','=',$bairo_id)->update($bairo_data);

                }
                return $result;
            }
        }
    }


    // 去微信服务器查询是否有此订单
    public function Queryorder($transaction_id)
    {
        $input = new \WxPayOrderQuery();
        $input->SetTransaction_id($transaction_id);
        $result = \WxPayApi::orderQuery($input);
        if(array_key_exists("return_code", $result)
            && array_key_exists("result_code", $result)
            && $result["return_code"] == "SUCCESS"
            && $result["result_code"] == "SUCCESS")
        {
            return true;
        }
        return false;
    }
  
  	// 去本地服务器查询订单信息
    public function getOrder($data){
        // 可根据商户订单号进行查询
        // 例如:
      	$order = db('sales')->where('body', $data['trxId'])->find();
        return $order;
    }

    /**
     * 检查order状态, 是否已经做过修改, 避免重复修改
     * 原因: 可能由于业务处理较慢, 还未等回复微信服务器, 同一订单的另一个通知已到达,
     *      为了避免重复修改订单, 需要对状态进行检查
     *
     * @return Bollean
     */
    public function checkOrderStatus($order)
    {
        // 检查还未修改, 则返回true, 检查已经修改过了, 则返回false
        // 例如:
        return $order['status'] == 1 ? true : false;
    }



    function fenyong($dingdanid){
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
            $tichengs=$sales['total_fee']/100-$chengben;
            // dump($tichengs); dump($sales['total_fee']);
            if($tichengs < 0){
                $tichengs = 0;
            }
        }else{
            $chengben=$goods['price'];
            $tichengs=$sales['total_fee']/100-$chengben;
            if($tichengs < 0){
                $tichengs = 0;
            }
            // $tichengs=3;
        }
        //余额
        $balance=$tichenguser['money']+$tichengs;
        //插入提成表
        $datayiji=[
            'order_id'=>$sales['body'],
            'profit_id'=>$tichenguser['id'],
            'ratio'=>$sales['total_fee']/100,
            'create_time'=>time(),
            'money'=>$tichengs,
            'type'=>"直推奖励",
            'balance'=>$balance,
            'uid' => $sales['uid'],
            'aid' => $product['a_g_id'],
        ];

        $chaxun_ids=db('profit')->insertGetId($datayiji);
        if($chaxun_ids){
            $moneyyi['money']=$balance;
            $moneyyi['total_achievement']=$tichenguser['total_achievement']+$tichengs;
            //$moneyyi['id']=$tichenguser['id'];
            //$updateuser=db('user')->update($moneyyi);
            $updateuser=db('user')->where('id','=',$tichenguser['id'])->update($moneyyi);
        }
        //判断上级是否有提成权利
        $shangji=db('user')->where('id','=',$tichenguser['pid'])->find();
       if($tichenguser['isStaff'] == 1 && !empty($shangji)) {
                //员工推广佣金
                $balances=$shangji['money']+$tichengs;
                $dataerji=[
                    'order_id'=>$sales['body'],
                    'profit_id'=>$shangji['id'],
                    'ratio'=>$sales['total_fee']/100,
                    'create_time'=>time(),
                    'money'=>$tichengs,
                    'type'=>"员工直推",
                    'balance'=>$balances,
                    'uid'=> $sales['uid'],
                    'aid' => $product['a_g_id'],
                ];
                $chaxuner=db('profit')->insertGetId($dataerji);
                  if($chaxuner){
                    $moneyer['money'] = $balances;
                    $moneyer['total_achievement']=$shangji['total_achievement']+$tichengs;
                    $updateuser=db('user')->where('id','=',$shangji['id'])->update($moneyer);
                  }

        }else if(isset($shangji) && !empty($shangji) && $tichenguser['isStaff'] != 1){
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


    //接口查询
    //手机三要素验证（三网合一 A 版）接口
    public function yunyingshang($name,$mobile,$idcard)
    {
        $appid="YL9SiL2TeabDRAja";
        $appSecurity="YL9SiL2TeabDRAja0LV1XQdzUrg9Nolw";
        $timestamp=time();
        //app_id={app_id}&app_security={app_security}&timestamp={tim estamp} 进行 md5 加密计算即可得到 sign 签名。
        $one='app_id='.$appid.'&app_security='.$appSecurity.'&timestamp='.$timestamp;
        $sign=md5($one);
        $PostArry2 = array(
            "app_id" => $appid,
            "timestamp" => $timestamp,
            "sign" => $sign
        );
        $request1_url="https://b.shumaidata.com/api/authorize";
        $return1 =$this->Post($PostArry2, $request1_url);  //发送请求到服务器，并输出返回结果。
        $json=json_decode($return1,true);
        //dump($json);die;
        $token=$json['result']['token'];
        //$name='王升升';//$sun_chaxunss['names'];
        //$idcard='421126199512026319';//$sun_chaxunss['idcard'];
        // $mobile='18872695647';//$sun_chaxunss['tel'];
        $yunyingshang1url="https://b.shumaidata.com/api/v2/mobile/verify_real_name";
        $content="application/x-www-form-urlencoded";
        $yingshang1header=array(
            'token:'.$token,
            'content-type:'.$content
        );
        $datayunyingshang1 = array(
            "app_id" => $appid,
            "name" => $name,
            "idcard" => $idcard,
            "mobile" => $mobile
        );
        $yunyingshang1rture =$this->Header($datayunyingshang1,$yingshang1header, $yunyingshang1url);  //发送请求到服务器，并输出返回结果。
        //$yunyingshangs1=json_decode($yunyingshang1rture,true);
        return $yunyingshang1rture;
    }
    //在网时长
    public function phone($name,$mobile,$idcard)
    {
        $appid="YL9SiL2TeabDRAja";
        $appSecurity="YL9SiL2TeabDRAja0LV1XQdzUrg9Nolw";
        $timestamp=time();
        //app_id={app_id}&app_security={app_security}&timestamp={tim estamp} 进行 md5 加密计算即可得到 sign 签名。
        $one='app_id='.$appid.'&app_security='.$appSecurity.'&timestamp='.$timestamp;
        $sign=md5($one);
        $PostArry2 = array(
            "app_id" => $appid,
            "timestamp" => $timestamp,
            "sign" => $sign
        );
        $request1_url="https://b.shumaidata.com/api/authorize";
        $return1 =$this->Post($PostArry2, $request1_url);  //发送请求到服务器，并输出返回结果。
        $json=json_decode($return1,true);
        //dump($json);die;
        $token=$json['result']['token'];
        // $name='王升升';//$sun_chaxunss['names'];
        // $idcard='421126199512026319';//$sun_chaxunss['idcard'];
        // $mobile='18872695647';//$sun_chaxunss['tel'];
        $yunyingshangurl="https://b.shumaidata.com/api/v2/mobile/get_online_interval";
        $content="application/x-www-form-urlencoded";
        $yingshangheader=array(
            'token:'.$token,
            'content-type:'.$content
        );
        $datayunyingshang = array(
            "app_id" => $appid,
            "name" => $name,
            "idcard" => $idcard,
            "mobile" => $mobile
        );
        $yunyingshangrture = $this->Header($datayunyingshang,$yingshangheader, $yunyingshangurl);  //发送请求到服务器，并输出返回结果。
        //$yunyingshangs=json_decode($yunyingshangrture,true);
        return $yunyingshangrture;
        //dump($yunyingshangs);die;
    }
    //个人涉诉信息查询接口
    public function geren($name,$mobile,$idcard)
    {
        $appid="YL9SiL2TeabDRAja";
        $appSecurity="YL9SiL2TeabDRAja0LV1XQdzUrg9Nolw";
        $timestamp=time();
        //app_id={app_id}&app_security={app_security}&timestamp={tim estamp} 进行 md5 加密计算即可得到 sign 签名。
        $one='app_id='.$appid.'&app_security='.$appSecurity.'&timestamp='.$timestamp;
        $sign=md5($one);
        $PostArry2 = array(
            "app_id" => $appid,
            "timestamp" => $timestamp,
            "sign" => $sign
        );
        $request1_url="https://b.shumaidata.com/api/authorize";
        $return1 =$this->Post($PostArry2, $request1_url);  //发送请求到服务器，并输出返回结果。
        $json=json_decode($return1,true);
        //dump($json);die;
        $token=$json['result']['token'];
        // $name='王升升';//$sun_chaxunss['names'];
        // $idcard='421126199512026319';//$sun_chaxunss['idcard'];
        //$mobile='18872695647';//$sun_chaxunss['tel'];
        $gerenurl="https://b.shumaidata.com/api/v2/lawsuit_check/get";
        $gerenheader=array(
            'token:'.$token
        );
        $datageren = array(
            "app_id" => $appid,
            "name" => $name,
            "idcard" => $idcard,
            // "platform" => $platform
        );
        $gerenretrue = $this->Get($datageren,$gerenheader, $gerenurl);  //发送请求到服务器，并输出返回结果。
        //$gerenres=json_decode($gerenretrue,true);
        //dump($gerenres);die;
        return $gerenretrue;
    }
    //多头借贷与逾期记录综合查询接口
    public function duotou($name,$mobile,$idcard)
    {
        $appid="YL9SiL2TeabDRAja";
        $appSecurity="YL9SiL2TeabDRAja0LV1XQdzUrg9Nolw";
        $timestamp=time();
        //app_id={app_id}&app_security={app_security}&timestamp={tim estamp} 进行 md5 加密计算即可得到 sign 签名。
        $one='app_id='.$appid.'&app_security='.$appSecurity.'&timestamp='.$timestamp;
        $sign=md5($one);
        $PostArry2 = array(
            "app_id" => $appid,
            "timestamp" => $timestamp,
            "sign" => $sign
        );
        $request1_url="https://b.shumaidata.com/api/authorize";
        $return1 =$this->Post($PostArry2, $request1_url);  //发送请求到服务器，并输出返回结果。
        $json=json_decode($return1,true);
        //dump($json);die;
        $token=$json['result']['token'];
        //$name='王升升';//$sun_chaxunss['names'];
        /// $idcard='421126199512026319';//$sun_chaxunss['idcard'];
        //$mobile='18872695647';//$sun_chaxunss['tel'];
        $duotouurl="https://b.shumaidata.com/api/v2/multi_loan/get";
        $cycle='12';
        $platform='0';
        $duotoucontent="application/x-www-form-urlencoded";
        $duotouheader=array(
            'token:'.$token,
            'content-type:'.$duotoucontent
        );
        $dataduotou = array(
            "app_id" => $appid,
            "mobile" => $mobile,
            "cycle" => $cycle,
            "platform" => $platform
        );
        $dataduoreyure = $this->Header($dataduotou,$duotouheader, $duotouurl);  //发送请求到服务器，并输出返回结果。
        //$dataduos=json_decode($dataduoreyure,true);
        //dump($dataduos);die;
        return $dataduoreyure;
    }
    //金融黑名单查询接口
    public function jinron($name,$mobile,$idcard)
    {
        $appid="YL9SiL2TeabDRAja";
        $appSecurity="YL9SiL2TeabDRAja0LV1XQdzUrg9Nolw";
        $timestamp=time();
        //app_id={app_id}&app_security={app_security}&timestamp={tim estamp} 进行 md5 加密计算即可得到 sign 签名。
        $one='app_id='.$appid.'&app_security='.$appSecurity.'&timestamp='.$timestamp;
        $sign=md5($one);
        $PostArry2 = array(
            "app_id" => $appid,
            "timestamp" => $timestamp,
            "sign" => $sign
        );
        $request1_url="https://b.shumaidata.com/api/authorize";
        $return1 =$this->Post($PostArry2, $request1_url);  //发送请求到服务器，并输出返回结果。
        $json=json_decode($return1,true);
        //dump($json);die;
        $token=$json['result']['token'];
        // $name='王升升';//$sun_chaxunss['names'];
        //$idcard='421126199512026319';//$sun_chaxunss['idcard'];
        // $mobile='18872695647';//$sun_chaxunss['tel'];
        $jinronurl="https://b.shumaidata.com/api/v2/blacklist/check";
        $jinroncontent="application/x-www-form-urlencoded";
        $headerjinron=array(
            'token:'.$token,
            'content-type:'.$jinroncontent
        );

        $datajinron = array(
            "app_id" => $appid,
            "name" => $name,
            "mobile" => $mobile,
            "idcard" => $idcard
        );
        $jinronreture =  $this->Get($datajinron,$headerjinron, $jinronurl);  //发送请求到服务器，并输出返回结果。
        //$jinronreturereture=json_decode($jinronreture,true);
        //dump($jinronreturereture);die;
        return $jinronreture;
    }
    //
    public function bairo($name,$mobile,$idcard){
        $targetList = array(
            array(

                "id" =>$idcard,'421126199512026319',//$sun_chaxun['idcard'],
                "cell" =>$mobile,'18872695647',//$sun_chaxun['tel'],
                "name" =>$name,//'王升升',//$sun_chaxun['names'],
                "strategy_id"=>"STR0003076",
            )
        );
        $temp_res_arr=$this->ceshi($targetList);
        // dump($temp_res_arr);die;
        return $temp_res_arr;
    }
    //post传值方法
    function request_post($headers,$url = '', $post_data = array())
    {
        if (empty($url) || empty($post_data)) {
            return false;
        }

        $o = "";
        foreach ( $post_data as $k => $v )
        {
            $o.= "$k=" . urlencode( $v ). "&" ;
        }
        $post_data = substr($o,0,-1);



        $postUrl = $url;
        $curlPost = $post_data;
        $ch = curl_init();//初始化curl
        curl_setopt($ch, CURLOPT_URL,$postUrl);//抓取指定网页
        curl_setopt($ch, CURLOPT_HEADER, 0);//设置header
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE); // 对认证证书来源的检查
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE); // 从证书中检查SSL加密算法是否
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);//要求结果为字符串且输出到屏幕上
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_POST, true);//post提交方式
        curl_setopt($ch, CURLOPT_POSTFIELDS, $curlPost);
        $data = curl_exec($ch);//运行curl

        curl_close($ch);

        return $data;
    }
    function Header($PostArry,$array,$url)
    {

        $headers = $array;
        //$idCard="421181199110045597";
        //$idCards= json_encode($idCard);//格式化参数
        //dump($idCard);die;
        //$urls="https://b.shumaidata.com/api/v1/carrier/task?app_id=YL9SiL2TeabDRAja&account=18062677701&password=123456&idCard=".$idCard."&realName=刘伟祥&notifyUrl";
        $posturls= json_encode($url);//格式化参数
        $postData = $PostArry;
        $postDataString = http_build_query($postData);//格式化参数
        //初始化
        //dump($postDataString);die;
        $curl = curl_init();
        //dump($postDataString);die;
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE); // 对认证证书来源的检查
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE); // 从证书中检查SSL加密算法是否存在
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        //设置头文件的信息作为数据流输出
        //curl_setopt($curl, CURLOPT_HEADER, 0);
        //设置获取的信息以文件流的形式返回，而不是直接输出。
        //curl_setopt($curl, CURLOPT_POSTFIELDS, $postDataString); // Post提交的数据包
        curl_setopt($curl, CURLOPT_TIMEOUT, 60); // 设置超时限制防止死循环返回
        //设置抓取的url
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($curl, CURLOPT_POST, true); // 发送一个常规的Post请求
        curl_setopt($curl, CURLOPT_POSTFIELDS,$postDataString);

        //执行命令
        $tmpInfo = curl_exec($curl); // 执行操作
        if (curl_errno($curl)) {

            $tmpInfo = curl_error($curl);//捕抓异常
        }
        //关闭URL请求
        curl_close($curl); // 关闭CURL会话
        return $tmpInfo; // 返回数据
    }

    function ceshi($targetList)
    {
        require_once ROOT_PATH.'bairoconfig/cons.php';
        require_once ROOT_PATH.'bairoconfig/Corebairo.php';
        /**$appSecurity="YL9SiL2TeabDRAja0LV1XQdzUrg9Nolw";
        $account = "mmapiStr";
        $password = "mmapiStr";
        $apicode = "3003045";
        $login_url = "https://api.100credit.cn/bankServer2/user/login.action";
        $querys = array(
        //  'huaxiang' => 'https://api.100credit.cn/huaxiang/v1/get_report',
        // 'haina' => 'https://api.100credit.cn/HainaApi/data/getData.action',
        //  'TrinityForceAPI' => 'https://api.100credit.cn/trinity_force/v1/get_data',
        'strategyApi'=>"https://api.100credit.cn/strategyApi/v1/hxQuery",
        );**/
        // dump($con['account']);die;
        /**$targetList = array(
        array(
        "id" => "310224196209243110",
        "cell" => "15921188518",
        "name" => "阿斯加",
        //"id" => "310224196209243110",
        "strategy_id"=>"STR0002763",
        //"mail" => "000000@qq.com",
        //"bank_id" => "4367421216244199784"
        )
        );**/

        $Corebairo    = new Corebairo($con['account'],$con['password'],$con['apicode'], $querys,$headerTitle);
        $Core =Corebairo::getInstance($con['account'],$con['password'],$con['apicode'], $querys,$headerTitle);
        $temp_res_arr=$Corebairo-> query($targetList);
        return $temp_res_arr;
//dump($temp_res_arr);die;
    }
    function Post($PostArry,$request_url)
    {
        $postData = $PostArry;
        $postDataString = http_build_query($postData);//格式化参数
        $curl = curl_init(); // 启动一个CURL会话
        curl_setopt($curl, CURLOPT_URL, $request_url); // 要访问的地址
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE); // 对认证证书来源的检查
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE); // 从证书中检查SSL加密算法是否存在
        curl_setopt($curl, CURLOPT_POST, true); // 发送一个常规的Post请求
        curl_setopt($curl, CURLOPT_POSTFIELDS, $postDataString); // Post提交的数据包
        curl_setopt($curl, CURLOPT_TIMEOUT, 60); // 设置超时限制防止死循环返回
        curl_setopt($curl,CURLOPT_RETURNTRANSFER,true);

        $tmpInfo = curl_exec($curl); // 执行操作
        if (curl_errno($curl)) {

            $tmpInfo = curl_error($curl);//捕抓异常
        }
        curl_close($curl); // 关闭CURL会话
        return $tmpInfo; // 返回数据
    }
    function Get($PostArry,$array,$url){

        $headers = $array;
        $postData = $PostArry;
        //$postDataString = http_build_query($postData);//格式化参数
        //初始化
        $curl = curl_init();

        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE); // 对认证证书来源的检查
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE); // 从证书中检查SSL加密算法是否存在
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        //设置头文件的信息作为数据流输出
        //curl_setopt($curl, CURLOPT_HEADER, 0);
        //设置获取的信息以文件流的形式返回，而不是直接输出。
        //curl_setopt($curl, CURLOPT_POSTFIELDS, $postDataString); // Post提交的数据包
        curl_setopt($curl, CURLOPT_TIMEOUT, 60); // 设置超时限制防止死循环返回
        //设置抓取的url
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        //curl_setopt($curl, CURLOPT_POST, true); // 发送一个常规的Post请求
        if (is_array($postData)) {
            if (stripos($url, "?") === FALSE) {
                $url .= '?';
            }
            $url .= http_build_query($postData);
        }
        //curl_setopt($curl, CURLOPT_POSTFIELDS,$postDataString);
        curl_setopt($curl, CURLOPT_URL, $url);
        //执行命令
        $tmpInfo = curl_exec($curl); // 执行操作
        if (curl_errno($curl)) {

            $tmpInfo = curl_error($curl);//捕抓异常
        }
        //关闭URL请求
        curl_close($curl); // 关闭CURL会话
        return $tmpInfo; // 返回数据
    }


    //多头负债
    function top_image($names,$mobile,$idcard){
        $appId = '49645fcb675d2f46cbf54fbde5f543a0';
        $appSecret = 'd6c6ea8d79928a85cc016b40000cd4db';
        $url = 'https://sec2.dingxiang-inc.com/api/dataplatform/loansynchronizationquery';
        $sequenceNo = date('ymd').uniqid();
        $timestamp = time();
        #$token = '0315201448000VkyUKd6o186MqHL7Smc';
        $param = array(
            'customerId' => $appId,
            'timeStamp' => $timestamp,
            'sign' =>MD5($appSecret . $appId . $timestamp . $appSecret),
            'name' => $names,
            'idcard' => $idcard,
            'mobile' => $mobile,
        );

        //吴亚栋 340822199512080958  15055636776
        //张涛 620102197906026916  13893386530
        //陈微  420821198111112364  13487070044
        //echo (http_build_query($param));die;
        // var_dump($url.$getparam);exit;
        $crawlerResult = curlPost($url,$param);
        return  $crawlerResult;
        #echo "<pre>";
        #var_dump(json_decode($crawlerResult,true));
    }

}

