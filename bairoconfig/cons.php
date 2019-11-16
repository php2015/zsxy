<?php

header("Content-Type: text/html; charset=UTF-8");

define("STATUS", "1");

$con= array (
  'configStr' => "",
   'titleStr' => "",
  'allDataArr' => true,
  'isDebug' => "",
  'account' => "mmapiStr",
  'password' => "mmapiStr",
  'apicode' => "3003045",
  'login_url' => "https://api.100credit.cn/bankServer2/user/login.action",
 
    /*  private static $configStr;   //配置信息
      private static $titleStr;    //表头
      private static $allDataArr = array();  //数据信息


      public static  $isDebug = true;

      public static $account = 'mmapiStr';
      public static $password = 'mmapiStr';
      public static $apicode = '3003045';
      public static $login_url = 'https://api.100credit.cn/bankServer2/user/login.action';
	  public static $querys = array(
		  //'huaxiang' => 'https://api.100credit.cn/huaxiang/v1/get_report',
		 // 'haina' => 'https://api.100credit.cn/HainaApi/data/getData.action',
		 // 'TrinityForceAPI' => 'https://api.100credit.cn/trinity_force/v1/get_data',
          'strategyApi'=>'https://api.100credit.cn/strategyApi/v1/hxQuery',
	  );
  */

);
$querys= array (
		  //'huaxiang' => 'https://api.100credit.cn/huaxiang/v1/get_report',
		 // 'haina' => 'https://api.100credit.cn/HainaApi/data/getData.action',
		 // 'TrinityForceAPI' => 'https://api.100credit.cn/trinity_force/v1/get_data',
          'strategyApi'=>'https://api.100credit.cn/strategyApi/v1/hxQuery',
);
$headerTitle = array(
      
      //三项之力调用
      // "TrinityForceAPI" => array(
      //    "TelCheck_s"//需要单独调用。
      // ),
      //单独调用
      // "haina" => array(
      //    "BankFourPro"//需要单独调用。
      // ),
      //打包调用
      // 'huaxiang' => array(
      //    "SpecialList_c"
      // )
      // 'insure' => array(
      // ),
      // //贷中
      // 'loan' => array(
      //    "Accountchange",
      //    "ApplyLoan",
      //    "SpecialList"
      // ),
      // 'dcp' => array(
      //    "Accountchange",
      //    "ApplyLoan",
      //    "SpecialList"
      // )
      'strategyApi' => array(
            "RuleExecution",
      )
);	
