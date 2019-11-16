<?php require_once ("config/AccEntryConfig.php"); ?>
<head>
    <title>单笔交易查询接口</title>
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
           value="<?php echo $accEntryConfig['ipsURL']; ?>/trade/query">
</form>
<table align="center" border="1" cellpadding="3" cellspacing="0" width="600" bgcolor="#F0F0FF">
    <tr bgcolor="#8070FF">
        <td colspan="2" align="center">
            <span style="color: #FFFF00; "><b>单笔交易查询接口</b></span>
        </td>
    </tr>
    <?php include_once('newapi.php'); ?>
    <tr>
        <td width="25%">账户号(必填):</td>
        <td width="65%">
            <input name="account" type="text" id="account" value="<?php echo $accEntryConfig['accCode']; ?>"/>
        </td>
    </tr>
    <tr>
        <td>商户订单号(必填):</td>
        <td>
            <input name="trxId" type="text" id="trxId" value="<?php echo $accEntryConfig['merBillNo']; ?>"/>
        </td>
    </tr>
    <tr>
        <td>交易日期(必填):</td>
        <td>
            <input name="trxDt" type="text" id="trxDt" value="20190116"/>
        </td>
    </tr>
    <tr>
        <td>交易类型(必填):</td>
        <td>
            <select id="trxType" name="trxType">
                <option value="1002" selected="selected">退款</option>
                <option value="1014">退票</option>
            </select>
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
        str.account = $("#account").val();
        str.trxId = $("#trxId").val();
        str.trxDt = $("#trxDt").val();
        str.trxType = $("#trxType option:selected").val();

        jsonStr.push(str);
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
