<?php require_once ("config/AccEntryConfig.php"); ?>
<head>
    <title>收支明细查询接口</title>
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
           value="<?php echo $accEntryConfig['ipsURL']; ?>/account/expense/query">
</form>
<table align="center" border="1" cellpadding="3" cellspacing="0" width="600" bgcolor="#F0F0FF">
    <tr bgcolor="#8070FF">
        <td colspan="2" align="center">
            <span style="color: #FFFF00; "><b>收支明细查询接口</b></span>
        </td>
    </tr>
    <?php include_once('newapi.php'); ?>
    <tr>
        <td width="25%">账户号(必填):</td>
        <td width="65%"><input name="account" type="text" id="account"/></td>
    </tr>
    <tr>
        <td>币种(必填):</td>
        <td>
            <select id="trxCcyCd" name="trxCcyCd">
                <option value="156" selected="selected">人民币</option>
            </select>
        </td>
    </tr>
    <tr>
        <td>商户订单号</td>
        <td><input name="trxId" type="text" id="trxId"/></td>
    </tr>
    <tr>
        <td>IPS交易订单号(必填):</td>
        <td><input name="ipsTrxId" type="text" id="ipsTrxId"/></td>
    </tr>
    <tr>
        <td>开始时间(必填):</td>
        <td><input name="startDt" type="text" id="startDt"/></td>
    </tr>
    <tr>
        <td>结束时间(必填):</td>
        <td><input name="endDt" type="text" id="endDt"/></td>
    </tr>
    <tr>
        <td>当前页</td>
        <td><input name="page" type="text" id="page"/></td>
    </tr>
    <tr>
        <td>分页步长</td>
        <td><input name="pageSize" type="text" id="pageSize"/></td>
    </tr>
    <tr>
        <td colspan="2" align="center">
            <input type="button" value="查询" onclick="submitForm()"/>
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
        str.trxCcyCd = $("#trxCcyCd option:selected").val();
        str.trxId = $("#trxId").val();
        str.ipsTrxId = $("#ipsTrxId").val();
        str.startDt = $("#startDt").val();
        str.endDt = $("#endDt").val();
        str.page = $("#page").val();
        str.pageSize = $("#pageSize").val();

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
