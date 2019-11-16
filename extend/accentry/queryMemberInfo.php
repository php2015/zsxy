<?php
require_once ("config/AccEntryConfig.php");
?>
<head>
    <title>会员信息查询接口</title>
</head>
<body bgcolor="#FFFFFF">
<form id="collBankList" method="post" action="submitHttpClint.php" target="_blank">
    <input type="hidden" name="dataForm" id="dataForm">
    <input type="hidden" name="versionForm" id="versionForm">
    <input type="hidden" name="merCodeForm" id="merCodeForm">
    <input type="hidden" name="tsForm" id="tsForm">
    <input type="hidden" name="nonceStrForm" id="nonceStrForm">
    <input type="hidden" name="formatForm" id="formatForm">
    <input type="hidden" name="encryptTypeForm" id="encryptTypeForm">
    <input type="hidden" name="signTypeForm" id="signTypeForm">
    <input type="hidden" name="url"
           value="<?php echo $accEntryConfig['ipsURL']; ?>/user/userInfo/query">
</form>
<table align="center" border="1" cellpadding="3" cellspacing="0" width="600" bgcolor="#F0F0FF">
    <tr bgcolor="#8070FF">
        <td colspan="2" align="center">
            <span style="color: #FFFF00; "><b>会员信息查询接口</b></span>
        </td>
    </tr>
    <?php include_once('newapi.php'); ?>
    <tr>
    <td width="35%">平台编号:</td>
    <td width="65%">
        <input type="text" width="65%" id="platCode">
    </td>
    </tr>

    <tr>
        <td width="35%">
            <label>平台用户名:</label>
        </td>
        <td width="65%">
            <input type="text" width="65%" id="platUserName">
        </td>
    </tr>
    <tr>
        <td width="35%">
            <label>ipsUserId:</label>
        </td>
        <td width="65%">
            <input type="text" width="65%" id="ipsUserId">
        </td>
    </tr>
    <tr>
        <td colspan="2" align="center">
            <input type="button" value="确认" onclick="submitForm()"/>
        </td>
    </tr>
</table>
<script type="text/javascript" src="js/jquery-1.9.1.min.js"></script>
<script type="text/javascript">
    function submitForm() {
        var jsonStr = [];
        var str = {};
        //商户请做各必填项的非空校验
        str.platCode = $("#platCode").val();
        str.platUserName = $("#platUserName").val();
        str.ipsUserId = $("#ipsUserId").val();

        jsonStr.push(str);
        alert(JSON.stringify(jsonStr).substring(1, JSON.stringify(jsonStr).length - 1));
        $("#dataForm").val(JSON.stringify(jsonStr).substring(1, JSON.stringify(jsonStr).length - 1));
        $("#versionForm").val($("#version").val());
        $("#merCodeForm").val($("#merCode").val());
        $("#tsForm").val($("#ts").val());
        $("#nonceStrForm").val($("#nonceStr").val());
        $("#formatForm").val($("#format option:selected").val());
        $("#encryptTypeForm").val($("#encryptType option:selected").val());
        $("#signTypeForm").val($("#signType option:selected").val());
        $("#collBankList").submit();
    }
</script>
</body>
