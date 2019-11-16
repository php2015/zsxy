<?php

namespace app\index\controller;


use think\Controller;

class Detailed extends Controller
{

    public static $config = [
        'url' => 'http://sandbox.shouxin168.net/api/lightning/product/query',//'https://guard.shouxin168.com/api/lightning/product/query',
        'aes' => 'Q0ymUIe1t26ZfG7s',//'Q2A3VkHowqNMdOP0',
        'institution_id' => 'd6518f1e-9270-11e9-890c-9801a79f5a77',//'67137fb4-0777-11ea-aa95-0242ac120003',
        'charset' => 'UTF-8',
        'sign_type' => 'RSA2',
        'version' => 'V1.0.1',
        'service' => 'personal_law_info',
        'mode' => 'mode_personal_law_info',
        //'public_key' => 'MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEA3PgggZllwepRByXqAeqrWU4Zx7m+0kvhcbEvpbGTez7PAj8uIJRKGnH2QfOkZHsRknamuBtJr9c2Js9yrrWbazNPFQrjekprroBSC7DO+EUHQqxZmV8ldqukT+C/UOHXavNH3FHnrYSgU7yj4I1+AnAzQq33xbSASE9DkTyoEzJnlRjnTBopidDVA+P/bxR9z6FBWv8M6P/VAcKamYGIwsx9AbsVhHDd8yOzMDJHOuJza4kuKFyjf/N+2Fwc7d6ZbKhRYITio7nerw6/XYrcWhAAyB6XhEp3wfCA5SpgCBWGbdvefiPsme5qqirCy2rlPn76Biev3wW2zhVWTw7HDwIDAQAB',
        //'private_key' => 'MIIEvQIBADANBgkqhkiG9w0BAQEFAASCBKcwggSjAgEAAoIBAQDc+CCBmWXB6lEHJeoB6qtZThnHub7SS+FxsS+lsZN7Ps8CPy4glEoacfZB86RkexGSdqa4G0mv1zYmz3KutZtrM08VCuN6SmuugFILsM74RQdCrFmZXyV2q6RP4L9Q4ddq80fcUeethKBTvKPgjX4CcDNCrffFtIBIT0ORPKgTMmeVGOdMGimJ0NUD4/9vFH3PoUFa/wzo/9UBwpqZgYjCzH0BuxWEcN3zI7MwMkc64nNriS4oXKN/837YXBzt3plsqFFghOKjud6vDr9ditxaEADIHpeESnfB8IDlKmAIFYZt295+I+yZ7mqqKsLLauU+fvoGJ6/fBbbOFVZPDscPAgMBAAECggEAEDe92wUxLLxP2iB0PlPE47cRuVDuqmybTUbd4mFYG7GOa/HLJuT7U1mN42VIaX+G2KMQtW57SAaZmNuc5Sm7EHEhmr/D1lPj91i/rM/7QMmAMOqJYPJUw5LxalNqdzs8HkNgwNDaGigjxEGSHYcE+pTVjk1KZB5NVAFNSjmTdGUZt4ATTlTeRV+DqPrF//rutx4I4prob5OSnqF55sua65zX2uqDuMFuUKygyBvvo/5JOWem/IHx8hiRvVbrhseRf+bhCP9/hKIOHm31bf9uYH7bKCxAJpM8ZL3LrPwR+dZlPvgV36jxe5K25sQXDSr5v8F2uYR8vkKMSc6rnsSngQKBgQDj+s7zZSUpDphLSm/hnvKo9KslJjC2hrMZsa2CnUQe5GT/9UR8s5PhijrrkJsEitMnF+BmU2RKQGhhpkDwoGDV8/nqK4IFS+oFGFK/L3gTx01iMsSNfWqCyQ4Wt8nZRod2npqVy2s1Ii5Z3mr/UsgDipQEP6YtudFVYLp0hXZbrwKBgQD4IL1nDczXD7kRhZeCrsPo+INcyMaC9Wf4nT/2cNLFWLjXOGfEZAPjSH/140BqLruskcbG+MrfXdpRW8wlFJdm5H1jfPCHVBvrBR0WAOUZQy4ltrNUSA1AOt7F/2gIaS+WY8f/lYMdM51yHTus1oTr/TGdKTjmKe0IhtnLdsRCoQKBgAIeVYf7e6HrCc1BTtLY6EZbp697sF4x2D434XXiQjzLQIkEXXOPM6OX5j5EJLyhEZ8+YI5y3e62tIGbyuSxiNTUJJFhgB7Oesk7VaGDLml4o6Zy9FKgRLocZi4d3RlQx3d5t9QGhOOEgsvA/luLCGLICeIUOVYZcPGLKZBloRjvAoGBALWvo4B2Rmujg6wk2hBC0AkjD209Rr5V28/btR5K9sqycIaHMtRHN+GREMGHqX8WwS1XgOno+wQbwOSaBx2Pul0JKhdTQPyWxeqNUALwnNCmtH/BDAbGy40gjkcFAbRG8SV54tRvMhaL2NnaNfwVCDeUqmOd75/5SytXMtsdGBCBAoGAN4yxQXEB40U32Ie7QipRuh7T1QutnQ1kwc4nfOgWe66ziwRCk0MLfbJO7MBC6YvvPpTkTPMp905lfVoBough3r5Y2NpiRpIP6v8jPwTMDxXeZqKngza6wOU0ub4nJaq+P1l73LtU6AipFquqOA3CMGhbKw3Mog4ynHEi0RZQTps=',
        'public_key' => 'MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEA0KpGcWs8E5zprE9TXYw52+rKxdthhwFZERzPAIIehKWL1GcDDNTRFmxRJDvjcIv+vhuaQfYZYQ+jC9b52b3E4pVdhfojNxJAd0PJWOjIEZXjhEpPlfiDp0TrjcKsO4ViwYu8A2UyV/b/9eZiipFx0LmWbN7ZAZjJD655p5kJPAPjU2pT6yy/slBqaJWIM5qbKq2qH4YOq47cEHYZ0a/cTJ3vGzlLVao5OVVhHg7T2pIYwqcoI1Aexx93L6zrDFGC0bCagDgDyzkeCgrMY+2PEq8ISiCOmLEb9hH05c8vNxUgj8olzBp/7J0PITjQOj/2GnR656xCLE36mfpZAv2abwIDAQAB',
        'private_key' => 'MIIEvgIBADANBgkqhkiG9w0BAQEFAASCBKgwggSkAgEAAoIBAQDQqkZxazwTnOmsT1NdjDnb6srF22GHAVkRHM8Agh6EpYvUZwMM1NEWbFEkO+Nwi/6+G5pB9hlhD6ML1vnZvcTilV2F+iM3EkB3Q8lY6MgRleOESk+V+IOnROuNwqw7hWLBi7wDZTJX9v/15mKKkXHQuZZs3tkBmMkPrnmnmQk8A+NTalPrLL+yUGpolYgzmpsqraofhg6rjtwQdhnRr9xMne8bOUtVqjk5VWEeDtPakhjCpygjUB7HH3cvrOsMUYLRsJqAOAPLOR4KCsxj7Y8SrwhKII6YsRv2EfTlzy83FSCPyiXMGn/snQ8hONA6P/YadHrnrEIsTfqZ+lkC/ZpvAgMBAAECggEBAMu65GpKi+6OTqwZC0kT503r0S0bA/7fdwm5OfbCFG/ofjzUkurNQpQFD7gz7N1vIjqVEqiCUscskEG4FFve58NemGB+GDHl1SFdAtKW/PgGg4wfTdMcP9Zp+R6Ays6WbhSQjPI3tM6j78czuFSYqypieRc1AWWIug5giJD1X0nCsX9ZZolr4tTk2RqykbiAVVmX1L2aezE/FLoyuqdZ8kWQXlJZS3ldOvECTy0fuV0vsJ/Mmm27efkONTlcBNzLr8blhuKmQbTC0IBeUoOiP7lXcK+2gYbf9JVEj56MBVYs0vyPNRB9gy/HPQlov05ZieIH87za3oTz5Vb+HTb9+CECgYEA+MGDiX04O7kAD5s5UXY5OeTgviilPdBm7JpsiezHDKN7S3oy/4P5GJ/eei8uVkCdrN01h35pMiDq/jkm0UihXJjaZ2+MHAhMM7l2AONT7MzAisRnnFUeyVYaCRhUJfwrl+ERBP2vHCkNa34OJmdL8XQf7Met+KcYSKLF8qLYFL8CgYEA1r3iA6RP/0F8XyQRL1aF9cJVQpWPwI/V6jLq+v/mhzlTdy5c4u9nMvhh+yjUPwZomQshby9MbRv0x0jdE9Hnn03lUcVJocZvowUBr34qIkC3x3LhwPC+rIa3/x9FSiN2fGP2lADAXDmnxt+6UlqX5wuhq/jIbT+R55zsrjWxdlECgYAvAlr6Q5i56JczW9E0LNRZtYAnT4USrmyU8AXs9rsTD14AgIJcuTL8zVF846etEx75CQDRrzjwCTp/eot0Z3ZfCl/TxkfDEGpeKAE937f/ex4z2zP9XjSoNcZLy7YzS3lthVHzEIHkH3nyw2qnJUQ7yAc0dvPQlrtHFsOzu8R7/wKBgD13dqVCOB/BV99HzJ93LbsN2CfJ9a7RvRJfZsFX1F2qfAimPbI7gpelXy5sHmy34eLEu9o+eKrWkLcmVRmiQKFpw5UnWo8y5KuN+FCKVXcefTxa1uHKR1nM6gfdpJC3G+g5GNB+cpEzc6HKUmPWSJq6ypkWChCzXIkmctzew6AxAoGBANq35XF3HxB7f/xmekO7kJBxT6TUZCMlOZlM5xvFkF4Uqsz1RGq8N1WTUzCDtlEHQknqwuB7HMC2LF0OHgjos+Zs05IhooXCXsVlkyxEgf+H8Po8WU//7bjnsJ3rxrHJxVFKVQrcX72nsMbYGkvyHxtoEnwMwF1bjqjgOqB3m+uR',
    ];


