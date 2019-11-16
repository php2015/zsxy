<?php 
require_once ("config/AccEntryConfig.php"); 
require_once ("entity/Request.php"); 
require_once ("entity/SynchronousResponse.php"); 
require_once ('utils/log.php');
require_once ('utils/utils.php');
require_once 'utils/aes.ecb.class.php';
require_once 'utils/rsa.class.php';
$RSA = new RSA();
$RSA->init($accEntryConfig['SHA256_PUBLIC_KEY'],$accEntryConfig['SHA256_PRIVATE_KEY'],$accEntryConfig['SHA256_PRIVATE_KEY_PWD']);
ini_set("error_reporting","E_ALL & ~E_NOTICE"); 
//初始化日志
$logHandler= new CLogFileHandler("./logs/".date('Y-m-d').'.log');
$log = Log::Init($logHandler, 15);
?>
<html>
<head>
    <title>表单提交</title>
    <script type="text/javascript" src="js/jquery-1.9.1.min.js"></script>
</head>
<body>
<?php 
    // 获取页面请求信息
    $url = $_REQUEST['url'];
    $data = $_REQUEST['dataForm'];
    $version = $_REQUEST['versionForm'];
    $merCode = $_REQUEST['merCodeForm'];
    $ts = $_REQUEST['tsForm'];
    $nonceStr = $_REQUEST['nonceStrForm'];
    $format = $_REQUEST['formatForm'];
    $encryptType = $_REQUEST['encryptTypeForm'];
    $signType = $_REQUEST['signTypeForm'];
    
    Log::DEBUG("加密前data: " . $data);
    $signData = Aes::encode($accEntryConfig['AES_KEY'],$data);
    Log::DEBUG("加密后signData: " . $signData);
    
    $accEntryRequest = new Request($version, $ts, $merCode, $nonceStr, $format, $encryptType, $signData, $signType);
    $object = Utils::arr2str(Utils::object_array($accEntryRequest));
    
    Log::DEBUG("加密前object: " . $object);
    $signObject = $RSA->sign($object); 
    Log::DEBUG("加密后signObject: " . $signObject);
    
    $accEntryRequest->setSign($signObject);
    //post
    $post_data = Utils::object_array($accEntryRequest);
    Log::DEBUG("url :".$url);
    $result = Utils::request_post($url,$post_data);
    Log::DEBUG("POST返回 :".$result);
    $decryptData = "";
    $verifyResult = false;
    
    try {
        $synchronousResponse = json_decode($result);
        if ($synchronousResponse->sign !=null && $synchronousResponse->sign != "") {
            $returnMap = array();
            $returnMap["data"] = $synchronousResponse->data;
            $returnMap["respCode"] = $synchronousResponse->respCode;
            $returnMap["respMsg"] = $synchronousResponse->respMsg;
            $returnSignData = Utils::arr2str($returnMap);
            $verifyResult = $RSA->verify($returnSignData, $synchronousResponse->sign);
            if ($verifyResult) {
                $decryptData = Aes::decode($accEntryConfig['AES_KEY'],$synchronousResponse->data);
                
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


<!-- 以下只为展示数据使用，商户接收到同步返回报文后需要的操作请在So let's start here开始    -->
<table width="400" border="1" cellspacing="0" cellpadding="3"
       bordercolordark="#FFFFFF" bordercolorlight="#333333"
       bgcolor="#F0F0FF" align="center">
    <tr>
        <td>返回报文</td>
        <td>
            <textarea style="width: 250px;height: 200px;"><?php echo $result; ?></textarea>
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
