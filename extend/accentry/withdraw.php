<?php require_once ("config/AccEntryConfig.php"); ?>
<head>
    <title>提现接口</title>
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
           value="<?php echo $accEntryConfig['ipsURL']; ?>/trade/withdraw">
</form>
<table align="center" border="1" cellpadding="3" cellspacing="0" width="600" bgcolor="#F0F0FF">
    <tr bgcolor="#8070FF">
        <td colspan="2" align="center">
            <span style="color: #FFFF00; "><b>提现接口</b></span>
        </td>
    </tr>
    <?php include_once('newapi.php'); ?>
    <tr>
        <td width="35%">
            <label>账户号(必填):</label>
        </td>
        <td width="40%"><input type="text" width="40%" id="account" name="account" value="<?php echo $accEntryConfig['accCode']; ?>"></td>
    </tr>
    <tr>
        <td width="35%">
            <label>平台编号:</label>
        </td>
        <td width="40%"><input type="text" id="platCode" name="platCode"></td>
    </tr>
    <tr>
        <td width="35%">
            <label>环迅用户ID:</label>
        </td>
        <td width="40%"><input type="text" id=ipsUserId name="ipsUserId"></td>
    </tr>
    <tr>
        <td width="35%">
            <label>环迅用户账户号:</label>
        </td>
        <td width="40%"><input type="text" id=userAccount name="userAccount"></td>
    </tr>
    <tr>
        <td width="35%">
            <label>商户订单号(必填):</label>
        </td>
        <td width="40%"><input type="text" width="40%" id="trxId" name="trxId" value="<?php echo $accEntryConfig['merBillNo']; ?>"></td>
    </tr>
    <tr>
        <td width="35%">
            <label>商户日期(必填):</label>
        </td>
        <td width="40%"><input type="text" width="40%" id="trxDtTm" name="trxDtTm" value="<?php echo $accEntryConfig['date']; ?>"></td>
    </tr>
    <tr>
        <td width="35%">
            <label>交易金额(必填):</label>
        </td>
        <td width="40%"><input type="text" width="40%" id="trxAmt" name="trxAmt" value="100"></td>
    </tr>
    <tr>
        <td width="35%">
            <label>卡编号:</label>
        </td>
        <td width="40%"><input type="text" width="40%" id="cardId" name="cardId"></td>
    </tr>
    <tr>
        <td width="35%">
            <label>短信验证码:</label>
        </td>
        <td width="40%"><input type="text" width="40%" id="smgCode" name="smgCode"></td>
    </tr>
    <tr>
        <td width="35%">
            <label>短信编号:</label>
        </td>
        <td width="40%"><input type="text" width="40%" id="smgId" name="smgId"></td>
    </tr>
    <tr>
        <td width="35%">提现异步通知Url</td>
        <td width="40%"><input name="notifyUrl" id="notifyUrl" size="70" type="text" value="<?php echo $accEntryConfig['s2sURL']; ?>"></td>
    </tr>
    <tr>
        <td width="35%">退票异步通知Url</td>
        <td width="40%"><input name="rejectUrl" id="rejectUrl" size="70" type="text" value="<?php echo $accEntryConfig['successURL']; ?>"></td>
    </tr>
    <tr>
        <td width="35%">商户数据包</td>
        <td width="40%"><input name="attach" id="attach" size="70" type="text" value="this is merchant attach!"></td>
    </tr>
    <tr>
        <td width="35%">备注</td>
        <td width="40%"><input name="remark" id="remark" size="70" type="text" value="this is merchant attach!"></td>
    </tr>

    <tr bgcolor="#8070FF" align="center">
        <td colspan="2">
            <label>extFields信息:</label>是否填写<input type="checkbox" value="1" id="extFieldsff" name="是" checked="checked"/>
        </td>
    </tr>
    <tr>
        <td colspan="2">
            <table align="center" border="1" cellpadding="0">
                <tbody id="extFields">
                <tr>
                    <td width="35%">商户类别
                    </td>
                    <td width="40%"><input id="merCategory" size="70" type="text">
                    </td>
                </tr>
                <tr>
                    <td width="35%">交易场所
                    </td>
                    <td width="40%"><input id="platUrl" size="70" type="text">
                    </td>
                </tr>
                <tr>
                    <td width="35%">场所名称
                    </td>
                    <td width="40%"><input id="platName" size="70" type="text">
                    </td>
                </tr>
                <tr>
                    <td width="35%">下单IP
                    </td>
                    <td width="40%"><input id="orderIp" size="70" type="text">
                    </td>
                </tr>
                <tr>
                    <td width="35%">下单终端设备
                    </td>
                    <td width="40%"><input id="orderTerminal" size="70" type="text">
                    </td>
                </tr>
                <tr>
                    <td width="35%">地理位置
                    </td>
                    <td width="40%"><input id="gitLat" size="70" type="text">
                    </td>
                </tr>
                </tbody>
            </table>
        </td>
    </tr>
    <tr>
        <td colspan="2" align="center">
            <input type="button" value="确认" onclick="submitForm()"/>
        </td>
    </tr>
</table>
</body>

<script type="text/javascript" src="js/jquery-1.9.1.min.js"></script>
<script type="text/javascript">
    function submitForm() {
        var jsonStr = [];
        var str = {};
        //商户请做各必填项的非空校验
        str.platCode = $("#platCode").val();
        str.account = $("#account").val();
        str.platUserName = $("#platUserName").val();
        str.ipsUserId = $("#ipsUserId").val();
        str.userAccount = $("#userAccount").val();
        str.trxId = $("#trxId").val();
        str.trxDtTm = $("#trxDtTm").val();
        str.trxCcyCd = $("#trxCcyCd").val();
        str.trxAmt = $("#trxAmt").val();
        str.cardId = $("#cardId").val();
        str.smgCode = $("#smgCode").val();
        str.smgId = $("#smgId").val();
        str.rejectUrl = $("#rejectUrl").val();
        str.notifyUrl = $("#notifyUrl").val();
        str.attach = $("#attach").val();
        str.remark = $("#remark").val();
        if ($("#extFieldsff").is(':checked')) {
            var extFields = {};
            extFields.merCategory = $("#merCategory").val();
            extFields.platUrl = $("#platUrl").val();
            extFields.platName = $("#platName").val();
            extFields.orderIp = $("#orderIp").val();
            extFields.orderTerminal = $("#orderTerminal").val();
            extFields.gitLat = $("#gitLat").val();
            str.extFields = extFields;
        }
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
