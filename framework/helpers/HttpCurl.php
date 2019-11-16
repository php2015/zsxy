<?php
/**
 * Created by PhpStorm.
 * User: 淘气
 * Date: 2017/2/4
 * Time: 12:23
 */
namespace HttpCurl;
class HttpCurl
{
    /**
     * 模拟POST与GET请求
     *
     * Examples:
     * ```
     * HttpCurl::request('http://example.com/', 'post', array(
     *  'user_uid' => 'root',
     *  'user_pwd' => '123456'
     * ));
     *
     * HttpCurl::request('http://example.com/', 'post', '{"name": "peter"}');
     *
     * HttpCurl::request('http://example.com/', 'post', array(
     *  'file1' => '@/data/sky.jpg',
     *  'file2' => '@/data/bird.jpg'
     * ));
     *
     * // windows
     * HttpCurl::request('http://example.com/', 'post', array(
     *  'file1' => '@G:\wamp\www\data\1.jpg',
     *  'file2' => '@G:\wamp\www\data\2.jpg'
     * ));
     *
     * HttpCurl::request('http://example.com/', 'get');
     *
     * HttpCurl::request('http://example.com/?a=123', 'get', array('b'=>456));
     * ```
     *
     * @param string $url [请求地址]
     * @param string $type [请求方式 post or get]
     * @param bool|string|array $data [传递的参数]
     * @param array $header [可选：请求头] eg: ['Content-Type:application/json']
     * @param int $timeout [可选：超时时间]
     *
     * @return array($body, $header, $status, $errno, $error)
     * - $body string [响应正文]
     * - $header string [响应头]
     * - $status array [响应状态]
     * - $errno int [错误码]
     * - $error string [错误描述]
     */
    public static function request($url, $type, $data = false, $header = [], $timeout = 0)
    {
        $cl = curl_init();
        // 兼容HTTPS
        if (stripos($url, 'https://') !== FALSE) {
            curl_setopt($cl, CURLOPT_SSL_VERIFYPEER, 0);
            curl_setopt($cl, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($cl, CURLOPT_SSLVERSION, 1);
        }
        // 设置返回内容做变量存储
        curl_setopt($cl, CURLOPT_RETURNTRANSFER, 1);
        // 设置需要返回Header
        curl_setopt($cl, CURLOPT_HEADER, true);
        // 设置请求头
        // 设置请求头
        if (count($header) > 0) {
            curl_setopt($cl, CURLOPT_HTTPHEADER, $header);
        }
        // 设置需要返回Body
        curl_setopt($cl, CURLOPT_NOBODY, 0);
        // 设置超时时间
        if ($timeout > 0) {
            curl_setopt($cl, CURLOPT_TIMEOUT, $timeout);
        }
        // POST/GET参数处理
        $type = strtoupper($type);
        if ($type == 'POST') {
            curl_setopt($cl, CURLOPT_POST, true);
            // convert @ prefixed file names to CurlFile class
            // since @ prefix is deprecated as of PHP 5.6
            if (class_exists('\CURLFile') && is_array($data)) {
                foreach ($data as $k => $v) {
                    if (is_string($v) && strpos($v, '@') === 0) {
                        $v = ltrim($v, '@');
                        $data[$k] = new \CURLFile($v);
                    }
                }
            }
            curl_setopt($cl, CURLOPT_POSTFIELDS, $data);
        }
        if ($type == 'GET' && is_array($data)) {
            if (stripos($url, "?") === FALSE) {
                $url .= '?';
            }
            $url .= http_build_query($data);
        }
        curl_setopt($cl, CURLOPT_URL, $url);
        // 读取获取内容
        $response = curl_exec($cl);

        // 读取状态
        $status = curl_getinfo($cl);
        // 读取错误号
        $errno  = curl_errno($cl);
        // 读取错误详情
        $error = curl_error($cl);
        // 关闭Curl
        curl_close($cl);
        if ($errno == 0 && isset($status['http_code'])) {
            $header = substr($response, 0, $status['header_size']);
            $body = substr($response, $status['header_size']);
            return array($body, $header, $status, 0, '');
        } else {
            return array('', '', $status, $errno, $error);
        }
    }


    public static function Post($PostArry,$request_url){
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

	public static function Header($PostArry,$array,$url){

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


  public static function Get($PostArry,$array,$url){

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

   public static function request_post($headers,$url = '', $post_data = array()) {
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


}