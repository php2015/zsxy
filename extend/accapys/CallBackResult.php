<?php
namespace accapys;

use accapys\entity\CollBackResponse;
use accapys\entity\Utils;
use accapys\lib\AccEntryConfig;
use accapys\lib\Aes;
use accapys\lib\Log;
use accapys\lib\Rsa;
use think\Exception;

//$Rsa = new Rsa();
//$Rsa->init(AccEntryConfig::SHA256_PUBLIC_KEY,AccEntryConfig::SHA256_PRIVATE_KEY,AccEntryConfig::SHA256_PRIVATE_KEY_PWD);
//ini_set("error_reporting","E_ALL & ~E_NOTICE");
?>

<?php
// 获取返回数据
$data = $_REQUEST['data'];
$version = $_REQUEST['version'];
$merCode = $_REQUEST['merCode'];
$ts = $_REQUEST['ts'];
$nonceStr = $_REQUEST['nonceStr'];
$format = $_REQUEST['format'];
$encryptType = $_REQUEST['encryptType'];
$signType = $_REQUEST['signType'];
$notifyType = $_REQUEST['notifyType'];
$sign = $_REQUEST['sign'];
$verifyObject = null;
$decryptData = null;
$verifyResult = false;

file_put_contents("88.txt", $data);

try {
    if ($sign != null && $sign != "") {
        $backResponse = new CollBackResponse($version, $ts, $merCode, $nonceStr, $format, $encryptType, $data, $signType, $notifyType);
        $verifyObject = Utils::arr2str(Utils::object_array($backResponse));
        $verifyResult = $Rsa->verify($verifyObject,$sign);
        if ($verifyResult) {
            $decryptData = Aes::decode(AccEntryConfig::AES_KEY,$data);

            //So let's start here
            //——请在这里编写您的程序（returnData为解密后的实体报文类字符串，——
            //——建议转为各自接口的返回实体类进行后续编码）——
            //——Utils.jsonString2Object(returnData, SynchronousResponse.class);——
        }
    }
} catch (Exception $e) {
    echo $e->getMessage();
    Log::DEBUG("异常信息 :".$e->getMessage());
}
?>
