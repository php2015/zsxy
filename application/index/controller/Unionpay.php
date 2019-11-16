<?php

namespace app\index\controller;


use think\Controller;

class Unionpay extends Controller{



    public static $config = [
        'appId' => 'M3BH563XBN373G6N6XTJJYO7K7OI7LHK',
        'identifier' => '2411',
        'ip' => '192.168.8.60',
        'url' => 'http://192.168.8.60/repoweb/api/v2/UPACommonCardAuthInfoNonstandardServer.do'
    ];
    
    //6217003810052474569  6228271721258768971
    
    public function li(){
    	//['idcard' => '421222199212061235', 'names'=>'测试', 'mobile'=>'15000708869','bank'=>'6215581110004090751']
    	$a = $this->index(['idcard' => '341125199810054338', 'names'=>'测试', 'mobile'=>'15000708869','bank'=>'6212261402040598000']);
    	echo "<pre>";
    	var_dump($a);die;
    }
    
    public function index($params){
    	 $data = [];
         $data['debugMode'] = 0;
         $data['md5Flag'] = 0;
         $data['developmentId'] = self::$config['appId'];
         $data['resourceId'] = self::$config['identifier'];
         $query = ['reqParam'=>''.$params['bank'].':'.$params['names'].':'.$params['idcard'].':'.$params['mobile'].'::1','outputType'=>'json'];
    	 $key = $this->getBytes(json_encode($query));
    	 $public_key = $this->getBytes(hex2bin('E4C8C464AB8299A03E711FC0FE70E6E3'));
    	 $data['query'] = $this->encrypt($this->toStr($key),$this->toStr($public_key));
    	 $data_json = $this->Post($data,self::$config['url']);
    	 $bank = json_decode($data_json,true);
    	 if(isset($bank['data']) && !empty($bank['data'])){
    	 	$result = $this->decrypt($bank['data'],$this->toStr($public_key));
    	 }else{
    	 	if(isset($bank['error_code']) && $bank['error_code'] == 10015){
    	 		return self::index(['bank'=>$params['bank'],'names'=>$params['names'],'idcard'=>$params['idcard'],'mobile'=>$params['mobile']]);
    	 	}else{
    	 		$result = $data_json;
    	 	}
    	 }
         return $result;
    }
    
 
    
    /**
     *  将字符串转换成byte[]格式
     * 
     */
     public function getBytes($str) {
			$len = strlen($str);
			$bytes = array();
			for($i=0;$i<$len;$i++) {
				if(ord($str[$i]) >= 128){
					$byte = ord($str[$i]) - 256;
			}else{
				$byte = ord($str[$i]);
			}
			$bytes[] = $byte ;
		 }
			return $bytes;
		}
 
 
	/**
	 *  将byte 格式转换成字符串
	 */
 	public function toStr($bytes) {
			 $str = '';
			 foreach($bytes as $ch) {
				 $str .= chr($ch);
			 }
			return $str;
	}
    
    
    /**
     * ECB/PKCS5Padding
     * 加密  
     */
    
    public function encrypt($input, $key) {

    	$size = mcrypt_get_block_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_ECB);

    	$input = $this->pkcs5_pad($input, $size);

		$td = mcrypt_module_open(MCRYPT_RIJNDAEL_128, '', MCRYPT_MODE_ECB, '');

    	$iv = mcrypt_create_iv (mcrypt_enc_get_iv_size($td), MCRYPT_RAND);

    	mcrypt_generic_init($td, $key, $iv);

    	$data = mcrypt_generic($td, $input);

    	mcrypt_generic_deinit($td);

    	mcrypt_module_close($td);
    	
    	return base64_encode($data);

    }
    
    

    private function pkcs5_pad ($text, $blocksize) {

        $pad = $blocksize - (strlen($text) % $blocksize);

        return $text . str_repeat(chr($pad), $pad);

    }

   

	/**
	 *  解密
	 *  
	 */ 
    public function decrypt($sStr, $sKey) {
    	
        $decrypted = mcrypt_decrypt(MCRYPT_RIJNDAEL_128,$sKey,base64_decode($sStr),MCRYPT_MODE_ECB);
        
        $dec_s = strlen($decrypted);

        $padding = ord($decrypted[$dec_s-1]);

        $decrypted = substr($decrypted, 0, -$padding);

        return $decrypted;

    }  
    
    
 
 
     /**
     *  curl 接口对接
     * @param $PostArry
     * @param $request_url
     * @return bool|string
     */
    public function Post($PostArry, $request_url)
    {
    	$headers = ["Content-Type: application/json"];
        //$postDataString = http_build_query($PostArry);//格式化参数
        $curl = curl_init(); // 启动一个CURL会话
        curl_setopt($curl, CURLOPT_URL, $request_url); // 要访问的地址
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE); // 对认证证书来源的检查
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE); // 从证书中检查SSL加密算法是否存在
        curl_setopt($curl, CURLOPT_POST, true); // 发送一个常规的Post请求
        curl_setopt($curl, CURLOPT_POSTFIELDS,json_encode($PostArry)); // Post提交的数据包
         //header头信息
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($curl, CURLOPT_TIMEOUT, 60); // 设置超时限制防止死循环返回
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $tmpInfo = curl_exec($curl); // 执行操作
        if (curl_errno($curl)) {
            $tmpInfo = curl_error($curl);//捕抓异常
        }
       
        curl_close($curl); // 关闭CURL会话
        return $tmpInfo; // 返回数据
    }




}