    public function index()
    {

        $data = [];
        /* $data['name'] = '王政';
        $data['bank_card'] = '6214832139976778';
        $data['ident_number'] = '422201199312235916';
        $data['service'] = 'bankcard_triple_elements_alpha_service';
        $data['mode'] = 'bankcard_triple_elements_alpha_mode';*/
//"{"resp_code":"SW0000","resp_data":{"data_list":[{"compatibility":0.99,"content":"34022119820****...","data_id":"c2019320213zhi1449_t20190326_pmaoqiulin","data_type":"exec_notice","sort_time":1553529600000,"sort_time_string":"2019年03月26日","title":"陈少博"},{"compatibility":0.4,"content":"民间借贷纠纷 被执行人:陈少博...","data_id":"c2017320281zhi6904_t20180815","data_type":"judgment","sort_time":1534262400000,"sort_time_string":"2018年08月15日","title":"王大壮与陈少博民间借贷纠纷执行裁定书"},{"compatibility":0.99,"content":"有履行能力而拒不履行生效法律文...","data_id":"c2017320281zhi6904_t20171208_pmaoqiulin","data_type":"dishonest_notice","sort_time":1512662400000,"sort_time_string":"2017年12月08日","title":"陈少博"},{"compatibility":0.99,"content":"34022119820****...","data_id":"c2017320281zhi6904_t20171208_pmaoqiulin","data_type":"exec_notice","sort_time":1512662400000,"sort_time_string":"2017年12月08日","title":"陈少博"},{"compatibility":0.99,"content":"买卖合同纠纷 基层法院 基层法...","data_id":"c2017320281minchu9776_t20170920","data_type":"court_session_notice","sort_time":1505836800000,"sort_time_string":"2017年09月20日","title":"陈少博"},{"compatibility":0.99,"content":"有履行能力而拒不履行生效法律文...","data_id":"c2017320213zhi2078_t20170615_pmaoqiulin","data_type":"dishonest_notice","sort_time":1497456000000,"sort_time_string":"2017年06月15日","title":"陈少博"},{"compatibility":0.99,"content":"违反财产报告制度 2 全部未履...","data_id":"c2016320281zhi3186_t20160405_pmaoqiulin","data_type":"dishonest_notice","sort_time":1459785600000,"sort_time_string":"2016年04月05日","title":"陈少博"},{"compatibility":0.99,"content":"3402211982****7...","data_id":"zb_c2016320281zhi3186_t20160405_pmaoqiulin","data_type":"exec_notice","sort_time":1459785600000,"sort_time_string":"2016年04月05日","title":"(2016)苏0281执0001号"},{"compatibility":0.99,"content":"金融借款合同纠纷 基层法院 被...","data_id":"4127459","data_type":"court_notice","sort_time":1449244800000,"sort_time_string":"2015年12月05日","title":"陈少博"}],"total":9},"resp_msg":"认证成功","resp_order":"008011573822573458207286","timestamp":"20191115205613"}
      //"{"resp_code":"SW0000","resp_data":{"data_list":[{"compatibility":0.99,"content":"34022119820****...","data_id":"c2019320213zhi1449_t20190326_pmaoqiulin","data_type":"exec_notice","sort_time":1553529600000,"sort_time_string":"2019年03月26日","title":"吴桐"},{"compatibility":0.4,"content":"民间借贷纠纷 被执行人:吴桐...","data_id":"c2017320281zhi6904_t20180815","data_type":"judgment","sort_time":1534262400000,"sort_time_string":"2018年08月15日","title":"王大壮与吴桐民间借贷纠纷执行裁定书"},{"compatibility":0.99,"content":"有履行能力而拒不履行生效法律文...","data_id":"c2017320281zhi6904_t20171208_pmaoqiulin","data_type":"dishonest_notice","sort_time":1512662400000,"sort_time_string":"2017年12月08日","title":"吴桐"},{"compatibility":0.99,"content":"34022119820****...","data_id":"c2017320281zhi6904_t20171208_pmaoqiulin","data_type":"exec_notice","sort_time":1512662400000,"sort_time_string":"2017年12月08日","title":"吴桐"},{"compatibility":0.99,"content":"买卖合同纠纷 基层法院 基层法...","data_id":"c2017320281minchu9776_t20170920","data_type":"court_session_notice","sort_time":1505836800000,"sort_time_string":"2017年09月20日","title":"吴桐"},{"compatibility":0.99,"content":"有履行能力而拒不履行生效法律文...","data_id":"c2017320213zhi2078_t20170615_pmaoqiulin","data_type":"dishonest_notice","sort_time":1497456000000,"sort_time_string":"2017年06月15日","title":"吴桐"},{"compatibility":0.99,"content":"违反财产报告制度 2 全部未履...","data_id":"c2016320281zhi3186_t20160405_pmaoqiulin","data_type":"dishonest_notice","sort_time":1459785600000,"sort_time_string":"2016年04月05日","title":"吴桐"},{"compatibility":0.99,"content":"3402211982****7...","data_id":"zb_c2016320281zhi3186_t20160405_pmaoqiulin","data_type":"exec_notice","sort_time":1459785600000,"sort_time_string":"2016年04月05日","title":"(2016)苏0281执0001号"},{"compatibility":0.99,"content":"金融借款合同纠纷 基层法院 被...","data_id":"4127459","data_type":"court_notice","sort_time":1449244800000,"sort_time_string":"2015年12月05日","title":"吴桐"}],"total":9},"resp_msg":"认证成功","resp_order":"008011573822713759567258","timestamp":"20191115205833"}
 //"{"resp_code":"SW0000","resp_data":{"data_list":[{"compatibility":0.99,"content":"34022119820****...","data_id":"c2019320213zhi1449_t20190326_pmaoqiulin","data_type":"exec_notice","sort_time":1553529600000,"sort_time_string":"2019年03月26日","title":"赵海艳"},{"compatibility":0.4,"content":"民间借贷纠纷 被执行人:赵海艳...","data_id":"c2017320281zhi6904_t20180815","data_type":"judgment","sort_time":1534262400000,"sort_time_string":"2018年08月15日","title":"王大壮与赵海艳民间借贷纠纷执行裁定书"},{"compatibility":0.99,"content":"有履行能力而拒不履行生效法律文...","data_id":"c2017320281zhi6904_t20171208_pmaoqiulin","data_type":"dishonest_notice","sort_time":1512662400000,"sort_time_string":"2017年12月08日","title":"赵海艳"},{"compatibility":0.99,"content":"34022119820****...","data_id":"c2017320281zhi6904_t20171208_pmaoqiulin","data_type":"exec_notice","sort_time":1512662400000,"sort_time_string":"2017年12月08日","title":"赵海艳"},{"compatibility":0.99,"content":"买卖合同纠纷 基层法院 基层法...","data_id":"c2017320281minchu9776_t20170920","data_type":"court_session_notice","sort_time":1505836800000,"sort_time_string":"2017年09月20日","title":"赵海艳"},{"compatibility":0.99,"content":"有履行能力而拒不履行生效法律文...","data_id":"c2017320213zhi2078_t20170615_pmaoqiulin","data_type":"dishonest_notice","sort_time":1497456000000,"sort_time_string":"2017年06月15日","title":"赵海艳"},{"compatibility":0.99,"content":"违反财产报告制度 2 全部未履...","data_id":"c2016320281zhi3186_t20160405_pmaoqiulin","data_type":"dishonest_notice","sort_time":1459785600000,"sort_time_string":"2016年04月05日","title":"赵海艳"},{"compatibility":0.99,"content":"3402211982****7...","data_id":"zb_c2016320281zhi3186_t20160405_pmaoqiulin","data_type":"exec_notice","sort_time":1459785600000,"sort_time_string":"2016年04月05日","title":"(2016)苏0281执0001号"},{"compatibility":0.99,"content":"金融借款合同纠纷 基层法院 被...","data_id":"4127459","data_type":"court_notice","sort_time":1449244800000,"sort_time_string":"2015年12月05日","title":"赵海艳"}],"total":9},"resp_msg":"认证成功","resp_order":"008011573823096993406341","timestamp":"20191115210456"}
        //"
        //$data['phone'] = '15000708848';
        //$data['service'] = 'personal_law_info';
         $data['ident_number'] = '360102199508140727';
         $data['mode'] = 'mode_personal_law_info';
         $data['name'] = '赵海艳';
         $data['phone'] = '13767056098';
         $data['service'] = 'personal_law_info';

        $params['institution_id'] =  self::$config['institution_id'];
        $params['charset'] =  self::$config['charset'];
        $params['sign_type'] =  self::$config['sign_type'];
        $params['sign'] = $this->privateEncrypt($this->getString($data), self::$config['private_key']);
        $params['timestamp'] = time();
        $params['version'] =  self::$config['version'];
        $params['biz_data'] = $this->encrypt(json_encode($data,JSON_UNESCAPED_UNICODE),self::$config['aes']);


        $result = $this->post($params,self::$config['url']);



        echo "<pre>";
        var_dump($result);die;


    }





