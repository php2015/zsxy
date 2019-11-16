<?php 

require_once ("config/AccEntryConfig.php");
require_once ("entity/Request.php"); 
require_once ('utils/log.php');
require_once ("utils/Utils.php");
require_once ("utils/Aes.php");
require_once ("utils/Res.php");

$RSA = new \accentry\utils\Res();
$RSA->init($accEntryConfig['SHA256_PUBLIC_KEY'],$accEntryConfig['SHA256_PRIVATE_KEY'],$accEntryConfig['SHA256_PRIVATE_KEY_PWD']);
ini_set("error_reporting","E_ALL & ~E_NOTICE"); 
//初始化日志
?>

<html>
<head>
    <title>表单提交</title>
    <script type="text/javascript" src="/public/index/js/jquery.min.js"></script>
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
    
   // Log::DEBUG("加密前data: " . $data);
  
    $signData = '865b452ed00105e9cbac8ae2ff498bd48bd042f0b1adba31af6e6582a42585ed4e08f5b64fcb9d1824c5815ed028ad39460237b57c399b9f210b4000e4fa057e8a3b64f236d12cc70a7df8ef36d3e194ef05fc0df635b3779c5db897a2a8e816c4fe293cf4c2a056e152cd2a2464c2651525be63b960c6b1ae96f0679038ab4fa9c46def899f9b180775222d5775cd9715715770b402f93fc0cc261107a813328fda9039e1f69cffb7a80a52a1a34b250fc53f53756c828820c02aa065bda6ec495e0c7f352b27f00c3bdfa5c3def41acf51742e6fddcd17a9d837915118e561fb66ec6ed0c129b84fdc52ae9d529419e8f7193d4f92ef3ceb0896bdefe6e5d716b42bc4403ab15249a8c46e9d248fe5deeaf9f7b066305936cd19050da600c055442ebd9b9a93cf50b8f328af44cb9e29fa544ec22c1709690eb096cae0529babd8d30225ed8e1e8b6e42bffd4c0ce4167ec3676853105c5a872f36dc25dd7f099c9c574d3b1d68dfaf234ca07c099432ce8b92dcdba6ecd5cd84b9b991085e04eeb85c67b7c55798d147381d7bb9fbacfd4e6e28a2909d694c92df10deeadc7ef67d93d766e2142fde506c2158d65713b4ffb5a1f8d5030707d9773ac3d17a7aafcf0f7b950747b40a7fbc87b05d506e9c7e36c621c9a2fa7aa4da87cf3b76b865805b7a85bc4bec121b9fa351a0f6201160b993bba4b1107998396e62adf44869886d127e699bdda4aab26053234ada17eb9e1a75fc79337333a20ffc763b63b53ef23a20a901c4ea99409b11780c6cc06f718374ea697798750935e0f107849a16263bde4e134d4cd101ffb8db1fc871c90b08c5fc5542a80557c2102937';//\accentry\utils\Aes::encode($accEntryConfig['AES_KEY'],$data);
  
    //Log::DEBUG("加密后signData: " . $signData);
    
    $accEntryRequest = new Request($version, $ts, $merCode, $nonceStr, $format, $encryptType, $signData, $signType);
    $object = \accentry\utils\Utils::arr2str(\accentry\utils\Utils::object_array($accEntryRequest));
    
   // Log::DEBUG("加密前object: " . $object);
    $signObject = $RSA->sign($object);
   // Log::DEBUG("加密后signObject: " . $signObject);
  
   
 
?>
<form id="form" action="<?php echo $url; ?>" method="post">
    <input type="hidden" name="data" value="<?php echo $signData; ?>">
    <input type="hidden" name="version" value="<?php echo $version; ?>">
    <input type="hidden" name="merCode" value="<?php echo $merCode; ?>">
    <input type="hidden" name="ts" value="<?php echo $ts; ?>">
    <input type="hidden" name="nonceStr" value="<?php echo $nonceStr?>">
    <input type="hidden" name="format" value="<?php echo $format; ?>">
    <input type="hidden" name="encryptType" value="<?php echo $encryptType; ?>">
    <input type="hidden" name="signType" value="<?php echo $signType; ?>">
    <input type="hidden" name="sign" value="<?php echo $signObject; ?>">
</form>
<script type="text/javascript">
    $(document).ready(function(){
        $("#form").submit();
    });
</script>
</body>
</html>
