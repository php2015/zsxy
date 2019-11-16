<?php
namespace app\index\controller;

use think\Controller;
use think\Db;
use think\Session;
use Utils\Utils;
use EncryptUtil\EncryptUtil;
use Helper\Helper;
use HttpCurl\HttpCurl;
use Log\Log;
class Credit extends Controller
{

     public function index()
    {
       return $this->fetch();
    }
    public function credit()
    {
    
     // $zf=input('zf');
      $chaxunidss=input('chaxunid');
     if(!empty($chaxunidss)){
      $chaxunids=base64_decode(base64_decode($chaxunidss));
      $sun_sales=db('sales')->where("id","=",$chaxunids)->where('status','=',1)->find();
      
      
      $sunchaxunsss=db('chaxun')
        ->alias('c')
        ->join('sun_chaxun_quanjing q','c.id=q.chaxunid')
        ->join('sun_chaxun_heijing h','c.id=h.chaxunid')
        ->join('sun_chaxun_yunyingshang y','c.id=y.chaxunid')
        ->field('c.*')
         ->where('c.sid','=',$chaxunids)->select();
      
      
      $sun_chaxunss=db('chaxun')->where("sid","=",$chaxunids)->order("id desc")->find();
      //dump($sunchaxunsss);die;
      if(!$sunchaxunsss){
         $id=session('uid');
       $ordernumber="D".$id.time();
      /** $da=[
                  'ordernumber'=>$ordernumber,
                  'uid'=> $id,
                  'dates'=>time(),
                  'remarks'=>0,
                  'pid'=>$sun_chaxunss['pid'],
                  'price'=>$sun_chaxunss['price'],
                'sid'=>$sun_chaxunss['sid'],
          'names'=>$sun_chaxunss['names'],
          'idcard'=>$sun_chaxunss['idcard'],
          'tel'=>$sun_chaxunss['tel']
                 ];
          $chaxunidsss=db('chaxun')->insertGetId($da);**/
      
      
      
       $sun_chaxun=db('chaxun')->where("id","=",$sun_chaxunss['id'])->find();
        //dump($chaxunids);die;
      $chaxunid=$sun_chaxun['id'];
      $nowtime=time();
      $shijian=$nowtime - $sun_sales['product_id'];
    // dump($sun_chaxun);die;
      // if($shijian<1800){
       header("content-type:text/html;charset=utf8");
          require_once  ROOT_PATH.'config/config.php';
       //$credit1= $this->credit1();
     // $credit2= $this->credit2();
      //dump($credit2);die;
          //Log::LogWirte("=================================");
     
          $user=db('user')->where('id','=',$id)->where('status','=','1')->find();
     
     // dump($op);die;
          $request_url = "https://test.xinyan.com/product/radar/v3/apply";//请求地址
          $member_id = $config["memberId"];
          $terminal_id = $config["terminalId"];
          $result = "";
          $arrayData = "";
          $PostArryJson = "";
          $urlType ="ZX-RadarUrl";
          $id_no = $user["idcard"];
          $id_name = $user["names"];
          $bankcard_no ="";//bankcard_no
          $phone_no =$user["mobile"];
      $idcard = $user["idcard"];
     $name = $user["names"];
     $mobile =$user["mobile"];
          //Log::LogWirte("原始数据： id_no:".$id_no.",id_name:".$id_name.",bankcard_no:".$bankcard_no.",phone_no:".$phone_no);
           $Utils    = new Utils();
        $id_no =Utils::md5_32($id_no);
       $id_no1 =Utils::md5_32($id_no);
         $id_no4 =Utils::md5_32($id_no);
          //$id_no=Utils::md5_32($id_no);
          $id_name=Utils::md5_32($id_name);
         $id_name4=Utils::md5_32($id_name);
          $bankcard_no=Utils::md5_32($bankcard_no);
      $bankcard_no1=Utils::md5_32($bankcard_no);
          $phone_no=Utils::md5_32($phone_no);
         $phone_no4=Utils::md5_32($phone_no);
          
          //Log::LogWirte("32位小写MD5加密后数据： id_no:".$id_no.",id_name:".$id_name.",bankcard_no:".$bankcard_no.",phone_no:".$phone_no);
          $versions ="1.3.0";//versions
          $trans_id = Utils::create_uuid();//商户订单号
         $trans_id12 = Utils::create_uuid();//商户订单号
          $trans_id11 = Utils::create_uuid();//商户订单号
       $trans_id1 = Utils::create_uuid();//商户订单号
        // dump($trans_id);dump($trans_id12);dump();die;
          $trade_date = Utils::trade_date();//交易时间
      

          $arrayData = array(
              "member_id" => $member_id,
              "terminal_id" => $terminal_id,
              "trans_id" => $trans_id,
              "trade_date" => $trade_date,
              "id_no" => $id_no,
              "id_name" => $id_name,
              "bankcard_no" => $bankcard_no,
              "phone_no" => $phone_no,
              "industry_type" => "A1", //根据当前商户的行业类型传参数
              "versions" => $versions

          );
          // *** 数据格式化***
          $data_content = str_replace("\\/", "/", json_encode($arrayData));//转JSON
          //Log::LogWirte("====请求明文：" . $data_content);
          $pfxpath = ROOT_PATH. "framework/certificate/" . $config["merchant_private_key"];
          
          // if (!file_exists($pfxpath)) { //检查文件是否存在
          //     Log::LogWirte("=====私钥不存在");
          //     exit;
          // }
          $pfx_pwd = $config["pfxPwd"];
         // Log::LogWirte($pfxpath . "  " . $pfx_pwd);
          // **** 先BASE64进行编码再RSA加密 ***
          
          $encryptUtil = new EncryptUtil($pfxpath, "", $pfx_pwd, TRUE); //实例化加密类。
          
          $data_content = $encryptUtil->encryptedByPrivateKey($data_content);
          
          //Log::LogWirte("====加密串" . $data_content);
          $data_type = $config["dataType"];
          $PostArry = array(
              "member_id" => $member_id,
              "terminal_id" => $terminal_id,
              "data_type" => $data_type,
              "data_content" => $data_content);


          $PostArryJson = str_replace("\\/", "/", json_encode($PostArry));//转JSON
          $request_url = $config[$urlType];
          //Log::LogWirte("请求url：" . $request_url);
         $HttpCurlnew    = new HttpCurl();
         $return = HttpCurl::Post($PostArry, $request_url);  //发送请求到服务器，并输出返回结果。
      
      
      
      
      
      $trade_date1 = Utils::trade_date();//交易时间
      $arrayData2 = array(
              "member_id" => $member_id,
              "terminal_id" => $terminal_id,
              "trans_id" => $trans_id1,
              "trade_date" => $trade_date,
              "id_no" => $id_no,
              "id_name" => $id_name,
              "bankcard_no" => $bankcard_no1,
              "phone_no" => $phone_no,
              "industry_type" => "A1", //根据当前商户的行业类型传参数
              "versions" => $versions

          );
     // dump($arrayData);
     // dump($arrayData2);die;
          // *** 数据格式化***
          $data_content2 = str_replace("\\/", "/", json_encode($arrayData2));//转JSON
          //Log::LogWirte("====请求明文：" . $data_content);
          $pfxpath2 = ROOT_PATH. "framework/certificate/" . $config["merchant_private_key"];
          
          // if (!file_exists($pfxpath)) { //检查文件是否存在
          //     Log::LogWirte("=====私钥不存在");
          //     exit;
          // }
          $pfx_pwd2 = $config["pfxPwd"];
         // Log::LogWirte($pfxpath . "  " . $pfx_pwd);
          // **** 先BASE64进行编码再RSA加密 ***
          
          $encryptUtil = new EncryptUtil($pfxpath2, "", $pfx_pwd2, TRUE); //实例化加密类。
          
          $data_content2 = $encryptUtil->encryptedByPrivateKey($data_content2);
          
          //Log::LogWirte("====加密串" . $data_content);
          $data_type2 = $config["dataType"];
          $PostArry2 = array(
              "member_id" => $member_id,
              "terminal_id" => $terminal_id,
              "data_type" => $data_type2,
              "data_content" => $data_content2);


          $PostArryJson2 = str_replace("\\/", "/", json_encode($PostArry2));//转JSON
      // $request1_url =$config["YQDAUrl"];//"https://test.xinyan.com/product/archive/v3/overdue";//请求地址 $config[$urlType];
          //Log::LogWirte("请求url：" . $request_url);
        // $HttpCurlnew    = new HttpCurl();
         // $return1 = HttpCurl::Post($PostArry2, $request1_url);  //发送请求到服务器，并输出返回结果。
      //  $json1=json_decode($return1,true);
     // dump ($json1);die;
      
      
      $arrayData1 = array(
              "member_id" => $member_id,
              "terminal_id" => $terminal_id,
              "trans_id" => $trans_id11,
              "trade_date" => $trade_date,
            "industry_type" =>"A1",
              "id_card" => $idcard,
              "name" => $name,
             // "bankcard_no" => $bankcard_no,
              "mobile" => $mobile,
              //"industry_type" => "A1", //根据当前商户的行业类型传参数
             "type" => "ST_ON"

          );
      $data_content1 = str_replace("\\/", "/", json_encode($arrayData1));//转JSON
          //Log::LogWirte("====请求明文：" . $data_content);
          $pfxpath1 = ROOT_PATH. "framework/certificate/" . $config["merchant_private_key"];
          
          // if (!file_exists($pfxpath)) { //检查文件是否存在
          //     Log::LogWirte("=====私钥不存在");
          //     exit;
          // }
          $pfx_pwd1 = $config["pfxPwd"];
         // Log::LogWirte($pfxpath . "  " . $pfx_pwd);
          // **** 先BASE64进行编码再RSA加密 ***
          
          $encryptUtil = new EncryptUtil($pfxpath1, "", $pfx_pwd1, TRUE); //实例化加密类。
          
          $data_content1 = $encryptUtil->encryptedByPrivateKey($data_content1);
          
          //Log::LogWirte("====加密串" . $data_content);
          $data_type1 = $config["dataType"];
          $PostArry1 = array(
              "member_id" => $member_id,
              "terminal_id" => $terminal_id,
              "data_type" => $data_type,
              "data_content" => $data_content1);

      
       $request2_url =$config["GHSUrl"];//"https://test.xinyan.com/operators/v2/authInfo";//请求地址 $config[$urlType];
          //Log::LogWirte("请求url：" . $request_url);
         $HttpCurlnew    = new HttpCurl();
          $return2 = HttpCurl::Post($PostArry1, $request2_url);  //发送请求到服务器，并输出返回结果。
      $json2=json_decode($return2,true);
       
      

         // Log::LogWirte("请求返回参数：" . $return);
          if (empty($return)) {
              throw new Exception("返回为空，确认是否网络原因！");
          }
          //** 处理返回的报文 */
          //Log::LogWirte("结果：" . $return);
         $json=json_decode($return,true);
      //dump($json);die;
            $quanjing ['chaxunid']=$chaxunid;
        $quanjing ['code']=$json["data"]["code"];
           if(isset($json['data']['result_detail']['current_report_detail']['consfin_credit_limit'])){
          $quanjing['consfin_credit_limit']=$json["data"]["result_detail"]["current_report_detail"]["consfin_credit_limit"];
        }
            if(isset($json["data"]["result_detail"]["current_report_detail"]["consfin_credit_limit"])){
           $quanjing['loans_org_count2']=$json["data"]["result_detail"]["current_report_detail"]["loans_org_count"];
        }
        if(isset($json["data"]["result_detail"]["current_report_detail"]["consfin_avg_limit"])){
         $quanjing['loans_org_count']=$json["data"]["result_detail"]["current_report_detail"]["consfin_avg_limit"];
        }
        if(isset($json["data"]["result_detail"]["current_report_detail"]["consfin_avg_limit"])){
         $quanjing[ 'consfin_avg_limit']=$json["data"]["result_detail"]["current_report_detail"]["consfin_avg_limit"];
        }
        if(isset($json["data"]["result_detail"]["current_report_detail"]["loans_product_count"])){
         $quanjing[ 'loans_product_count']=$json["data"]["result_detail"]["current_report_detail"]["loans_product_count"];
        }
            if(isset($json["data"]["result_detail"]["current_report_detail"]["loans_product_count"])){
        $quanjing[  'consfin_org_count2']=$json["data"]["result_detail"]["current_report_detail"]["consfin_org_count"];
        }
           if(isset($json["data"]["result_detail"]["current_report_detail"]["loans_max_limit"])){
         $quanjing[ 'loans_max_limit']=$json["data"]["result_detail"]["current_report_detail"]["loans_max_limit"];
        }
           if(isset($json["data"]["result_detail"]["current_report_detail"]["loans_credibility"])){
         $quanjing['loans_credibility2']=$json["data"]["result_detail"]["current_report_detail"]["loans_credibility"];
        }
         if(isset($json["data"]["result_detail"]["current_report_detail"]["consfin_max_limit"])){
          $quanjing['consfin_max_limit']=$json["data"]["result_detail"]["current_report_detail"]["consfin_max_limit"];
        }
          // 'consfin_max_limit'=>$json["data"]["result_detail"]["current_report_detail"]["consfin_max_limit"],
             if(isset($json["data"]["result_detail"]["current_report_detail"]["consfin_credibility"])){
          $quanjing['consfin_credibility']=$json["data"]["result_detail"]["current_report_detail"]["consfin_credibility"];
        }
          //consfin_credibility'=>$json["data"]["result_detail"]["current_report_detail"]["consfin_credibility"],
        if(isset($json["data"]["result_detail"]["current_report_detail"]["loans_credit_limit"])){
          $quanjing['loans_credit_limit']=$json["data"]["result_detail"]["current_report_detail"]["loans_credit_limit"];
        }
           //consfin_credibility'=>$json["data"]["result_detail"]["current_report_detail"]["consfin_credibility"],
        if(isset($json["data"]["result_detail"]["current_report_detail"]["loans_credit_limit"])){
          $quanjing['loans_credit_limit']=$json["data"]["result_detail"]["current_report_detail"]["loans_credit_limit"];
        }
         
         //'loans_credit_limit'=>$json["data"]["result_detail"]["current_report_detail"]["loans_credit_limit"],
           if(isset($json["data"]["result_detail"]["current_report_detail"]["loans_avg_limit"])){
          $quanjing['loans_avg_limit']=$json["data"]["result_detail"]["current_report_detail"]["loans_avg_limit"];
        }
         
      
        //'loans_avg_limit'=>$json["data"]["result_detail"]["current_report_detail"]["loans_avg_limit"],
                 if(isset($json["data"]["result_detail"]["behavior_report_detail"]["loans_count"])){
          $quanjing['loans_count']=$json["data"]["result_detail"]["behavior_report_detail"]["loans_count"];
        }
         
             //'loans_count'=>$json["data"]["result_detail"]["behavior_report_detail"]["loans_long_time"],
           if(isset($json["data"]["result_detail"]["behavior_report_detail"]["loans_long_time"])){
          $quanjing['loans_long_time']=$json["data"]["result_detail"]["behavior_report_detail"]["loans_long_time"];
        }
            //'loans_count'=>$json["data"]["result_detail"]["behavior_report_detail"]["loans_long_time"],
           if(isset($json["data"]["result_detail"]["behavior_report_detail"]["loans_long_time"])){
          $quanjing['loans_long_time']=$json["data"]["result_detail"]["behavior_report_detail"]["loans_long_time"];
        }
         //loans_long_time'=>$json["data"]["result_detail"]["behavior_report_detail"]["loans_long_time"],
                  if(isset($json["data"]["result_detail"]["behavior_report_detail"]["consfin_org_count"])){
        $quanjing[ 'consfin_org_count']=$json["data"]["result_detail"]["behavior_report_detail"]["consfin_org_count"];
        }
           //consfin_org_count'=>$json["data"]["result_detail"]["behavior_report_detail"]["consfin_org_count"],
                      if(isset($json["data"]["result_detail"]["behavior_report_detail"]["loans_cash_count"])){
          $quanjing[ 'loans_cash_count']=$json["data"]["result_detail"]["behavior_report_detail"]["loans_cash_count"];
        }
      //'loans_cash_count'=>$json["data"]["result_detail"]["behavior_report_detail"]["loans_cash_count"],
          if(isset($json["data"]["result_detail"]["behavior_report_detail"]["latest_six_month"])){
          $quanjing[ 'latest_six_month2']=$json["data"]["result_detail"]["behavior_report_detail"]["latest_six_month"];
        } 
           //latest_six_month2'=>$json["data"]["result_detail"]["behavior_report_detail"]["latest_six_month"],
          if(isset($json["data"]["result_detail"]["behavior_report_detail"]["history_fail_fee"])){
          $quanjing['history_fail_fee']=$json["data"]["result_detail"]["behavior_report_detail"]["history_fail_fee"];
        }
          //history_fail_fee'=>$json["data"]["result_detail"]["behavior_report_detail"]["history_fail_fee"],
         if(isset($json["data"]["result_detail"]["behavior_report_detail"]["latest_three_month"])){
          $quanjing['latest_three_month2']=$json["data"]["result_detail"]["behavior_report_detail"]["latest_three_month"];
        }  
         //'latest_three_month2'=>$json["data"]["result_detail"]["behavior_report_detail"]["latest_three_month"],
              if(isset($json["data"]["result_detail"]["behavior_report_detail"]["latest_one_month_fail"])){
           $quanjing['latest_one_month_fail']=$json["data"]["result_detail"]["behavior_report_detail"]["latest_one_month_fail"];
        }  
         //latest_one_month_fail'=>$json["data"]["result_detail"]["behavior_report_detail"]["latest_one_month_fail"],
         if(isset($json["data"]["result_detail"]["behavior_report_detail"]["latest_one_month"])){
          $quanjing['latest_one_month2']=$json["data"]["result_detail"]["behavior_report_detail"]["latest_one_month"];
        }  
         
        //latest_one_month2'=>$json["data"]["result_detail"]["behavior_report_detail"]["latest_one_month"],
          if(isset($json["data"]["result_detail"]["behavior_report_detail"]["loans_latest_time"])){
          $quanjing['loans_latest_time']=$json["data"]["result_detail"]["behavior_report_detail"]["loans_latest_time"];
        }  
          //loans_latest_time'=>$json["data"]["result_detail"]["behavior_report_detail"]["loans_latest_time"],
           if(isset($json["data"]["result_detail"]["behavior_report_detail"]["latest_one_month_suc"])){
          $quanjing['latest_one_month_suc']=$json["data"]["result_detail"]["behavior_report_detail"]["latest_one_month_suc"];
        } 
          //latest_one_month_suc'=>$json["data"]["result_detail"]["behavior_report_detail"]["latest_one_month_suc"],
               if(isset($json["data"]["result_detail"]["behavior_report_detail"]["history_suc_fee"])){
         $quanjing[ 'history_suc_fee']=$json["data"]["result_detail"]["behavior_report_detail"]["history_suc_fee"];
        }
          //history_suc_fee'=>$json["data"]["result_detail"]["behavior_report_detail"]["history_suc_fee"],
            if(isset($json["data"]["result_detail"]["behavior_report_detail"]["loans_org_count"])){
          $quanjing['loans_org_count']=$json["data"]["result_detail"]["behavior_report_detail"]["loans_org_count"];
        }  
          //loans_org_count'=>$json["data"]["result_detail"]["behavior_report_detail"]["loans_org_count"],
          if(isset($json["data"]["result_detail"]["behavior_report_detail"]["loans_org_count"])){
          $quanjing[ 'loans_credibility']=$json["data"]["result_detail"]["behavior_report_detail"]["loans_credibility"];
        }  
          //loans_credibility'=>$json["data"]["result_detail"]["behavior_report_detail"]["loans_credibility"],
         
         
          if(isset($json["data"]["result_detail"]["current_report_detail"]["consfin_product_count"])){
         $quanjing[ 'consfin_product_count']=$json["data"]["result_detail"]["current_report_detail"]["consfin_product_count"];
        }  
         
         
           if(isset($json["data"]["result_detail"]["behavior_report_detail"]["loans_score"])){
         $quanjing[ 'loans_score']=$json["data"]["result_detail"]["behavior_report_detail"]["loans_score"];
        }  
           //loans_score'=>$json["data"]["result_detail"]["behavior_report_detail"]["loans_score"],
                 if(isset($json["data"]["result_detail"]["behavior_report_detail"]["loans_overdue_count"])){
         $quanjing[ 'loans_overdue_count']=$json["data"]["result_detail"]["behavior_report_detail"]["loans_overdue_count"];
        }  
            // 'loans_overdue_count'=>$json["data"]["result_detail"]["behavior_report_detail"]["loans_overdue_count"],
                        if(isset($json["data"]["result_detail"]["behavior_report_detail"]["loans_settle_count"])){
          $quanjing['loans_settle_count']=$json["data"]["result_detail"]["behavior_report_detail"]["loans_settle_count"];
        }  
           //'loans_settle_count'=>$json["data"]["result_detail"]["behavior_report_detail"]["loans_settle_count"],
         if(isset($json["data"]["result_detail"]["apply_report_detail"]["latest_query_time"])){
          $quanjing['latest_query_time']=$json["data"]["result_detail"]["apply_report_detail"]["latest_query_time"];
        }  
           //latest_query_time'=>$json["data"]["result_detail"]["apply_report_detail"]["latest_query_time"],
         if(isset($json["data"]["result_detail"]["apply_report_detail"]["query_sum_count"])){
           $quanjing['query_sum_count']=$json["data"]["result_detail"]["apply_report_detail"]["query_sum_count"];
        }  
          
       //query_sum_count'=>$json["data"]["result_detail"]["apply_report_detail"]["query_sum_count"],
        if(isset($json["data"]["result_detail"]["apply_report_detail"]["apply_credibility"])){
          $quanjing[ 'apply_credibility']=$json["data"]["result_detail"]["apply_report_detail"]["apply_credibility"];
        }  
          // 'apply_credibility'=>$json["data"]["result_detail"]["apply_report_detail"]["apply_credibility"],
          if(isset($json["data"]["result_detail"]["apply_report_detail"]["query_org_count"])){
          $quanjing[  'query_org_count']=$json["data"]["result_detail"]["apply_report_detail"]["query_org_count"];
        }  
          // 'query_org_count'=>$json["data"]["result_detail"]["apply_report_detail"]["query_org_count"],
               if(isset($json["data"]["result_detail"]["apply_report_detail"]["latest_six_month"])){
          $quanjing[ 'latest_six_month']=$json["data"]["result_detail"]["apply_report_detail"]["latest_six_month"];
        }  
          //latest_six_month'=>$json["data"]["result_detail"]["apply_report_detail"]["latest_six_month"],
                     if(isset($json["data"]["result_detail"]["apply_report_detail"]["query_cash_count"])){
           $quanjing['query_cash_count']=$json["data"]["result_detail"]["apply_report_detail"]["query_cash_count"];
        } 
         //query_cash_count'=>$json["data"]["result_detail"]["apply_report_detail"]["query_cash_count"],
          if(isset($json["data"]["result_detail"]["apply_report_detail"]["apply_score"])){
          $quanjing['apply_score']=$json["data"]["result_detail"]["apply_report_detail"]["apply_score"];
        }  
          //  'apply_score'=>$json["data"]["result_detail"]["apply_report_detail"]["apply_score"],
      if(isset($json["data"]["result_detail"]["apply_report_detail"]["latest_three_month"])){
           $quanjing['latest_three_month']=$json["data"]["result_detail"]["apply_report_detail"]["latest_three_month"];
        }  
          //'latest_three_month'=>$json["data"]["result_detail"]["apply_report_detail"]["latest_three_month"],
           if(isset($json["data"]["result_detail"]["apply_report_detail"]["query_finance_count"])){
         $quanjing['query_finance_count']=$json["data"]["result_detail"]["apply_report_detail"]["query_finance_count"];
        }  
          //'query_finance_count'=>$json["data"]["result_detail"]["apply_report_detail"]["query_finance_count"],
            if(isset($json["data"]["result_detail"]["apply_report_detail"]["latest_one_month"])){
         $quanjing['latest_one_month']=$json["data"]["result_detail"]["apply_report_detail"]["latest_one_month"];
        }  
    
      $chaxun_quanjingid=db('chaxun_quanjing')->insertGetId($quanjing);
         $chaxun_quanjing=db('chaxun_quanjing')->where('id','=',$chaxun_quanjingid)->find();
         //dump($chaxun_quanjing);die;
       
       $yunyingshang=[
          'chaxunid'=>$chaxunid,
           'code'=>$json2["data"]["code"],
         'desc'=>$json2["data"]["desc"],
         'length'=>$json2["data"]["length"],
         'status'=>$json2["data"]["status"],
        
         ];
      $chaxun_yunyingshangid=db('chaxun_yunyingshang')->insertGetId($yunyingshang);
           $chaxun_yunyingshang=db('chaxun_yunyingshang')->where('id','=',$chaxun_yunyingshangid)->find();
         
         
      /** $yuqi=[
          'chaxunid'=>$chaxunid,
           'code'=>$json1["data"]["code"],
         'debt_amount'=>$json1["data"]["result_detail"]["debt_amount"],
         'order_count'=>$json1["data"]["result_detail"]["order_count"],
         'member_count'=>$json1["data"]["result_detail"]["member_count"],
        
         ];
      $yuqiid=db('chaxun_yuqi')->insertGetId($yuqi);
          $chaxun_yuqi=db('chaxun_yuqi')->where('id','=',$yuqiid)->find();
         //dump($chaxun_yuqi);die;
        // if(!empty($json1["data"]["result_detail"])){
      $num=count($json1["data"]["result_detail"]["details"]);
         //dump($num);die;
         if($num>0){
      for($i=0;$i<$num;$i++){
        
         $yuqilist=[
          'yuqiid'=>$yuqiid,
           'dates'=>$json1["data"]["result_detail"]["details"][$i]["date"],
         'amount'=>$json1["data"]["result_detail"]["details"][$i]["amount"],
         'count'=>$json1["data"]["result_detail"]["details"][$i]["count"],
         'settlement'=>$json1["data"]["result_detail"]["details"][$i]["settlement"],
        
         ];
       
        db('chaxun_yuqilist')->insertGetId($yuqilist);
      }
            }
          $chaxun_yuqilist=db('chaxun_yuqilist')->where('yuqiid','=',$yuqiid)->select();
          $this->assign("chaxunyuqilist", $chaxun_yuqilist);
        // }
        **/
     // dump($chaxun_yuqilist);die;
         //$data=[
          //'user_id'=> $json[''],
         //dump($trans_id12);dump($trans_id);dump($trans_id1);die;
          $arrayData4 = array(
              "member_id" => $member_id,
              "terminal_id" => $terminal_id,
              "trans_id" => $trans_id12,
              "trade_date" => $trade_date,
       "industry_type" => "A1", //根据当前商户的行业类型传参数
              "id_no" => $id_no,
              "id_name" => $id_name,
              "phone_no" => $phone_no,
              "versions" => $versions	
				
          );
        //dump($arrayData4);die;
          //dump($trans_id);dump($trans_id12);dump($trans_id1); dump($arrayData1);dump($arrayData2);dump($arrayData);dump($arrayData4);die;
          // *** 数据格式化***
          $data_content4 = str_replace("\\/", "/", json_encode($arrayData4));//转JSON
          //Log::LogWirte("====请求明文：" . $data_content);
          $pfxpath4 = ROOT_PATH. "framework/certificate/" . $config["merchant_private_key"];
          
          // if (!file_exists($pfxpath)) { //检查文件是否存在
          //     Log::LogWirte("=====私钥不存在");
          //     exit;
          // }
          $pfx_pwd4 = $config["pfxPwd"];
         // Log::LogWirte($pfxpath . "  " . $pfx_pwd);
          // **** 先BASE64进行编码再RSA加密 ***
          
          $encryptUtil4 = new EncryptUtil($pfxpath4, "", $pfx_pwd4, TRUE); //实例化加密类。
          
          $data_content4 = $encryptUtil4->encryptedByPrivateKey($data_content4);
          
          //Log::LogWirte("====加密串" . $data_content);
          $data_type4 = $config["dataType"];
          $PostArry4 = array(
              "member_id" => $member_id,
              "terminal_id" => $terminal_id,
              "data_type" => $data_type4,
              "data_content" => $data_content4);


          $PostArryJson4 = str_replace("\\/", "/", json_encode($PostArry4));//转JSON
          $request_url4 =$config["HJUrl"];//请求地址 $config[$urlType]; https://test.xinyan.com/product/archive/v3/overdue
          //Log::LogWirte("请求url：" . $request_url);
         $HttpCurlnew4    = new HttpCurl();
         // dump($trans_id);dump($trans_id12);dump($trans_id1); dump($arrayData1);dump($arrayData2);dump($arrayData);dump($arrayData4);die;
          $return4 = HttpCurl::Post($PostArry4, $request_url4);  //发送请求到服务器，并输出返回结果。
			$json4=json_decode($return4,true);
        //dump($json4);die;
         $heijing=[
          'chaxunid'=>$chaxunid,
           'code'=>$json4["data"]["code"],
         'loan_black'=>$json4["data"]["result_detail"]["loan_black"],
         'integrity_black'=>$json4["data"]["result_detail"]["integrity_black"],
         'cheat_black'=>$json4["data"]["result_detail"]["cheat_black"],
        
         ];
         $chaxun_heijingid=db('chaxun_heijing')->insertGetId($heijing);
          $chaxun_heijing=db('chaxun_heijing')->where('id','=',$chaxun_heijingid)->find();
         $this->assign("chaxunheijing", $chaxun_heijing);
           //dump($chaxun_heijing);die;
        // ];
         //return view($this->style . "credit/view");
         //
      $time=time();
            $this->assign("chaxunyunyingshang", $chaxun_yunyingshang);
       $op=substr_replace($user['mobile'],'****',3,4);
      $opcard=substr_replace($user['idcard'],'********',6,8);
      $this->assign("op", $op);
      $this->assign("opcard", $opcard);
         $this->assign("user", $user);
       $this->assign("chaxunquanjing", $chaxun_quanjing);
         
     // $this->assign("chaxunyuqi", $chaxun_yuqi);
        // $this->assign("chaxunyuqi", $chaxun_yuqi);
      $this->assign("json2", $json2);
       $this->assign("time", $time);
        return $this->fetch('view');
         
          //header("Location:../../public/show.php?resultMsg=" . $return);
      // }else{
       //  return $this->error('查询失败','index/index/index');
      // }
      }else{
        $time=$sun_chaxunss['dates'];
          $chaxun_heijing=db('chaxun_heijing')->where('chaxunid','=',$sun_chaxunss['id'])->order("id desc")->find();
        $chaxun_yunyingshang=db('chaxun_yunyingshang')->where('chaxunid','=',$sun_chaxunss['id'])->order("id desc")->find();
          $chaxun_quanjing=db('chaxun_quanjing')->where('chaxunid','=',$sun_chaxunss['id'])->order("id desc")->find();
         //$chaxun_quanjing=db('chaxun_quanjing')->where('id','=',$chaxun_quanjingid)->find();
         //$chaxun_yunyingshang=db('chaxun_yunyingshang')->where('id','=',$chaxun_yunyingshangid)->find();
          header("content-type:text/html;charset=utf8");
        
      $id=session('uid');
          $user=db('user')->where('id','=',$id)->where('status','=','1')->find();
         $op=substr_replace($user['mobile'],'****',3,4);
      $opcard=substr_replace($user['idcard'],'********',6,8);
      $this->assign("op", $op);
      $this->assign("opcard", $opcard);
         $this->assign("user", $user);
        $this->assign("chaxunheijing", $chaxun_heijing);
         $this->assign("chaxunyunyingshang", $chaxun_yunyingshang);
         $this->assign("chaxunquanjing", $chaxun_quanjing);
       $this->assign("time", $time);
        return $this->fetch('view');
       // dump($chaxun_quanjing);die;
        // $this->assign("chaxunheijing", $chaxun_heijing);
      //echo '1';
      }
     }else{
     	$this->redirect('index/index/index');
     }
      }
   public function credit1()
    {
      $zf=input('zf');
      //dump($zf);die;
       //if(!empty($zf)){
       header("content-type:text/html;charset=utf8");
          require_once  ROOT_PATH.'config/config.php';
          //Log::LogWirte("=================================");
      $id=session('uid');
          $user=db('user')->where('id','=',$id)->where('status','=','1')->find();
     //dump($user);die;
          $request_url = "https://test.xinyan.com/operators/v2/authInfo";//请求地址
          $member_id = $config["memberId"];
          $terminal_id = $config["terminalId"];
          $result = "";
          $arrayData = "";
          $PostArryJson = "";
          $urlType ="ZX-RadarUrl";
          $id_no = $user["idcard"];
        $idcard = $user["idcard"];
     $name = $user["names"];
     $mobile =$user["mobile"];
          $id_name = $user["names"];
          $bankcard_no ="";//bankcard_no
          $phone_no =$user["mobile"];
     
//dump($id_no);die;
          //Log::LogWirte("原始数据： id_no:".$id_no.",id_name:".$id_name.",bankcard_no:".$bankcard_no.",phone_no:".$phone_no);
           $Utils    = new Utils();
        //$id_no =Utils::md5_32($id_no);
          //$id_no=Utils::md5_32($id_no);
         // $id_name=Utils::md5_32($id_name);
          $bankcard_no=Utils::md5_32($bankcard_no);
         // $phone_no=Utils::md5_32($phone_no);
          //Log::LogWirte("32位小写MD5加密后数据： id_no:".$id_no.",id_name:".$id_name.",bankcard_no:".$bankcard_no.",phone_no:".$phone_no);
          $versions ="1.3.0";//versions
          $trans_id = Utils::create_uuid();//商户订单号
          $trade_date = Utils::trade_date();//交易时间

          $arrayData = array(
              "member_id" => $member_id,
              "terminal_id" => $terminal_id,
              "trans_id" => $trans_id."1",
              "trade_date" => $trade_date,
            "industry_type" =>"A1",
              "id_card" => $id_no,
              "name" => $id_name,
             // "bankcard_no" => $bankcard_no,
              "mobile" => $phone_no,
              //"industry_type" => "A1", //根据当前商户的行业类型传参数
             "type" => "ST_ON"

          );
     //dump( $arrayData);die;
          // *** 数据格式化***
          $data_content = str_replace("\\/", "/", json_encode($arrayData));//转JSON
          //Log::LogWirte("====请求明文：" . $data_content);
          $pfxpath = ROOT_PATH. "framework/certificate/" . $config["merchant_private_key"];
          
          // if (!file_exists($pfxpath)) { //检查文件是否存在
          //     Log::LogWirte("=====私钥不存在");
          //     exit;
          // }
          $pfx_pwd = $config["pfxPwd"];
         // Log::LogWirte($pfxpath . "  " . $pfx_pwd);
          // **** 先BASE64进行编码再RSA加密 ***
          
          $encryptUtil = new EncryptUtil($pfxpath, "", $pfx_pwd, TRUE); //实例化加密类。
          
          $data_content = $encryptUtil->encryptedByPrivateKey($data_content);
          
          //Log::LogWirte("====加密串" . $data_content);
          $data_type = $config["dataType"];
          $PostArry = array(
              "member_id" => $member_id,
              "terminal_id" => $terminal_id,
              "data_type" => $data_type,
              "data_content" => $data_content);


          $PostArryJson = str_replace("\\/", "/", json_encode($PostArry));//转JSON
          $request_url = $config["GHSUrl"];//GHSUrl   https://test.xinyan.com/operators/v2/authInfo
          //Log::LogWirte("请求url：" . $request_url);
         $HttpCurlnew    = new HttpCurl();
          $return = HttpCurl::Post($PostArry, $request_url);  //发送请求到服务器，并输出返回结果。


         // Log::LogWirte("请求返回参数：" . $return);
          if (empty($return)) {
              throw new Exception("返回为空，确认是否网络原因！");
          }
          //** 处理返回的报文 */
          //Log::LogWirte("结果：" . $return);
         $json=json_decode($return,true);
         //$data=[
          //'user_id'=> $json[''],
           // 'product_id'=>$da['id'],
        // ];
         //return view($this->style . "credit/view");
     dump($json);die;
        // return $json;
      //$time=time();
        // $this->assign("user", $user);
      // $this->assign("json", $json);
      // $this->assign("time", $time);
        //return $this->fetch('view');
         
          //header("Location:../../public/show.php?resultMsg=" . $return);
      // }
      }
  
