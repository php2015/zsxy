<?php
namespace app\index\controller;
use think\Controller;
use think\Image;
use think\Db;
use think\Request;//首先引入 Request 文件；
class Posturl extends Controller
{
        public function index()
    {
        header("content-type:text/html;charset=utf8");

         $appid="YL9SiL2TeabDRAja";
         $appSecurity="YL9SiL2TeabDRAja0LV1XQdzUrg9Nolw";
         $timestamp=time();
         //app_id={app_id}&app_security={app_security}&timestamp={tim estamp} 进行 md5 加密计算即可得到 sign 签名。 
         $one='app_id='.$appid.'&app_security='.$appSecurity.'&timestamp='.$timestamp;
        // $token=session('token');
       // if(empty($token)){
        
         $sign=md5($one);
          $PostArry2 = array(
              "app_id" => $appid,
              "timestamp" => $timestamp,
              "sign" => $sign
              );
           $request1_url="https://b.shumaidata.com/api/authorize";
          $return1 = $this->Post($PostArry2, $request1_url);  //发送请求到服务器，并输出返回结果。
        $json=json_decode($return1,true);
        //dump($json);die;
          $token=$json['result']['token'];


        $url = 'https://b.shumaidata.com/api/v1/carrier/task';
        $post_data['app_id']       = 'YL9SiL2TeabDRAja';
        $post_data['account']      = '13437155623';
        $post_data['password'] = '797735';
        $post_data['idCard']    = '421126199512026319';
        $post_data['realName']    = '王升升';
        $post_data['notifyUrl']    = '';
        //$token="90cc208298a8e26754fc18c4e69902985c4962cb0cf232b4825c1ece";
        $content="application/x-www-form-urlencoded";
        $headers=array(
              'token:'.$token,
              'content-type:'.$content
        );
        $res = $this->request_post($headers,$url, $post_data);   
        $gr1=json_decode($res);
        dump($headers);dump($url);dump($post_data);
        dump(json_decode($gr1));die;
    }
    //.提交验证码
     function code(){//$app_id,$tradeNo,$headers
        $token="90cc208298a8e26754fc18c4e69902985c68b9660cf234aacce2c72c";
        $content="application/x-www-form-urlencoded";
        $headers=array(
              'token:'.$token,
              'content-type:'.$content
        );
       // $code_data['app_id']=$app_id;
        //$code_data['tradeNo']=$tradeNo;
        $url = 'https://b.shumaidata.com/api/v1/carrier/submitCode';
        $code_data['app_id']= 'YL9SiL2TeabDRAja';
        $code_data['tradeNo']='201902170931188508454214';
        $code_data['code']='576140';
        $res = $this->request_post($headers,$url, $code_data);   
        $gr1=json_decode($res);
        dump($headers);dump($url);dump($code_data);
        dump(json_decode($gr1));die;
    }
     //.查询通话
     function tonghua(){//$app_id,$tradeNo,$headers
        header("content-type:text/html;charset=utf8");
        $token="90cc208298a8e26754fc18c4e69902985c6cb9f70cf234aacce2dc32";
        $content="application/x-www-form-urlencoded";
        $headers=array(
              'token:'.$token,
              'content-type:'.$content
        );
       // $code_data['app_id']=$app_id;
        //$code_data['tradeNo']=$tradeNo;
        $url = 'https://b.shumaidata.com/api/v1/carrier/report/info';
        $tonghua_data['app_id']= 'YL9SiL2TeabDRAja';
         $tonghua_data['mobile']='18872695647';
         $tonghua_data['idcard']='421126199512026319 ';
         $tonghua_data['name']='王升';
       // $tonghua_data['month']='2019-01';
        $tonghua_data['orderNo']='201902201022478348703004';
        $res = $this->Get($tonghua_data,$headers,$url);   
        $gr1=json_decode($res);
        dump($headers);dump($url);dump($tonghua_data);
        dump(json_decode($gr1));die;
    }
     //.查询采集完成
     function caiji(){//$app_id,$tradeNo,$headers
        header("content-type:text/html;charset=utf8");
        $token="90cc208298a8e26754fc18c4e69902985c6cb9f70cf234aacce2dc32";
        $content="application/x-www-form-urlencoded";
        $headers=array(
              'token:'.$token,
              'content-type:'.$content
        );
       // $code_data['app_id']=$app_id;
        //$code_data['tradeNo']=$tradeNo;
        $url = 'https://b.shumaidata.com/api/v1/carrier/getTaskStatus';
        $tonghua_data['app_id']= 'YL9SiL2TeabDRAja';
         //$tonghua_data['mobile']='18872695647';;
        $tonghua_data['tradeNo']='201902201022478348703004';
        $res = $this->Get($tonghua_data,$headers,$url);   
        $gr1=json_decode($res);
        dump($headers);dump($url);dump($tonghua_data);
        dump(json_decode($gr1));die;
    }
    //.提交验证码
     function chaxun(){//$app_id,$tradeNo,$headers
        header("content-type:text/html;charset=utf8");
        $token="90cc208298a8e26754fc18c4e69902985c49776d0cf27e08060a4b1e";
        $content="application/x-www-form-urlencoded";
        $headers=array(
              'token:'.$token,
              'content-type:'.$content
        );
       // $code_data['app_id']=$app_id;
        //$code_data['tradeNo']=$tradeNo;
        $url = 'https://b.shumaidata.com/api/v1/carrier/getTaskStatus';
        $chaxun_data['app_id']= 'YL9SiL2TeabDRAja';
        $chaxun_data['tradeNo']='201901241749140152738487';
        $res = $this->Get($chaxun_data,$headers,$url);   
        $gr1=json_decode($res);
        dump($headers);dump($url);dump($chaxun_data);
        dump(json_decode($gr1));die;
    }

    //post传值方法
         function request_post($headers,$url = '', $post_data = array()) {
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
    function Post($PostArry,$request_url){
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
    function Header($PostArry,$array,$url){

      $headers = $array;
      $idCard="421181199110045597";
      //$idCards= json_encode($idCard);//格式化参数
      //dump($idCard);die;
      $urls="https://b.shumaidata.com/api/v1/carrier/task?app_id=YL9SiL2TeabDRAja&account=18062677701&password=123456&idCard=".$idCard."&realName=刘伟祥&notifyUrl";
       //$posturls= json_encode($urls);//格式化参数
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
    curl_setopt($curl, CURLOPT_URL, $urls);
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
 
}