    public function simpleHash($data){
        $stat = array();
        foreach($data as $key => $value){
            for($i=0; $i<10000; $i++){
                $str = substr(md5(microtime(true)), 0, 8);
                $p = $this->hash32($str) % 10;
                if(isset($stat[$p])){
                    $stat[$p]++;
                }else{
                    $stat[$p] = 1;
                }
            }
        }
        return $stat;
    }


   public function hash32($str)
    {
        return crc32($str) >> 16 & 0x7FFFFFFF;
    }







    /**加密
     * @param $text string 文本内容
     * @param $key string 秘钥 max 24
     * @return string
     */
    public function encrypts($text,$key)
    {

        $iv   = mcrypt_create_iv(mcrypt_get_iv_size(MCRYPT_TRIPLEDES,MCRYPT_MODE_ECB), MCRYPT_RAND);
        $text = $this->pkcs5Pad($text);
        $td = mcrypt_module_open(MCRYPT_3DES,'',MCRYPT_MODE_ECB,'');
        mcrypt_generic_init($td,$key,$iv);
        $data = base64_encode(mcrypt_generic($td, $text));
        mcrypt_generic_deinit($td);
        mcrypt_module_close($td);
        return $data;

    }


    /**
     * @param $text
     * @return string
     */
    private function pkcs5Pad($text)
    {
        $pad = 8 - (strlen($text) % 8);
        return $text . str_repeat(chr($pad), $pad);
    }


