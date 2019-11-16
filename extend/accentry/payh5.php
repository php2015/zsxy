<?php
require_once ("config/AccEntryConfig.php");
?>
<head>
    <title>H5网关支付接口</title>
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
           value="<?php echo $accEntryConfig['ipsURL']; ?>/trade/h5/pay">
</form>
<table align="center" border="1" cellpadding="3" cellspacing="0" width="600" bgcolor="#F0F0FF">
    <tr bgcolor="#8070FF">
        <td colspan="2" align="center">
            <span style="color: #FFFF00; "><b>H5网关支付接口</b></span>
        </td>
    </tr>
    <?php include_once('newapi.php'); ?>
    <tr>
        <td width="35%">
            <label>账户号(必填):</label>
        </td>
        <td width="40%">
            <input type="text" width="40%" id="account" name="account" value="<?php echo $accEntryConfig['accCode']; ?>">
        </td>
    </tr>
    <tr>
        <td width="35%">
            <label>平台编号:</label>
        </td>
        <td width="40%">
            <input type="text" id="platCode" name="platCode">
        </td>
    </tr>
    <tr>
        <td width="35%">
            <label>商户订单号(必填):</label>
        </td>
        <td width="40%">
            <input type="text" width="40%" id="trxId" name="trxId" value="<?php echo $accEntryConfig['merBillNo']; ?>">
        </td>
    </tr>
    <tr>
        <td width="35%">
            <label>商户日期(必填):</label>
        </td>
        <td width="40%">
            <input type="text" width="40%" id="trxDtTm" name="trxDtTm" value="<?php echo $accEntryConfig['date']; ?>">
        </td>
    </tr>

    <tr>
        <td width="35%">
            <label>交易截止时间:</label>
        </td>
        <td width="40%">
            <input type="text" width="40%" id="expireDtTm" name="expireDtTm">
        </td>
    </tr>
    <tr>
        <td width="35%">
            <label>币种:</label>
        </td>
        <td width="40%">
            <input type="text" width="40%" id="trxCcyCd" name="trxCcyCd" value="156">
        </td>
    </tr>
    <tr>
        <td width="35%">
            <label>交易金额(必填):</label>
        </td>
        <td width="40%">
            <input type="text" width="40%" id="trxAmt" name="trxAmt" value="100">
        </td>
    </tr>
    <tr>
        <td width="35%">
            <label>产品类型:</label>
        </td>
        <td width="40%">
            <input type="text" width="40%" id="productType" name="productType">
        </td>
    </tr>
    <tr>
        <td width="35%">限制支付类型:</td>
        <td width="40%">
            <input type="text" width="40%" id="limitPayType" name="limitPayType">
        </td>
    </tr>
    <tr>
        <td width="35%">语言</td>
        <td width="40%">
            <select name="lang" id="lang" style="width: 115px">
                <option selected="selected" value="zh">中文</option>
            </select>
        </td>
    </tr>
    <tr>
        <td width="35%">页面回调Url</td>
        <td width="40%">
            <input name="pageUrl" id="pageUrl" size="70" type="text" value="<?php echo $accEntryConfig['successURL']; ?>">
        </td>
    </tr>
    <tr>
        <td width="35%">服务器回调Url</td>
        <td width="40%">
            <input name="notifyUrl" id="notifyUrl" size="70" type="text" value="<?php echo $accEntryConfig['s2sURL']; ?>">
        </td>
    </tr>
    <tr>
        <td width="35%">商户数据包</td>
        <td width="40%">
            <input name="attach" id="attach" size="70" type="text" value="this is merchant attach!">
        </td>
    </tr>
    <tr>
        <td width="35%">商品描述</td>
        <td width="40%">
            <input name="goodsDesc" id="goodsDesc" size="70" type="text" value="this is merchant attach!">
        </td>
    </tr>

    <tr bgcolor="#8070FF" align="center">
        <td colspan="2">
            <label>商品信息:</label>是否填写<input type="checkbox" value="1" id="goodsff" name="是" checked="checked"/>
        </td>
    </tr>
    <tr>
        <td colspan="2">
            <table align="center" border="1" cellpadding="0">
                <tbody id="goodsAAA">
                <tr>
                    <td width="35%">商品ID</td>
                    <td>
                        <input name="goodsId" id="goodsId" size="70" type="text">
                    </td>
                </tr>
                <tr>
                    <td width="35%">商品名称</td>
                    <td>
                        <input name="goodsName" id="goodsName" size="70" type="text">
                    </td>
                </tr>
                <tr>
                    <td width="35%">商品数量</td>
                    <td>
                        <input name="goodsCount" id="goodsCount" size="70" type="text">
                    </td>
                </tr>
                <tr>
                    <td width="35%">产品单价</td>
                    <td>
                        <input name="goodsPrice" id="goodsPrice" size="70" type="text">
                    </td>
                </tr>
                </tbody>
            </table>
        </td>
    </tr>

    <tr bgcolor="#8070FF" align="center">
        <td colspan="2">
            <label>付款人信息:</label>是否填写<input type="checkbox" value="1" id="payerInfoff" name="是" checked="checked"/>
        </td>
    </tr>
    <tr>
        <td colspan="2">
            <table align="center" border="1" cellpadding="0">
                <tbody id="payerInfo">
                <tr>
                    <td width="35%">证件类型</td>
                    <td width="40%">
                        <input id="identType" size="70" type="text">
                    </td>
                </tr>
                <tr>
                    <td width="35%">手机号</td>
                    <td width="40%">
                        <input id="mobileNo" size="70" type="text">
                    </td>
                </tr>
                <tr>
                    <td width="35%">身份证号
                    </td>
                    <td width="40%">
                        <input id="idCard" size="70" type="text">
                    </td>
                </tr>
                <tr>
                    <td width="35%">卡号</td>
                    <td width="40%">
                        <input id="cardNo" size="70" type="text">
                    </td>
                </tr>
                <tr>
                    <td width="35%">卡种</td>
                    <td width="40%">
                        <input id="cardType" size="70" type="text">
                    </td>
                </tr>
                <tr>
                    <td width="35%">用户真实姓名</td>
                    <td width="40%">
                        <input id="userRealName" size="70" type="text">
                    </td>
                </tr>
                <tr>
                    <td width="35%">平台用户名</td>
                    <td width="40%">
                        <input id="platUserName" size="70" type="text">
                    </td>
                </tr>
                </tbody>
            </table>
        </td>
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
                        <input id="orderIp" size="70" type="text">
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
                </tbody>
            </table>
        </td>
    </tr>

    <tr bgcolor="#8070FF" align="center">
        <td colspan="2">
            <label>分账信息:</label>是否填写<input type="checkbox" value="1" id="accInfoff" name="是" checked="checked"/>
        </td>
    </tr>
    <tr>
        <td colspan="2">
            <table align="center" border="1" cellpadding="0">
                <tr>
                    <td width="35%">分账冻结标志</td>
                    <td width="40%">
                        <input name="frozenFlag" id="frozenFlag" size="70" type="text" value="1">
                    </td>
                </tr>
                <tr>
                    <td width="35%">分账类型</td>
                    <td width="40%">
                        <input name="royaltyType" id="royaltyType" size="70" type="text" value="1">
                    </td>
                </tr>
                <tr>
                    <td width="35%">金额类型</td>
                    <td width="40%">
                        <select id="amtType" name="amtType">
                            <option value="1" selected="selected">1固定值</option>
                            <option value="2" selected="selected">2百分比</option>
                        </select>
                    </td>
                </tr>
            </table>
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
                    <td>
                        <input type="button" onclick="addDetail()" value="添加"/>
                    </td>
                </tr>
                <tbody id="detail">
                <tr align="center">
                    <td><input name="royaltyTrxId" size="10" type="text"></td>
                    <td><input name="account" size="10" type="text"></td>
                    <td><input name="accountType" size="5" type="text"></td>
                    <td><input name="royaltyAmt" size="10" type="text"></td>
                    <td><input name="desc" size="10" type="text"></td>
                    <td><input type="button" onclick="delDetail(this)" value="删除"/></td>
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
        $("#detail").append('<tr><td><input name="royaltyTrxId" size="10" type="text"></td>' +
            '<td><input name="account" size="10" type="text"></td>' +
            '<td><input name="accountType"  size="5" type="text"></td>' +
            '<td><input name="royaltyAmt"  size="10" type="text"></td>' +
            '<td><input name="desc"  size="10" type="text"></td>' +
            '<td><input  type="button" onclick="delDetail(this)" value="删除"/></td></tr>');
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
        str.platCode = $("#platCode").val();
        str.account = $("#account").val();
        str.trxId = $("#trxId").val();
        str.trxDtTm = $("#trxDtTm").val();
        str.expireDtTm = $("#expireDtTm").val();
        str.trxCcyCd = $("#trxCcyCd").val();
        str.trxAmt = $("#trxAmt").val();
        str.productType = $("#productType").val();
        str.limitPayType = $("#limitPayType").val();
        str.lang = $("#lang option:selected").val();
        str.pageUrl = $("#pageUrl").val();
        str.notifyUrl = $("#notifyUrl").val();
        str.attach = $("#attach").val();
        str.goodsDesc = $("#goodsDesc").val();
        var goodsDetails = [];
        var goodsDesc = {};

        if ($("#goodsff").is(':checked')) {
            goodsDesc.goodsId = $("#goodsId").val();
            goodsDesc.goodsName = $("#goodsName").val();
            goodsDesc.goodsCount = $("#goodsCount").val();
            goodsDesc.goodsPrice = $("#goodsPrice").val();
            goodsDesc.goodsId = $("#goodsId").val();
            goodsDetails.push(goodsDesc);
            str.goodsDetails = goodsDetails;
        }
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
        if ($("#payerInfoff").is(':checked')) {
            var payerInfo = {};
            payerInfo.identType = $("#identType").val();
            payerInfo.mobileNo = $("#mobileNo").val();
            payerInfo.idCard = $("#idCard").val();
            payerInfo.cardNo = $("#cardNo").val();
            payerInfo.cardType = $("#cardType").val();
            payerInfo.userRealName = $("#userRealName").val();
            payerInfo.platUserName = $("#platUserName").val();
            str.payerInfo = payerInfo;
        }

        if ($("#accInfoff").is(':checked')) {
            var royaltyInfo = {};
            var royaltyDetails = [];

            royaltyInfo.frozenFlag = $("#frozenFlag").val();
            royaltyInfo.royaltyType = $("#royaltyType").val();
            royaltyInfo.amtType = $("#amtType").val();

            $("#detail").find("tr").each(function () {
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
            str.royaltyInfo = royaltyInfo;
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
</body>
