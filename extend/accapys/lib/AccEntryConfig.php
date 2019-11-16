<?php

namespace accapys\lib;

class AccEntryConfig
{
    //版本号
    const VERSION = '2.0.0';

    const APPID = "wx4c30e2e40e1b76de";//wxfaa49ae1017830b7

    const SECRET = "2df01116d09419dd162b28e3a34e5475";//a46e1331e8382e9a51844985deace246

    // 迅付网关
    const IPSURL = 'https://api.ips.com.cn';

    //jsapi 方法
    const URLINDEX = 'trade/platform/pay';

    //ips商户号
    const MERCODE = '284333';

    //ips账户号
    const ACCCODE = '2843330016';

    //'BaPhg6Lnq38JJLF4', //AES证书，与ips保持一致，通过商户后台——>商户设置——>商户服务生成AES密钥，并下载
    const AES_KEY = 'kwnfJarMrUfl8wF2';

    //通知地址,这是ips处理成功以后通知给商户的接口地址
    const NOTIFYURL = "http://www.xalanfeng.cn/index/pay/hxnotify";

    //跳转
    const PAGEURL = "http://www.xalanfeng.cn/index/pay/hxnotify";

    //通过商户后台——>商户设置——>商户服务生成SHA公钥，并下载SHA私钥,
    const SHA256_PRIVATE_KEY = "/www/wwwroot/www.xalanfeng.cn/extend/accapys/cert/private.key.txt";

    //通过商户后台——>商户设置——>商户服务生成SHA公钥，并下载SHA公钥,
    const SHA256_PUBLIC_KEY = "/www/wwwroot/www.xalanfeng.cn/extend/accapys/cert/public.key.txt";

    //生成私钥时的证书密码，若没有密码则不填
    const SHA256_PRIVATE_KEY_PWD = "HYBqwsx789";

    const PLATCODE = "1001";

    const MERNAME = "信息服务";

    const PRODUCTTYPE = "9505";

    const SCENETYPE = "JSAPI";

    const TRXCCYCD = '156';

    const ENCRYPTTYPE = 'AES';

    const SIGNTYPE = 'RSA2';

    const FORMAT = 'json';

    const CURL_PROXY_HOST = "0.0.0.0";//"10.152.18.220";

    const CURL_PROXY_PORT = 0;//8080;

}