    /**
     * 解密
     * @param $sStr
     * @param $sKey
     * @param $iv
     * @return string
     */
    public function decrypt($sStr, $sKey, $iv) {
        $len_key = strlen($sKey);
        if($len_key <=16) {
            return openssl_decrypt($sStr, 'AES-128-ECB', $sKey, 0 , $iv);
        }elseif( $len_key >16 && $len_key <= 24 ){
            return openssl_decrypt($sStr, 'AES-192-ECB', $sKey, 0 , $iv);
        }else{
            return openssl_decrypt($sStr, 'AES-256-ECB', $sKey, 0 , $iv);
        }
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


    public function getString($data){
        $buff = '';
        foreach ($data as $k => $v) {
            $buff .= $v;
        }
        return $buff;
    }


    /**
     * 转换数组
     * @param $data
     * @return string
     */

    public function getSignContent($data)
    {
        $buff = '';
        foreach ($data as $k => $v) {
            $buff .= (!in_array($k, ['sign', 'customer_code']) && $v !== '' && !is_array($v)) ? $k . '=' . $v . '&' : '';
        }
        return trim($buff, '&');
    }


    /**
     * rsa 加密
     * @param $data
     * @param $key
     * @return string
     */

    public function privateEncrypt($data, $key)
    {
        $key = '-----BEGIN PRIVATE KEY-----' . PHP_EOL . wordwrap($key, 64, "\n", true) . PHP_EOL . '-----END PRIVATE KEY-----';
        $output = '';
        openssl_sign($data, $output, $key, OPENSSL_ALGO_SHA256);//

        return base64_encode($output);
    }


    /**
     *  curl 接口对接
     * @param $PostArry
     * @param $request_url
     * @return bool|string
     */
    public function Post($PostArry, $request_url)
    {
        $headers = ["Content-Type：multipart/form-data"];
        $postData = $PostArry;
        $postDataString = http_build_query($postData);//格式化参数
        $curl = curl_init(); // 启动一个CURL会话
        curl_setopt($curl, CURLOPT_URL, $request_url); // 要访问的地址
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE); // 对认证证书来源的检查
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE); // 从证书中检查SSL加密算法是否存在
        curl_setopt($curl, CURLOPT_POST, true); // 发送一个常规的Post请求
        curl_setopt($curl, CURLOPT_POSTFIELDS, $postDataString); // Post提交的数据包
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