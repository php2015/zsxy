<?php
namespace Corebairo;

use think\Controller;
use think\Db;
use think\Session;
use Utils\Utils;
use EncryptUtil\EncryptUtil;
use Helper\Helper;
use HttpCurl\HttpCurl;
use Log\Log;
use Util\Util;
use Con\Con;
require_once ROOT_PATH.'bairoconfig/com.bairong.api.class.php';
 
header("Content-Type: text/html; charset=UTF-8");
class Corebairo extends Controller{
  
	private $username;
	private $password;
	private $apicode;
	private $br_login_url;
	private $tokenid;
	private $ctitle = array();

	public $br_data_url;
	public $isLogin = false; //是否登录
	public $res_login;   
	public $userList;    //列表
	private $pass = true; //是否含有查询的必填字段 name,cell,id
	
	private static $_instance;


	function __construct($username,$password,$apicode,$querys,$headerTitle,$br_login_url = 'https://api.100credit.cn/bankServer2/user/login.action'){
      
       
		$this -> username = $username;
		$this -> password = $password;
		$this -> apicode = $apicode;

		$this -> br_login_url = $br_login_url;
		$this -> querys = $querys;
		$this -> headerTitle = $headerTitle;

		$this -> login();
	}

	public static function getInstance($username,$password,$apicode,$querys,$headerTitle){
             //对象方法不能访问普通的对象属性，所以$_instance需要设为静态的
             if (self::$_instance===null) {
 //                self::$_instance=new SqlHelper();//方式一    
                 self::$_instance=new self($username,$password,$apicode,$querys,$headerTitle);//方式二
             }
             return self::$_instance;
    }

	public function login(){ 
      require_once ROOT_PATH.'bairoconfig/cons.php';
		$postData = array(
			"userName" => $this -> username,
			"password" => $this -> password,
			"apiCode" => $this -> apicode
			);

		//echo $this -> br_login_url."<br />";
		$Util    = new Util();
		$this -> res_login = Util::post($this -> br_login_url,$postData);
		if($this -> res_login){
			$loginData = json_decode($this -> res_login,true);
			//var_dump($loginData);
			if($loginData['code'] == 0){
				$this -> isLogin = true;
				$this -> tokenid = $loginData['tokenid'];      //取得tokenid
			}else{
				$this -> isLogin = false;
			}
			
		}
	}

	function query($targetList){
		if(!($this -> pass)){return;}
        $headerTitle = $this -> headerTitle;

        $this -> pushTargetList($targetList);
		//正式环境套餐字段固定
		if(STATUS == 1){
			//$this -> headerTitle = $headerTitle;
		}

		$arr_querys = $this -> querys;

		if(is_array($headerTitle)){
         
			foreach ($headerTitle as $key => $arr) {
				$temp_res_arr=$this -> post($key,$arr_querys[$key],$arr);
			}
          
		}
		return $temp_res_arr;
	}

	//查询数据接口
	function post($filename,$url,$titles){
		//未登录先登录
     
		if(!$this -> res_login){
			$this -> login();
			return;
		}

		$arr = array();     //查询结果
		$arr2 = array();     
		$arr_pre1 = array(); //存储查询参数
		$arr_pre2 = array(); //存储默认flag 

		$tid = $this -> tokenid;
		$apicode = $this -> apicode;
		//$url = $this -> br_data_url;
		$url = $url;
		$data = $this -> userList;

		$headKey = array();
		
		if(STATUS == 2){
			$meal = '';
		}else{
			//$meal = join(',',$this -> headerTitle);
			$meal = join(',',$titles);
		}

		$reserveTitle = array(
			'code',
			'swift_number',
			//'Flag'
			);

		foreach ($data as $key => $value) {
			if(STATUS == 2){
				$line_num = $value['line_num'];
			}

			foreach ($value as $key1 => $value1) {
				if($key1 == 'name'){
					$data[$key][$key1] = $value1;
					}

				if($key1 == 'mail'){
					if($filename == 'huaxiang'){
						$data[$key][$key1] = array($value1);
					}else{
						$data[$key][$key1] = $value1;
					}
					
				}

				if($key1 == 'cell'){
					if($filename == 'huaxiang'){
						$data[$key][$key1] = array($value1);
					}else{
						$data[$key][$key1] = $value1;
					}
				}

			}


			$data[$key]['meal'] = $meal;


			$postData = array(
				'tokenid' => $tid,
	            'apiCode' => $apicode,
	            'jsonData' => json_encode($data[$key]),
	            'checkCode' => md5(json_encode($data[$key]).md5($apicode.$tid))
			);

			
			//查询返回值 
			//json string 格式
			$temp_res = Util::post($url,$postData);
			$temp_res_arr = json_decode($temp_res,true);

			//重新登录
			if($temp_res_arr['code'] == 100004){
				$this -> login();
				$this -> mapping();
				return;
			}

			
			/**if(1==1){
				echo '<h3>post 参数</h3>';
				var_dump($postData);
				echo '<h3>post 返回值</h3>';
              echo '<h3>'.$url.'</h3>';
				var_dump($temp_res_arr);
			}**/

		}

		return $temp_res;


	}

	private function validator($arr){
		return $this -> pass;
	}

	private function pushTargetList($targetList){
		if($targetList && is_array($targetList)){
			if($this ->validator($targetList)){
				$this -> userList = $targetList;
			}
		}
	}

}
