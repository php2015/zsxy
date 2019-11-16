<?php
$accEntryConfig=array();
// 迅付网关
$accEntryConfig['ipsURL'] = 'https://api.ips.com.cn';

//商户订单号，生成规则商户可以自己定
$accEntryConfig['merBillNo'] = date('YmdHis') . mt_rand(100000,999999);

//商户订单时间,当前时间yyyyMMdd
$accEntryConfig['date']	 = date('Ymd');

//ips商户号
$accEntryConfig['merCode'] = '178767';

//ips账户号
$accEntryConfig['accCode'] = '1787670015';

//AES证书，与ips保持一致，
//通过商户后台——>商户设置——>商户服务生成AES密钥，并下载
$accEntryConfig['AES_KEY'] = 'XVZPVn1FuFgsLQcP';


//通知地址,这是ips处理成功以后通知给商户的接口地址
$accEntryConfig['successURL'] = 'http://www.zsxycx.com/extend/accentry/callBackResult.php';

//通知地址,这是ips处理完成以后通知给商户的server to server地址
$accEntryConfig['s2sURL'] = 'http://www.zsxycx.com/extend/accentry/callBackResult.php';

//successURL,s2sURL均为异步回调地址，可以参考callBackResult.php



//RSA公私钥生成查看地址：http://web.chacuo.net/netrsakeypair，密钥位数选择2048bit，密钥格式PKCS#1
//RSA私钥，请将对应生成的公钥提供给ips
//通过商户后台——>商户设置——>商户服务上传SHA256RSA公钥 (格式如文件 public.key.txt)
$accEntryConfig['SHA256_PRIVATE_KEY'] = 'private.key.txt';//此处填写文件名

//生成私钥时的证书密码，若没有密码则不填
$accEntryConfig['SHA256_PRIVATE_KEY_PWD'] = 'ips2019';

//RSA公钥,ips提供，
//通过商户后台——>商户设置——>商户服务生成SHA公钥，并下载SHA公钥,
$accEntryConfig['SHA256_PUBLIC_KEY'] = 'public.key.txt';//此处填写文件名



?>


