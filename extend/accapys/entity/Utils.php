<?php

namespace accapys\entity;

class Utils{

    //对象转数组
    public static function object_array($array) {
        if(is_object($array)) {
            $array = (array)$array;
        } if(is_array($array)) {
            foreach($array as $key=>$value) {
                $array[$key] = self::object_array($value);
            }
        }
        return $array;
    }

    //数组转字符串
    public static function arr2str($arr)
    {
        $ret = "";
        ksort($arr);
        while (list($k, $v) = each($arr))
        {
            if($v != null && $v != ""){
                $tmp = "$k=" . "$v&";
                $ret .= $tmp;
            }
        }
        $ret=substr($ret, 0,strlen($ret)-1);
        return $ret;
    }

    //生成唯一uuid
    public static function guid()
    {
        mt_srand((double) microtime() * 10000); // optional for php 4.2.0 and up.
        $charid = strtoupper(md5(uniqid(rand(), true)));
        $uuid = substr($charid, 0, 8) . substr($charid, 8, 4) . substr($charid, 12, 4) . substr($charid, 16, 4) . substr($charid, 20, 12);
        return $uuid;
    }


    //POST请求
    public static function request_post($url = '', $post_data = array()) {
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
        // 初始化一个 cURL 对象
        $ch = curl_init();
        if (strlen($url) > 5 && strtolower(substr($url,0,5)) == "https" ) {
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);//https请求，不验证证书
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);//https请求，不验证hosts
        }
        curl_setopt($ch, CURLOPT_ENCODING, "");//设置编码
        curl_setopt($ch, CURLOPT_URL,$postUrl);//抓取指定网页
        curl_setopt($ch, CURLOPT_HEADER, 0);//设置header
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);//要求结果为字符串且输出到屏幕上
        curl_setopt($ch, CURLOPT_POST, 1);//post提交方式
        curl_setopt($ch, CURLOPT_POSTFIELDS, $curlPost);
        $data = curl_exec($ch);//运行curl
        curl_close($ch);
        return $data;
    }

}

?>
