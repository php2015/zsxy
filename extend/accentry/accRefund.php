<?php require_once ("config/AccEntryConfig.php"); ?>
<head>
    <title>退款接口</title>
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
           value="<?php echo $accEntryConfig['ipsURL']; ?>/trade/refund">
</form>
<table align="center" border="1" cellpadding="3" cellspacing="0" width="600" bgcolor="#F0F0FF">
    <tr bgcolor="#8070FF">
        <td colspan="2" align="center">
            <span style="color: #FFFF00; "><b>退款接口</b></span>
        </td>
    </tr>
    <?php include_once('newapi.php'); ?>
    <tr>
        <td width="35%">
            <label>账户号(必填):</label>
        </td>
        <td width="65%">
            <input type="text" width="65%" id="account" name="account">
        </td>
    </tr>
    <tr>
        <td width="35%">
            <label>商户订单号(必填):</label>
        </td>
        <td width="65%">
            <input type="text" width="65%" id="trxId" name="trxId">
        </td>
    </tr>
    <tr>
        <td width="35%">
            <label>商户日期(必填):</label>
        </td>
        <td width="65%">
            <input type="text" width="65%" id="trxDtTm" name="trxDtTm">
        </td>
    </tr>
    <tr>
        <td width="35%">
            <label>金额(必填):</label></td>
        <td width="65%">
            <input type="text" width="65%" id="trxAmt" name="trxAmt">
        </td>
    </tr>
    <tr>
        <td width="35%">
            <label>原商户订单号(必填):</label>
        </td>
        <td width="65%">
            <input type="text" width="65%" id="oriTrxId" name="oriTrxId">
        </td>
    </tr>
    <tr>
        <td width="35%">
            <label>原交易日期(必填):</label>
        </td>
        <td width="65%">
            <input type="text" width="65%" id="oriTrxDtTm" name="oriTrxDtTm">
        </td>
    </tr>
    <tr>
        <td width="35%">
            <label>币种:</label>
        </td>
        <td width="65%">
            <input type="text" width="65%" id="trxCcyCd" name="trxCcyCd" value="156">
        </td>
    </tr>
    <tr>
        <td width="35%"><label>退款原因:</label></td>
        <td width="65%"><input type="text" width="65%"
                               id="refundDesc" name="refundDesc"></td>
    </tr>
    <tr>
        <td width="35%">退款异步通知地址</td>
        <td width="65%">
            <input name="refundUrl" id="refundUrl" type="text"
                   value="<?php echo $accEntryConfig['successURL']; ?>">
        </td>
    </tr>
    <tr>
        <td width="35%">退票异步通知地址</td>
        <td width="65%">
            <input name="rejectUrl" id="rejectUrl" type="text"
                   value="<?php echo $accEntryConfig['successURL']; ?>">
        </td>
    </tr>
    <tr>
        <td width="35%">商户数据包</td>
        <td width="65%">
            <input name="attach" id="attach" type="text"
                   value="this is merchant attach!">
        </td>
    </tr>
    <tr>
        <td width="35%">
            <label>是否有分账退款明细(必选):</label>
        </td>
        <td width="65%">
            <select id="checkR" name="checkR">
                <option value="1" selected="selected">有</option>
                <option value="2">没有</option>
            </select>
        </td>
    </tr>
    <tr bgcolor="#8070FF">
        <td colspan="2" align="center">
            <span style="color: #FFFF00; "><b>分账退款信息:分账明细:</b></span>
        </td>
    </tr>
    <tr>
        <td colspan="2">
            <table align="center" width="600" border="1">
                <tr>
                    <th>分账账户号</th>
                    <th>账户类型</th>
                    <th>退款金额</th>
                    <th>备注</th>
                    <td>
                        <input type="button" onclick="addDetail()" value="添加"/>
                    </td>
                </tr>
                <tbody id="detail">
                <tr>
                    <td>
                        <input name="account" size="10" type="text">
                    </td>
                    <td>
                        <input name="accountType" size="5" type="text">
                    </td>
                    <td>
                        <input name="refundAmt" size="10" type="text">
                    </td>
                    <td>
                        <input name="remark" size="10" type="text">
                    </td>
                    <td>
                        <input type="button" onclick="delDetail(this)" value="删除"/>
                    </td>
                </tr>
                </tbody>
            </table>
        </td>
    </tr>
    <tr>
        <td colspan="2" align="center">
            <input type="button" value="查询" onclick="submitForm()"/>
        </td>
    </tr>
</table>
<script type="text/javascript" src="js/jquery-1.9.1.min.js"></script>
<script type="text/javascript">
    function addDetail() {
        $("#detail").append(
            '<tr><td><input name="account" size="16" type="text"></td>'
            + '<td><input name="accountType"  size="2" type="text"></td>'
            + '<td><input name="refundAmt"  size="18" type="text"></td>'
            + '<td><input name="remark"  size="10" type="text"></td>'
            + '<td><input type="button" onclick="delDetail(this)" value="删除"/></td></tr>');
    }
    function delDetail(obj) {
        var tr = obj.parentNode.parentNode;
        var tbody = tr.parentNode;
        tbody.removeChild(tr);
    }
    function submitForm() {
        var jsonStr = [];
        var str = {};
        //商户请做各必填项的非空校验
        str.account = $("#account").val();
        str.trxId = $("#trxId").val();
        str.trxDtTm = $("#trxDtTm").val();
        str.trxAmt = $("#trxAmt").val();
        str.oriTrxId = $("#oriTrxId").val();
        str.oriTrxDtTm = $("#oriTrxDtTm").val();
        str.trxCcyCd = $("#trxCcyCd").val();
        str.refundDesc = $("#refundDesc").val();
        str.refundUrl = $("#refundUrl").val();
        str.rejectUrl = $("#rejectUrl").val();
        str.attach = $("#attach").val();

        var royaltyDetails = [];

        if ($("#checkR").val() === "1") {
            $("#detail").find("tr").each(
                function () {
                    var royaltyDetail = {};
                    //账户号
                    royaltyDetail.account = $(this).find("input[name='account']").val();
                    //账户类型
                    royaltyDetail.accountType = $(this).find("input[name='accountType']").val();
                    //金额
                    royaltyDetail.refundAmt = $(this).find("input[name='refundAmt']").val();
                    //备注
                    royaltyDetail.remark = $(this).find("input[name='remark']").val();
                    royaltyDetails.push(royaltyDetail);
                });
        }
        str.royaltyDetails = royaltyDetails;

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
