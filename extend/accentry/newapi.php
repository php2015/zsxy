<?php
ini_set('date.timezone','Asia/Shanghai');
require_once ("config/AccEntryConfig.php");
require_once ("utils/Utils.php");
$sdfStr = date('YmdHis');
$nonceStr = \accentry\utils\Utils::guid();
?>
<html>
<style type="text/css">
    TD {
        FONT-SIZE: 9pt
    }
    SELECT {
        FONT-SIZE: 9pt
    }
    OPTION {
        COLOR: #5040aa;
        FONT-SIZE: 9pt
    }
    INPUT {
        FONT-SIZE: 9pt
    }
</style>
<body bgcolor="#FFFFFF">
    <tr>
        <td width="25%">
            <label>版本号(必填):</label>
        </td>
        <td width="65%">
            <select id="version">
                <option value="2.0.0" selected="selected">2.0.0</option>
            </select>
        </td>
    </tr>
    <tr>
        <td style="width:130px;">
            <label>商户号(必填):</label>
        </td>
        <td style="width:200px;">
            <input type="text" style="width:200px;" id="merCode" value="<?php echo $accEntryConfig['merCode']; ?>">
        </td>
    </tr>
    <tr>
        <td style="width:130px;">
            <label>时间戳(必填):</label>
        </td>
        <td style="width:200px;">
            <input type="text" style="width:200px;" id="ts" value="<?php echo $sdfStr; ?>">
        </td>
    </tr>
    <tr>
        <td style="width:130px;">
            <label>随机数(必填):</label>
        </td>
        <td style="width:200px;">
            <input type="text" style="width:200px;" id="nonceStr" value="<?php echo $nonceStr; ?>">
        </td>
    </tr>
    <tr>
        <td style="width:130px;">
            <label>格式(必填):</label>
        </td>
        <td style="width:200px;">
            <select id="format">
                <option value="json" selected="selected">json</option>
            </select>
        </td>
    </tr>
    <tr>
        <td style="width:130px;">
            <label>加密方式(必填):</label>
        </td>
        <td style="width:200px;">
            <select id="encryptType">
                <option value="AES" selected="selected">AES</option>
            </select>
        </td>
    </tr>
    <tr>
        <td style="width:130px;">
            <label>签名方式(必输):</label>
        </td>
        <td style="width:200px;">
            <select id="signType">
                <option value="RSA2" selected="selected">sha256WithRSA</option>
            </select>
        </td>
    </tr>
</body>
</html>
