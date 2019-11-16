<?php
require_once ROOT_PATH.'framework/helpers/Logger.php';
require_once ROOT_PATH.'framework/helpers/HttpCurl.php';
//require_once ROOT_PATH.'framework/helpers/Utils.php';
include ROOT_PATH. 'framework/helpers/Utils.php';
require_once ROOT_PATH.'framework/libraries/EncryptUtil.php';
$config = array (
    //编码格式
    'charset' => "UTF-8",

    //商户公钥(暂不使用)
    'merchant_public_key' => "0i6VdAV2SUTMPvO0_pub.cer",

    //商户私钥
    'merchant_private_key' => "0i6VdAV2SUTMPvO0_pri.pfx",

    //商户号
    'memberId' => '8150722276',

    //终端号
    'terminalId' => '1811220012',
  'terminalId2' => '8150722276',
 // 'terminalId3' => '1811220012',

    //私钥密码
    'pfxPwd' => '0i6VdAV2SUTMPvO0',

    //数据类型
    'dataType' => 'json',

    //申请雷达
    'A-RadarUrl' => "https://test.xinyan.com/product/radar/v3/apply",

    //行为雷达
    'B-RadarUrl' => "https://test.xinyan.com/product/radar/v3/behavior",

    //信用现状
    'C-RadarUrl' => "https://test.xinyan.com/product/radar/v3/current",

    //全景雷达
    //'ZX-RadarUrl' => "https://test.xinyan.com/product/radar/v3/report",
	'ZX-RadarUrl' => "https://api.xinyan.com/product/radar/v3/report",

    //负面拉黑
    'FMLHUrl' => "https://test.xinyan.com/product/negative/v3/black",

    //负面洗白
    'FMXBUrl' => "https://test.xinyan.com/product/negative/v3/white",

    //共债档案
    'GZDAUrl' => "https://test.xinyan.com/product/archive/v1/totaldebt",

    //逾期档案
    //'YQDAUrl' => "https://test.xinyan.com/product/archive/v3/overdue",
	'YQDAUrl' => "https://api.xinyan.com/product/archive/v3/overdue",
 //黑镜
    'HJUrl' => "https://api.xinyan.com/product/radar/v3/queryblack",
	//运营商
	'GHSUrl'=>"https://api.xinyan.com/operators/v2/authInfo"
  //https://api.xinyan.com/operators/v2/authInfo
);