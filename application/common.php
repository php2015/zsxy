<?php

use think\Db;

/**
 * 获取分类所有子分类
 * @param int $cid 分类ID
 * @return array|bool
 */
function get_category_children($cid)
{
    if (empty($cid)) {
        return false;
    }

    $children = Db::name('category')->where(['path' => ['like', "%,{$cid},%"]])->select();

    return array2tree($children);
}

/**
 * 根据分类ID获取文章列表（包括子分类）
 * @param int   $cid   分类ID
 * @param int   $limit 显示条数
 * @param array $where 查询条件
 * @param array $order 排序
 * @param array $filed 查询字段
 * @return bool|false|PDOStatement|string|\think\Collection
 */
function get_articles_by_cid($cid, $limit = 10, $where = [], $order = [], $filed = [])
{
    if (empty($cid)) {
        return false;
    }

    $ids = Db::name('category')->where(['path' => ['like', "%,{$cid},%"]])->column('id');
    $ids = (!empty($ids) && is_array($ids)) ? implode(',', $ids) . ',' . $cid : $cid;

    $fileds = array_merge(['id', 'cid', 'title', 'introduction', 'thumb', 'reading', 'publish_time'], (array)$filed);
    $map    = array_merge(['cid' => ['IN', $ids], 'status' => 1, 'publish_time' => ['<= time', date('Y-m-d H:i:s')]], (array)$where);
    $sort   = array_merge(['is_top' => 'DESC', 'sort' => 'DESC', 'publish_time' => 'DESC'], (array)$order);

    $article_list = Db::name('article')->where($map)->field($fileds)->order($sort)->limit($limit)->select();

    return $article_list;
}

/**
 * 根据分类ID获取文章列表，带分页（包括子分类）
 * @param int   $cid       分类ID
 * @param int   $page_size 每页显示条数
 * @param array $where     查询条件
 * @param array $order     排序
 * @param array $filed     查询字段
 * @return bool|\think\paginator\Collection
 */
function get_articles_by_cid_paged($cid, $page_size = 15, $where = [], $order = [], $filed = [])
{
    if (empty($cid)) {
        return false;
    }

    $ids = Db::name('category')->where(['path' => ['like', "%,{$cid},%"]])->column('id');
    $ids = (!empty($ids) && is_array($ids)) ? implode(',', $ids) . ',' . $cid : $cid;

    $fileds = array_merge(['id', 'cid', 'title', 'introduction', 'thumb', 'reading', 'publish_time'], (array)$filed);
    $map    = array_merge(['cid' => ['IN', $ids], 'status' => 1, 'publish_time' => ['<= time', date('Y-m-d H:i:s')]], (array)$where);
    $sort   = array_merge(['is_top' => 'DESC', 'sort' => 'DESC', 'publish_time' => 'DESC'], (array)$order);

    $article_list = Db::name('article')->where($map)->field($fileds)->order($sort)->paginate($page_size);

    return $article_list;
}

/**
 * 数组层级缩进转换
 * @param array $array 源数组
 * @param int   $pid
 * @param int   $level
 * @return array
 */
function array2level($array, $pid = 0, $level = 1)
{
    static $list = [];
    foreach ($array as $v) {
        if ($v['pid'] == $pid) {
            $v['level'] = $level;
            $list[]     = $v;
            array2level($array, $v['id'], $level + 1);
        }
    }

    return $list;
}

/**
 * 构建层级（树状）数组
 * @param array  $array          要进行处理的一维数组，经过该函数处理后，该数组自动转为树状数组
 * @param string $pid_name       父级ID的字段名
 * @param string $child_key_name 子元素键名
 * @return array|bool
 */
