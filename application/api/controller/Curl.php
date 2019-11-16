<?php
namespace app\api\controller;
use think\Controller;
use think\Db;
use think\Request;
use think\Session;
class Curl extends Controller
{
  //$pid 商品id
  //$price 商品价格
  public function idcard()
  {
    header("content-type:text/html;charset=utf-8");         //设置编码
    $idcard=input('idcard');
   // $idcard='421126199512026319';
    $host = "https://fediscern.market.alicloudapi.com";
    $path = "/baseinfo";
    $method = "GET";
    $appcode = "d31f6932e6524059945bfdaccac9e03c";
    $headers = array();
    array_push($headers, "Authorization:APPCODE " . $appcode);
    $querys = "idCard=".$idcard."";
    $bodys = "";
    $url = $host . $path . "?" . $querys;

    $curl = curl_init();
    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $method);
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($curl, CURLOPT_FAILONERROR, false);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_HEADER, true);
    if (1 == strpos("$".$host, "https://"))
    {
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
    }
    $out_put = curl_exec($curl);
    
    //echo $out_put;
    $substr = $this->get_between($out_put, "{", "}");
    $json="{".$substr."}";
    $array = json_decode($json,true);
   // dump($out_put);dump($array);
   // die;
    //201成功
    //202失败
    if($array['status'] == '201'){
        return 1;
    }else{
      return 0;
    }
    
  }
  function get_between($input, $start, $end) {
    $substr = substr($input, strlen($start)+strpos($input, $start),(strlen($input) - strpos($input, $end))*(-1));
    return $substr;
  }
}
