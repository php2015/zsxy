<?php require_once ("config/AccEntryConfig.php"); ?>
<head>
    <title>微商线下接口</title>
</head>
<body bgcolor="#FFFFFF">
<form id="collBankList" method="post" action="submitForm.php" target="_blank">
    <input type="hidden" name="dataForm" id="dataForm">
    <input type="hidden" name="versionForm" id="versionForm">
    <input type="hidden" name="merCodeForm" id="merCodeForm">
    <input type="hidden" name="tsForm" id="tsForm">
    <input type="hidden" name="nonceStrForm" id="nonceStrForm">
    <input type="hidden" name="formatForm" id="formatForm">
    <input type="hidden" name="encryptTypeForm" id="encryptTypeForm">
    <input type="hidden" name="signTypeForm" id="signTypeForm">
    <input type="hidden" name="url"
           value="<?php echo $accEntryConfig['ipsURL']; ?>/trade/microboss/page/pay">
</form>
<table align="center" border="1" cellpadding="3" cellspacing="0" width="600" bgcolor="#F0F0FF">
    <tr bgcolor="#8070FF">
        <td colspan="2" align="center">
            <span style="color: #FFFF00; "><b>微商线下接口</b></span>
        </td>
    </tr>
    <?php include_once('newapi.php'); ?>
    <tr>
        <td width="35%"><label>账户号:</label></td>
        <td width="65%">
            <input type="text" width="65%" id="account" name="account" value="<?php echo $accEntryConfig['accCode']; ?>">
        </td>
    </tr>
    <tr>
        <td width="35%"><label>平台编码:</label></td>
        <td width="65%">
            <input type="text" width="65%" id="platCode" name="platCode">
        </td>
    </tr>

    <tr>
        <td width="35%"><label>商户订单号:</label></td>
        <td width="65%">
            <input type="text" width="65%" id="trxId" name="trxId" value="<?php echo $accEntryConfig['merBillNo']; ?>">
        </td>
    </tr>
    <tr>
        <td width="35%"><label>商户类型:</label></td>
        <td>
            <select id="merType" name="merType" style="width: 115px">
                <option value="0" selected="selected">标准商户</option>
                <option value="1">平台商户</option>
            </select>
        </td>
    </tr>
    <tr>
        <td width="35%"><label>子商户号:</label></td>
        <td width="65%">
            <input type="text" width="65%" id="subMerCode" name="subMerCode">
        </td>
    </tr>
    <tr>
        <td width="35%"><label>交易金额:</label></td>
        <td width="65%">
            <input type="text" width="65%" id="trxAmt" name="trxAmt">
        </td>
    </tr>
    <tr>
        <td width="35%"><label>交易日期时间:</label></td>
        <td width="65%">
            <input type="text" width="65%" id="trxDtTm" name="trxDtTm" value="<?php echo $accEntryConfig['date']; ?>">
        </td>
    </tr>
    <tr>
        <td width="35%"><label>页面跳转地址:</label></td>
        <td width="65%">
            <input type="text" width="65%" id="pageUrl" name="pageUrl" value="<?php echo $accEntryConfig['successURL']; ?>">
        </td>
    </tr>
    <tr>
        <td width="35%"><label>异步通知地址:</label></td>
        <td width="65%">
            <input type="text" width="65%" id="notifyUrl" name="notifyUrl" value="<?php echo $accEntryConfig['s2sURL']; ?>">
        </td>
    </tr>
    <tr>
        <td width="35%">交易截止时间:</td>
        <td width="65%">
            <input type="text" width="65%" id="expireDtTm" name="expireDtTm">
        </td>
    </tr>
    <tr>
        <td width="35%"><label>收货人:</label></td>
        <td width="65%">
            <input type="text" width="65%" id="buyer" name="buyer">
        </td>
    </tr>
    <tr>
        <td width="35%"><label>收获地址:</label></td>
        <td width="65%">
            <input type="text" width="65%" id="shipAddress" name="shipAddress">
        </td>
    </tr>
    <tr>
        <td width="35%"><label>币种:</label></td>
        <td width="65%">
            <input type="text" width="65%" id="trxCcyCd" name="trxCcyCd" value="156">
        </td>
    </tr>
    <tr>
        <td width="35%"><label>留言:</label></td>
        <td width="65%">
            <input type="text" width="65%" id="remark" name="remark">
        </td>
    </tr>
    <tr>
        <td width="35%">商户附加数据:</td>
        <td width="65%">
            <input type="text" width="65%" id="attach" name="attach">
        </td>
    </tr>
    <tr>
        <td width="35%">商品描述:</td>
        <td width="65%">
            <input type="text" width="65%" id="goodsDesc" name="goodsDesc">
        </td>
    </tr>
    <tr>
        <td width="35%"><label>个人账户信息:</label></td>
        <td width="65%">
            <input type="text" width="65%" id="accountInfo" name="accountInfo">
        </td>
    </tr>
    <tr bgcolor="#8070FF" align="center">
        <td colspan="2">
            <label>是否有商品信息(必选):</label>
            <select id="checkGoods" name="checkGoods">
                <option value="1" selected="selected">有</option>
                <option value="2">没有</option>
            </select>
        </td>
    </tr>
    <tr bgcolor="#8070FF" align="center">
        <td colspan="2">商品信息:</td>
    </tr>
    <tr>
        <td width="35%">商品ID</td>
        <td width="65%">
            <input name="goodsId" id="goodsId" size="70" type="text">
        </td>
    </tr>
    <tr>
        <td width="35%">商品名称</td>
        <td width="65%">
            <input name="goodsName" id="goodsName" size="70" type="text">
        </td>
    </tr>
    <tr>
        <td width="35%">商品数量</td>
        <td width="65%">
            <input name="goodsCount" id="goodsCount" size="70" type="text">
        </td>
    </tr>
    <tr>
        <td width="35%">产品单价</td>
        <td width="65%">
            <input name="goodsPrice" id="goodsPrice" size="70" type="text">
        </td>
    </tr>
    <tr bgcolor="#8070FF" align="center">
        <td colspan="2">
            <label>是否有附加信息:</label>
            <select id="extFields" name="checkGoods">
                <option value="1" selected="selected">有</option>
                <option value="2">没有</option>
            </select>
        </td>
    </tr>
    <tr bgcolor="#8070FF" align="center">
        <td colspan="2">extFields信息:</td>
    </tr>
    <tr>
        <td width="35%">商户类别</td>
        <td width="40%">
            <input id="merCategory" size="70" type="text">
        </td>
    </tr>
    <tr>
        <td width="35%">交易场所</td>
        <td width="40%">
            <input id="platUrl" size="70" type="text">
        </td>
    </tr>
    <tr>
        <td width="35%">场所名称</td>
        <td width="40%">
            <input id="platName" size="70" type="text">
        </td>
    </tr>
    <tr>
        <td width="35%">下单IP</td>
        <td width="40%">
            <input id="clientIp" size="70" type="text">
        </td>
    </tr>
    <tr>
        <td width="35%">下单终端设备</td>
        <td width="40%">
            <input id="orderTerminal" size="70" type="text">
        </td>
    </tr>
    <tr>
        <td width="35%">地理位置</td>
        <td width="40%">
            <input id="gitLat" size="70" type="text">
        </td>
    </tr>
    <tr bgcolor="#8070FF" align="center">
        <td colspan="2">
            <label>是否有分账串(必选):</label>
            <select id="checkR">
                <option value="1" selected="selected">有</option>
                <option value="2">没有</option>
            </select>
        </td>
    </tr>
    <tr bgcolor="#8070FF" align="center">
        <td colspan="2">分账信息:</td>
    </tr>
    <tr>
        <td width="35%">分账冻结标志</td>
        <td width="40%">
            <input name="frozenFlag" id="frozenFlag" size="70" type="text">
        </td>
    </tr>
    <tr>
        <td width="35%">分账类型</td>
        <td width="40%">
            <input name="royaltyType" id="royaltyType" size="70" type="text">
        </td>
    </tr>
    <tr>
        <td width="35%">金额类型</td>
        <td width="40%">
            <select id="amtType" name="amtType">
                <option value="0" selected="selected"></option>
                <option value="1" selected="">固定值</option>
                <option value="2" selected="">百分比</option>
            </select>
        </td>
    </tr>
    <tr bgcolor="#8070FF" align="center">
        <td colspan="2">分账明细:</td>
    </tr>
    <tr>
        <td colspan="2">
            <table align="center" border="1" cellpadding="0">
                <tr>
                    <th>分账流水号</th>
                    <th>账户号</th>
                    <th>账户类型</th>
                    <th>金额</th>
                    <th>描述</th>
                    <td align="center">
                        <input type="button" onclick="addDetail()" value="添加"/>
                    </td>
                </tr>
                <tbody id="detail" align="center">
                <tr>
                    <td>
                        <input name="royaltyTrxId" size="10" type="text">
                    </td>
                    <td>
                        <input name="account" size="10" type="text">
                    </td>
                    <td>
                        <input name="accountType" size="5" type="text">
                    </td>
                    <td>
                        <input name="royaltyAmt" size="10" type="text">
                    </td>
                    <td>
                        <input name="desc" size="10" type="text">
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
            <input type="button" value="确认" onclick="submitForm()"/>
        </td>
    </tr>