function array2tree(&$array, $pid_name = 'pid', $child_key_name = 'children')
{
    $counter = array_children_count($array, $pid_name);
    if (!isset($counter[0]) || $counter[0] == 0) {
        return $array;
    }
    $tree = [];
    while (isset($counter[0]) && $counter[0] > 0) {
        $temp = array_shift($array);
        if (isset($counter[$temp['id']]) && $counter[$temp['id']] > 0) {
            array_push($array, $temp);
        } else {
            if ($temp[$pid_name] == 0) {
                $tree[] = $temp;
            } else {
                $array = array_child_append($array, $temp[$pid_name], $temp, $child_key_name);
            }
        }
        $counter = array_children_count($array, $pid_name);
    }

    return $tree;
}

/**
 * 子元素计数器
 * @param array $array
 * @param int   $pid
 * @return array
 */
function array_children_count($array, $pid)
{
    $counter = [];
    foreach ($array as $item) {
        $count = isset($counter[$item[$pid]]) ? $counter[$item[$pid]] : 0;
        $count++;
        $counter[$item[$pid]] = $count;
    }

    return $counter;
}

/**
 * 把元素插入到对应的父元素$child_key_name字段
 * @param        $parent
 * @param        $pid
 * @param        $child
 * @param string $child_key_name 子元素键名
 * @return mixed
 */
function array_child_append($parent, $pid, $child, $child_key_name)
{
    foreach ($parent as &$item) {
        if ($item['id'] == $pid) {
            if (!isset($item[$child_key_name]))
                $item[$child_key_name] = [];
            $item[$child_key_name][] = $child;
        }
    }

    return $parent;
}

/**
 * 循环删除目录和文件
 * @param string $dir_name
 * @return bool
 */
function delete_dir_file($dir_name)
{
    $result = false;
    if (is_dir($dir_name)) {
        if ($handle = opendir($dir_name)) {
            while (false !== ($item = readdir($handle))) {
                if ($item != '.' && $item != '..') {
                    if (is_dir($dir_name . DS . $item)) {
                        delete_dir_file($dir_name . DS . $item);
                    } else {
                        unlink($dir_name . DS . $item);
                    }
                }
            }
            closedir($handle);
            if (rmdir($dir_name)) {
                $result = true;
            }
        }
    }

    return $result;
}

/**
 * 判断是否为手机访问
 * @return  boolean
 */
function is_mobile()
{
    static $is_mobile;

    if (isset($is_mobile)) {
        return $is_mobile;
    }

    if (empty($_SERVER['HTTP_USER_AGENT'])) {
        $is_mobile = false;
    } elseif (strpos($_SERVER['HTTP_USER_AGENT'], 'Mobile') !== false
        || strpos($_SERVER['HTTP_USER_AGENT'], 'Android') !== false
        || strpos($_SERVER['HTTP_USER_AGENT'], 'Silk/') !== false
        || strpos($_SERVER['HTTP_USER_AGENT'], 'Kindle') !== false
        || strpos($_SERVER['HTTP_USER_AGENT'], 'BlackBerry') !== false
        || strpos($_SERVER['HTTP_USER_AGENT'], 'Opera Mini') !== false
        || strpos($_SERVER['HTTP_USER_AGENT'], 'Opera Mobi') !== false
    ) {
        $is_mobile = true;
    } else {
        $is_mobile = false;
    }

    return $is_mobile;
}

/**
 * 手机号格式检查
 * @param string $mobile
 * @return bool
 */
function check_mobile_number($mobile)
{
    if (!is_numeric($mobile)) {
        return false;
    }
    $reg = '#^13[\d]{9}$|^14[5,7]{1}\d{8}$|^15[^4]{1}\d{8}$|^17[0,6,7,8]{1}\d{8}$|^18[\d]{9}$#';

    return preg_match($reg, $mobile) ? true : false;
}








