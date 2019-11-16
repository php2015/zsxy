<?php 
require_once ("config/AccEntryConfig.php"); 
require_once ('utils/log.php');
require_once ('utils/utils.php');
require_once ('entity/CollBackResponse.php');
require_once 'utils/aes.ecb.class.php';
require_once 'utils/rsa.class.php';
$RSA = new RSA();
$RSA->init($accEntryConfig['SHA256_PUBLIC_KEY'],$accEntryConfig['SHA256_PRIVATE_KEY'],$accEntryConfig['SHA256_PRIVATE_KEY_PWD']);
ini_set("error_reporting","E_ALL & ~E_NOTICE"); 
?>
<html>
<head>
    <style type="text/css">
        TD {
            FONT-SIZE: 9pt
        }

        INPUT {
            FONT-SIZE: 9pt
        }
    </style>
</head>
<body bgcolor="#FFFFFF">
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
    try {
        if ($sign != null && $sign != "") {
            $backResponse = new CollBackResponse($version, $ts, $merCode, $nonceStr, $format, $encryptType, $data, $signType, $notifyType);
            $verifyObject = Utils::arr2str(Utils::object_array($backResponse));
            $verifyResult = $RSA->verify($verifyObject,$sign);
            if ($verifyResult) {
                $decryptData = Aes::decode($accEntryConfig['AES_KEY'],$data);
                
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

<!-- 以下只为展示数据使用，商户接收到同步返回报文后需要的操作请在So let's start here开始                -->
<table width="400" border="1" cellspacing="0" cellpadding="3"
       bordercolordark="#FFFFFF" bordercolorlight="#333333"
       bgcolor="#F0F0FF" align="center">
    <tr>
        <td>返回报文</td>
        <td>
            <textarea style="width: 250px;height: 200px;"><?php echo $verifyObject; ?></textarea>
        </td>
    </tr>
    <tr>
        <td>验签结果</td>
        <td>
            <textarea style="width: 250px;height: 200px;"><?php echo $verifyResult==1?"true":"false"; ?></textarea>
        </td>
    </tr>
    <tr>
        <td>解密data数据</td>
        <td>
            <textarea style="width: 250px;height: 200px;"><?php echo $decryptData; ?></textarea>
        </td>
    </tr>
</table>
</body>
</html>	
