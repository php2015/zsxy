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
    'merchant_public_key' => "bfkey_8000013189.cer",

    //商户私钥
    'merchant_private_key' => "8000013189_pri.pfx",

    //商户号
    'memberId' => '8000013189',

    //终端号
    'terminalId' => '8000013189',

    //私钥密码
    'pfxPwd' => '217526',

    //数据类型
    'dataType' => 'json',

    //申请雷达
    'A-RadarUrl' => "https://test.xinyan.com/product/radar/v3/apply",

    //行为雷达
    'B-RadarUrl' => "https://test.xinyan.com/product/radar/v3/behavior",

    //信用现状
    'C-RadarUrl' => "https://test.xinyan.com/product/radar/v3/current",

    //全景雷达
    'ZX-RadarUrl' => "https://test.xinyan.com/product/radar/v3/report",

    //负面拉黑
    'FMLHUrl' => "https://test.xinyan.com/product/negative/v3/black",

    //负面洗白
    'FMXBUrl' => "https://test.xinyan.com/product/negative/v3/white",

    //共债档案
    'GZDAUrl' => "https://test.xinyan.com/product/archive/v1/totaldebt",

    //逾期档案
    'YQDAUrl' => "https://test.xinyan.com/product/archive/v3/overdue",
   //黑镜
    'HJUrl' => "https://test.xinyan.com/product/radar/v3/queryblack",//https://test.xinyan.com/product/radar/v3/queryblack
    'GHSUrl' => "https://test.xinyan.com/operators/v2/authInfo"


);