/**
		 * 创建授权Token
		 * 请求URL：https://prod.gxb.io/crawler/auth/v2/get_auth_token
		 * 请求方式：POST(header:Content-Type=application/json)
		*/
		function get_auth_token($name,$phone,$idcard){
			$appId = 'gxb75264a1586e93efb';
			$appSecret = '8bbde44d96924262974c02ad77643881';
			$url = 'https://prod.gxb.io/crawler/auth/v2/get_auth_token';
			$sequenceNo = date('ymd').uniqid();
			$timestamp = time().'000';
			$authItem = 'operator_plus';
			#$name = '刘伟祥';
			#$phone = '18062677701';
			#$idcard = '421181199110045597';
			$param = array(
				'sequenceNo' => $sequenceNo,
				'authItem' => $authItem,
				'appId' => $appId,
				'timestamp' => $timestamp,
				'sign' => md5($appId.$appSecret.$authItem.$timestamp.$sequenceNo),
				'name' => $name,
				'phone' => $phone,
				'idcard' => $idcard,
				'authVersion' => 'v1'
			);
			$get_auth_token_Result = curlPost($url,$param);
			# {"data":{"token":"0315201448000JE6F3CPaNLzEPIMeAPP"},"retCode":1,"retMsg":"成功"}
          	
          	if(json_decode($get_auth_token_Result,true)['retCode']){
              	$token = json_decode($get_auth_token_Result,true)['data']['token'];
            	return $token;
            }
          	else{
            	return 0;
            }
			#var_dump($get_auth_token_Result);
		}
  
  		/**
		 * 拉取模式接口
		 * 请求URL：https://prod.gxb.io/crawler/data/report/0000000000000BAQjgp0phPML2IOX6v9?appId=gxb12344321abcdcba&timestamp=1508914833123&sign=c28263a02db537a6cd4f4f83b1f67123
		 * 请求方式：GET
		*/
		function crawler($token){
			$appId = 'gxb75264a1586e93efb';
			$appSecret = '8bbde44d96924262974c02ad77643881';
			$url = 'https://prod.gxb.io/crawler/data/report/';
			$sequenceNo = date('ymd').uniqid();
			$timestamp = time().'000';
			$param = array(
				'token' => $token,
				'appId' => $appId,
				'timestamp' => $timestamp,
				'sign' => md5($appId.$appSecret.$timestamp)
			);
			$getparam = '';
			for($i = 0;$i < count($param);$i++){
				$getparam = $param['token'].
										'?appId='.$param['appId'].
										'&timestamp='.$param['timestamp'].
										'&sign='.$param['sign'];
			}
			// var_dump($url.$getparam);exit;
			$crawlerResult = curlGet($url.$getparam);
          	return json_decode($crawlerResult,true);
			#echo "<pre>";
			#var_dump(json_decode($crawlerResult,true));
		}
  
  		function curlGet($url){
		  $curl = curl_init(); // 启动一个CURL会话
			curl_setopt($curl, CURLOPT_URL, $url);
			curl_setopt($curl, CURLOPT_HEADER, 0);
			curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false); // 跳过证书检查
			$tmpInfo = curl_exec($curl);     //返回api的json对象
			//关闭URL请求
			curl_close($curl);
			return $tmpInfo;
		}
  
  		/**
		 * 通过CURL发送HTTP请求
		 * @param string $url  //请求URL
		 * @param array $postFields //请求参数 
		 * @return mixed
		*/
		function curlPost($url,$postFields){
			$postFields = json_encode($postFields);
			$ch = curl_init ();
			curl_setopt( $ch, CURLOPT_URL, $url ); 
			curl_setopt( $ch, CURLOPT_HTTPHEADER, array(
				'Content-Type: application/json; charset=utf-8'
				)
			);
			curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1 );
			curl_setopt( $ch, CURLOPT_POST, 1 );
			curl_setopt( $ch, CURLOPT_POSTFIELDS, $postFields);
			curl_setopt( $ch, CURLOPT_TIMEOUT,1); 
			curl_setopt( $ch, CURLOPT_SSL_VERIFYHOST, 0);
			curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, 0);
			$ret = curl_exec ( $ch );
			if (false == $ret) {
				$result = curl_error(  $ch);
			} else {
				$rsp = curl_getinfo( $ch, CURLINFO_HTTP_CODE);
				if (200 != $rsp) {
					$result = "请求状态 ". $rsp . " " . curl_error($ch);
				} else {
					$result = $ret;
				}
			}
			curl_close ( $ch );
			return $result;
		}