</table>
<script type="text/javascript" src="js/jquery-1.9.1.min.js"></script>
<script type="text/javascript">
    function addDetail() {
        $("#detail").append(
            '<tr><td><input name="royaltyTrxId" size="10" type="text"></td>'
            + '<td><input name="account" size="10" type="text"></td>'
            + '<td><input name="accountType"  size="5" type="text"></td>'
            + '<td><input name="royaltyAmt"  size="10" type="text"></td>'
            + '<td><input name="desc"  size="10" type="text"></td>'
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
        str.platCode = $("#platCode").val();
        str.trxId = $("#trxId").val();
        str.merType = $("#merType").val();
        str.subMerCode = $("#subMerCode").val();
        str.trxAmt = $("#trxAmt").val();
        str.trxDtTm = $("#trxDtTm").val();
        str.pageUrl = $("#pageUrl").val();
        str.notifyUrl = $("#notifyUrl").val();
        str.expireDtTm = $("#expireDtTm").val();
        str.buyer = $("#buyer").val();
        str.shipAddress = $("#shipAddress").val();
        str.trxCcyCd = $("#trxCcyCd").val();
        str.remark = $("#remark").val();
        str.attach = $("#attach").val();
        str.goodsDesc = $("#goodsDesc").val();
        var goodsDetails = [];
        var goodsDesc = {};
        if ($("#checkGoods").val() === "1") {
            goodsDesc.goodsId = $("#goodsId").val();
            goodsDesc.goodsName = $("#goodsName").val();
            goodsDesc.goodsCount = $("#goodsCount").val();
            goodsDesc.goodsPrice = $("#goodsPrice").val();
            goodsDetails.push(goodsDesc);
        }
        str.goodsDetails = goodsDetails;

        var extFields = {};
        if ($("#extFields").val() === "1") {
            extFields.merCategory = $("#merCategory").val();
            extFields.platUrl = $("#platUrl").val();
            extFields.platName = $("#platName").val();
            extFields.clientIp = $("#clientIp").val();
            extFields.orderTerminal = $("#orderTerminal").val();
            extFields.gitLat = $("#gitLat").val();
        }
        str.extFields = extFields;

        var accountInfo = {};
        accountInfo.accountNo = $("#accountNo").val();
        str.accountInfo = accountInfo;

        var royaltyInfo = {};
        var royaltyDetails = [];
        if ($("#checkR").val() === "1") {
            royaltyInfo.frozenFlag = $("#frozenFlag").val();
            royaltyInfo.royaltyType = $("#royaltyType").val();
            royaltyInfo.amtType = $("#amtType").val();

            $("#detail").find("tr").each(
                function () {
                    var royaltyDetail = {};
                    //流水号
                    royaltyDetail.royaltyTrxId = $(this).find("input[name='royaltyTrxId']").val();
                    //账户号
                    royaltyDetail.account = $(this).find("input[name='account']").val();
                    //账户类型
                    royaltyDetail.accountType = $(this).find("input[name='accountType']").val();
                    //金额
                    royaltyDetail.royaltyAmt = $(this).find("input[name='royaltyAmt']").val();
                    //  备注
                    royaltyDetail.desc = $(this).find("input[name='desc']").val();
                    royaltyDetails.push(royaltyDetail);
                });
            royaltyInfo.royaltyDetails = royaltyDetails;
        }
        str.royaltyInfo = royaltyInfo;
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