  public function credit2()
    {
      $zf=input('zf');
      //dump($zf);die;
       //if(!empty($zf)){
       header("content-type:text/html;charset=utf8");
          require_once  ROOT_PATH.'config/config.php';
          //Log::LogWirte("=================================");
      $id=session('uid');
          $user=db('user')->where('id','=',$id)->where('status','=','1')->find();
          $request_url = "https://test.xinyan.com/operators/v2/authInfo";//请求地址
          $member_id = $config["memberId"];
          $terminal_id = $config["terminalId"];
          $result = "";
          $arrayData = "";
          $PostArryJson = "";
          $urlType ="ZX-RadarUrl";
          $id_no = $user["idcard"];
          $id_name = $user["names"];
          $bankcard_no ="";//bankcard_no
          $phone_no =$user["mobile"];
          //Log::LogWirte("原始数据： id_no:".$id_no.",id_name:".$id_name.",bankcard_no:".$bankcard_no.",phone_no:".$phone_no);
           $Utils    = new Utils();
        $id_no =Utils::md5_32($id_no);
          //$id_no=Utils::md5_32($id_no);
          $id_name=Utils::md5_32($id_name);
          $bankcard_no=Utils::md5_32($bankcard_no);
          $phone_no=Utils::md5_32($phone_no);
          //Log::LogWirte("32位小写MD5加密后数据： id_no:".$id_no.",id_name:".$id_name.",bankcard_no:".$bankcard_no.",phone_no:".$phone_no);
          $versions ="1.3.0";//versions
          $trans_id = Utils::create_uuid();//商户订单号
          $trade_date = Utils::trade_date();//交易时间

          $arrayData = array(
              "member_id" => $member_id,
              "terminal_id" => $terminal_id,
              "trans_id" => $trans_id,
              "trade_date" => $trade_date,
              "id_no" => $id_no,
              "id_name" => $id_name,
              "bankcard_no" => $bankcard_no,
              "phone_no" => $phone_no,
              "industry_type" => "A1", //根据当前商户的行业类型传参数

          );
          // *** 数据格式化***
          $data_content = str_replace("\\/", "/", json_encode($arrayData));//转JSON
          //Log::LogWirte("====请求明文：" . $data_content);
          $pfxpath = ROOT_PATH. "framework/certificate/" . $config["merchant_private_key"];
          
          // if (!file_exists($pfxpath)) { //检查文件是否存在
          //     Log::LogWirte("=====私钥不存在");
          //     exit;
          // }
          $pfx_pwd = $config["pfxPwd"];
         // Log::LogWirte($pfxpath . "  " . $pfx_pwd);
          // **** 先BASE64进行编码再RSA加密 ***
          
          $encryptUtil = new EncryptUtil($pfxpath, "", $pfx_pwd, TRUE); //实例化加密类。
          
          $data_content = $encryptUtil->encryptedByPrivateKey($data_content);
          
          //Log::LogWirte("====加密串" . $data_content);
          $data_type = $config["dataType"];
          $PostArry = array(
              "member_id" => $member_id,
              "terminal_id" => $terminal_id,
              "data_type" => $data_type,
              "data_content" => $data_content);


          $PostArryJson = str_replace("\\/", "/", json_encode($PostArry));//转JSON
          $request_url =$config["YQDAUrl"];//请求地址 $config[$urlType]; https://test.xinyan.com/product/archive/v3/overdue
          //Log::LogWirte("请求url：" . $request_url);
         $HttpCurlnew    = new HttpCurl();
          $return = HttpCurl::Post($PostArry, $request_url);  //发送请求到服务器，并输出返回结果。


         // Log::LogWirte("请求返回参数：" . $return);
          if (empty($return)) {
              throw new Exception("返回为空，确认是否网络原因！");
          }
          //** 处理返回的报文 */
          //Log::LogWirte("结果：" . $return);
         $json=json_decode($return,true);
         //$data=[
          //'user_id'=> $json[''],
           // 'product_id'=>$da['id'],
        // ];
         //return view($this->style . "credit/view");
   // dump($json);die;
          dump($json);die;
     // $time=time();
        // $this->assign("user", $user);
      // $this->assign("json", $json);
      // $this->assign("time", $time);
        //return $this->fetch('view');
         
          //header("Location:../../public/show.php?resultMsg=" . $return);
      // }
      }
      public function credit3()
    {
      $zf=input('zf');
      //dump($zf);die;
       //if(!empty($zf)){
       header("content-type:text/html;charset=utf8");
          require_once  ROOT_PATH.'config/config.php';
          //Log::LogWirte("=================================");
      $id=session('uid');
          $user=db('user')->where('id','=',$id)->where('status','=','1')->find();
          $request_url = "https://test.xinyan.com/operators/v2/authInfo";//请求地址
          $member_id = $config["memberId"];
          $terminal_id = $config["terminalId"];
          $result = "";
          $arrayData = "";
          $PostArryJson = "";
          $urlType ="ZX-RadarUrl";
          $id_no = $user["idcard"];
          $id_name = $user["names"];
          $bankcard_no ="";//bankcard_no
          $phone_no =$user["mobile"];
          //Log::LogWirte("原始数据： id_no:".$id_no.",id_name:".$id_name.",bankcard_no:".$bankcard_no.",phone_no:".$phone_no);
           $Utils    = new Utils();
        $id_no =Utils::md5_32($id_no);
          //$id_no=Utils::md5_32($id_no);
          $id_name=Utils::md5_32($id_name);
          $bankcard_no=Utils::md5_32($bankcard_no);
          $phone_no=Utils::md5_32($phone_no);
          //Log::LogWirte("32位小写MD5加密后数据： id_no:".$id_no.",id_name:".$id_name.",bankcard_no:".$bankcard_no.",phone_no:".$phone_no);
          $versions ="1.3.0";//versions
          $trans_id = Utils::create_uuid();//商户订单号
          $trade_date = Utils::trade_date();//交易时间

          $arrayData = array(
              "member_id" => $member_id,
              "terminal_id" => $terminal_id,
              "trans_id" => $trans_id,
              "trade_date" => $trade_date,
              "id_no" => $id_no,
              "id_name" => $id_name,
              "bankcard_no" => $bankcard_no,
              "phone_no" => $phone_no,
              "industry_type" => "A1", //根据当前商户的行业类型传参数

          );
       // dump( $arrayData);die;
          // *** 数据格式化***
          $data_content = str_replace("\\/", "/", json_encode($arrayData));//转JSON
          //Log::LogWirte("====请求明文：" . $data_content);
          $pfxpath = ROOT_PATH. "framework/certificate/" . $config["merchant_private_key"];
          
          // if (!file_exists($pfxpath)) { //检查文件是否存在
          //     Log::LogWirte("=====私钥不存在");
          //     exit;
          // }
          $pfx_pwd = $config["pfxPwd"];
         // Log::LogWirte($pfxpath . "  " . $pfx_pwd);
          // **** 先BASE64进行编码再RSA加密 ***
          
          $encryptUtil = new EncryptUtil($pfxpath, "", $pfx_pwd, TRUE); //实例化加密类。
          
          $data_content = $encryptUtil->encryptedByPrivateKey($data_content);
          
          //Log::LogWirte("====加密串" . $data_content);
          $data_type = $config["dataType"];
          $PostArry = array(
              "member_id" => $member_id,
              "terminal_id" => $terminal_id,
              "data_type" => $data_type,
              "data_content" => $data_content);


          $PostArryJson = str_replace("\\/", "/", json_encode($PostArry));//转JSON
          $request_url =$config["ZX-RadarUrl"];//请求地址 $config[$urlType]; https://test.xinyan.com/product/archive/v3/overdue
          //Log::LogWirte("请求url：" . $request_url);
         $HttpCurlnew    = new HttpCurl();
          $return = HttpCurl::Post($PostArry, $request_url);  //发送请求到服务器，并输出返回结果。


         // Log::LogWirte("请求返回参数：" . $return);
          if (empty($return)) {
              throw new Exception("返回为空，确认是否网络原因！");
          }
          //** 处理返回的报文 */
          //Log::LogWirte("结果：" . $return);
         $json=json_decode($return,true);
         //$data=[
          //'user_id'=> $json[''],
           // 'product_id'=>$da['id'],
        // ];
         //return view($this->style . "credit/view");
   // dump($json);die;
          dump($json);die;
     // $time=time();
        // $this->assign("user", $user);
      // $this->assign("json", $json);
      // $this->assign("time", $time);
        //return $this->fetch('view');
         
          //header("Location:../../public/show.php?resultMsg=" . $return);
      // }
      }
    public function credit4()
    {
      $zf=input('zf');
      //dump($zf);die;
       //if(!empty($zf)){
       header("content-type:text/html;charset=utf8");
          require_once  ROOT_PATH.'config/config.php';
          //Log::LogWirte("=================================");
      $id=session('uid');
          $user=db('user')->where('id','=',$id)->where('status','=','1')->find();
          $request_url = "https://test.xinyan.com/operators/v2/authInfo";//请求地址
          $member_id = $config["memberId"];
          $terminal_id = $config["terminalId"];
          $result = "";
          $arrayData = "";
          $PostArryJson = "";
          $urlType ="HJUrl";
          $id_no = $user["idcard"];
          $id_name = $user["names"];
          $bankcard_no ="";//bankcard_no
          $phone_no =$user["mobile"];
          //Log::LogWirte("原始数据： id_no:".$id_no.",id_name:".$id_name.",bankcard_no:".$bankcard_no.",phone_no:".$phone_no);
           $Utils    = new Utils();
        $id_no =Utils::md5_32($id_no);
          //$id_no=Utils::md5_32($id_no);
          $id_name=Utils::md5_32($id_name);
          $bankcard_no=Utils::md5_32($bankcard_no);
          $phone_no=Utils::md5_32($phone_no);
          //Log::LogWirte("32位小写MD5加密后数据： id_no:".$id_no.",id_name:".$id_name.",bankcard_no:".$bankcard_no.",phone_no:".$phone_no);
          $versions ="1.3.0";//versions
          $trans_id = Utils::create_uuid();//商户订单号
          $trade_date = Utils::trade_date();//交易时间
			
          $arrayData = array(
              "member_id" => $member_id,
              "terminal_id" => $terminal_id,
              "trans_id" => $trans_id,
              "trade_date" => $trade_date,
       "industry_type" => "A1", //根据当前商户的行业类型传参数
              "id_no" => $id_no,
              "id_name" => $id_name,
              "phone_no" => $phone_no,
              "versions" => $versions	
				
          );
       //dump( $arrayData);die;
          // *** 数据格式化***
          $data_content = str_replace("\\/", "/", json_encode($arrayData));//转JSON
          //Log::LogWirte("====请求明文：" . $data_content);
          $pfxpath = ROOT_PATH. "framework/certificate/" . $config["merchant_private_key"];
          
          // if (!file_exists($pfxpath)) { //检查文件是否存在
          //     Log::LogWirte("=====私钥不存在");
          //     exit;
          // }
          $pfx_pwd = $config["pfxPwd"];
         // Log::LogWirte($pfxpath . "  " . $pfx_pwd);
          // **** 先BASE64进行编码再RSA加密 ***
          
          $encryptUtil = new EncryptUtil($pfxpath, "", $pfx_pwd, TRUE); //实例化加密类。
          
          $data_content = $encryptUtil->encryptedByPrivateKey($data_content);
          
          //Log::LogWirte("====加密串" . $data_content);
          $data_type = $config["dataType"];
          $PostArry = array(
              "member_id" => $member_id,
              "terminal_id" => $terminal_id,
              "data_type" => $data_type,
              "data_content" => $data_content);


          $PostArryJson = str_replace("\\/", "/", json_encode($PostArry));//转JSON
          $request_url =$config['HJUrl'];//"https://test.xinyan.com/product/radar/v3/report";//$config["HJUrl"];//请求地址 $config[$urlType]; https://test.xinyan.com/product/archive/v3/overdue
          //Log::LogWirte("请求url：" . $request_url);
         $HttpCurlnew    = new HttpCurl();
          $return = HttpCurl::Post($PostArry, $request_url);  //发送请求到服务器，并输出返回结果。


         // Log::LogWirte("请求返回参数：" . $return);
          if (empty($return)) {
              throw new Exception("返回为空，确认是否网络原因！");
          }
          //** 处理返回的报文 */
          //Log::LogWirte("结果：" . $return);
         $json=json_decode($return,true);
         //$data=[
          //'user_id'=> $json[''],
           // 'product_id'=>$da['id'],
        // ];
         //return view($this->style . "credit/view");
   // dump($json);die;
          dump($json);die;
     // $time=time();
        // $this->assign("user", $user);
      // $this->assign("json", $json);
      // $this->assign("time", $time);
        //return $this->fetch('view');
         
          //header("Location:../../public/show.php?resultMsg=" . $return);
      // }
      }
}
