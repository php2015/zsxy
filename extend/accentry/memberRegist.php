<?php
require_once ("config/AccEntryConfig.php");
?>
<html>
<head>
    <title>会员注册开户接口</title>
</head>
<body bgcolor="#FFFFFF" style="text-align: center;">
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
           value="<?php echo $accEntryConfig['ipsURL']; ?>/user/register">
</form>
<table align="center" border="1" cellpadding="3" cellspacing="0" width="600" bgcolor="#F0F0FF">
    <tr bgcolor="#8070FF">
        <td colspan="2" align="center">
            <span style="color: #FFFF00; "><b>会员注册开户接口</b></span>
        </td>
    </tr>
    <?php include_once('newapi.php'); ?>
    <tr>
        <td width="35%">
            <label>账户号(必填):</label>
        </td>
        <td width="65%">
            <input type="text" width="65%" id="account">
        </td>
    </tr>
    <tr>
        <td width="35%">
            <label>平台编号(必填):</label>
        </td>
        <td width="65%">
            <input type="text" width="65%" id="platCode">
        </td>
    </tr>

    <tr>
        <td width="35%">
            <label>平台用户名(必填):</label>
        </td>
        <td width="65%">
            <input type="text" width="65%" id="platUserName">
        </td>
    </tr>
    <tr>
        <td width="35%">用户类型(必填)</td>
        <td width="65%">
            <select id="userType" style="width: 115px">
                <option selected="selected" value="2">个人</option>
                <option value="1">企业</option>
            </select>
        </td>
    </tr>

    <tr>
        <td width="35%">是否免密</td>
        <td width="65%">
            <select id="isOpenPwd" style="width: 115px">
                <option selected="selected" value="1">不开通</option>
                <option value="2">开通</option>
            </select>
        </td>
    </tr>
    <tr>
        <td width="35%">
            <label>短信验证码:</label>
        </td>
        <td width="65%">
            <input type="text" width="65%" id="smsCode">
        </td>
    </tr>
    <tr>
        <td width="35%">
            <label>短信编号:</label>
        </td>
        <td width="65%">
            <input type="text" width="65%" id="smsId">
        </td>
    </tr>
    <tr bgcolor="#FFFFFF">
        <td width="100%" colspan="2">
            <label>UserInfo:个人用户信息</label>
        </td>
    </tr>
    <tr>
        <td width="35%">
            <label>用户姓名(必填):</label>
        </td>
        <td width="65%">
            <input type="text" width="65%" id="userName">
        </td>
    </tr>
    <tr>
        <td width="35%">
            <label>证件号(必填):</label>
        </td>
        <td width="65%">
            <input type="text" width="65%" id="certId">
        </td>
    </tr>
    <tr>
        <td width="35%">
            <label>手机号(必填):</label>
        </td>
        <td width="65%">
            <input type="text" width="65%" id="userMobile">
        </td>
    </tr>
    <tr>
        <td width="35%">
            <label>开户行号:</label>
        </td>
        <td width="65%">
            <input type="text" width="65%" id="bankId">
        </td>
    </tr>
    <tr>
        <td width="35%">
            <label>银行卡号:</label>
        </td>
        <td width="65%">
            <input type="text" width="65%" id="cardNo">
        </td>
    </tr>
    <tr>
        <td width="35%">
            <label>证件有效期:</label>
        </td>
        <td width="65%">
            <input type="text" width="65%" id="valiDate">(YYYYMMDD)
        </td>
    </tr>
    <tr>
        <td width="35%">
            <label>住址:</label>
        </td>
        <td width="65%">
            <input type="text" width="65%" id="custAddress">
        </td>
    </tr>
    <tr>
        <td width="35%">
            <label>职业:</label>
        </td>
        <td width="65%">
            <input type="text" width="65%" id="professional">
        </td>
    </tr>
    <tr>
        <td width="35%">
            <label>邮箱:</label>
        </td>
        <td width="65%">
            <input type="text" width="65%" id="userEmail">
        </td>
    </tr>
    <tr bgcolor="#FFFFFF">
        <td width="100%" colspan="2">
            <label>BusinessInfo:企业用户信息</label>
        </td>
    </tr>
    <tr>
        <td width="35%">
            <label>企业名称(必填):</label>
        </td>
        <td width="65%">
            <input type="text" width="65%" id="corpName">
        </td>
    </tr>
    <tr>
        <td width="35%">
            <label>营业执照注册号:</label>
        </td>
        <td width="65%">
            <input type="text" width="65%" id="businessCode">
        </td>
    </tr>
    <tr>
        <td width="35%">
            <label>组织机构代码:</label>
        </td>
        <td width="65%">
            <input type="text" width="65%" id="institutionCode">
        </td>
    </tr>
    <tr>
        <td width="35%">
            <label>税务登记号:</label>
        </td>
        <td width="65%">
            <input type="text" width="65%" id="taxCode">
        </td>
    </tr>
    <tr>
        <td width="35%">
            <label>统一信用代码:</label>
        </td>
        <td width="65%">
            <input type="text" width="65%" id="socialCreditCode">
        </td>
    </tr>
    <tr>
        <td width="35%">
            <label>证照起始日期(必填):</label>
        </td>
        <td width="65%">
            <input type="text" width="65%" id="licenseStartDate">(YYYYMMDD)
        </td>
    </tr>
    <tr>
        <td width="35%">
            <label>证照结束日期(必填):</label>
        </td>
        <td width="65%">
            <input type="text" width="65%" id="licenseEndDate">(YYYYMMDD)
        </td>
    </tr>
    <tr>
        <td width="35%">
            <label>企业经营地址(必填):</label>
        </td>
        <td width="65%">
            <input type="text" width="65%" id="corpBusinessAddress">
        </td>
    </tr>
    <tr>
        <td width="35%">
            <label>企业注册地址(必填):</label>
        </td>
        <td width="65%">
            <input type="text" width="65%" id="corpRegAddress">
        </td>
    </tr>
    <tr>
        <td width="35%">
            <label>企业固定电话(必填):</label>
        </td>
        <td width="65%">
            <input type="text" width="65%" id="corpFixedTelephone">
        </td>
    </tr>
    <tr>
        <td width="35%">
            <label>经营范围(必填):</label>
        </td>
        <td width="65%">
            <input type="text" width="65%" id="businessScope">
        </td>
    </tr>
    <tr>
        <td width="35%">
            <label>法人姓名(必填):</label>
        </td>
        <td width="65%">
            <input type="text" width="65%" id="legalName">
        </td>
    </tr>

    <tr>
        <td width="35%">法人证件类型(必填)</td>
        <td width="65%">
            <select id="legalCertType" style="width: 115px">
                <option selected="selected" value="01">身份证</option>
                <option value="02">护照</option>
                <option value="03">港澳台居民通行证</option>
                <option value="04">外国人永久居留证</option>
            </select>
        </td>
    </tr>
    <tr>
        <td width="35%">
            <label>法人证件号码(必填):</label>
        </td>
        <td width="65%">
            <input type="text" width="65%" id="legalCertId" name="legalCertId">
        </td>
    </tr>
    <tr>
        <td width="35%">
            <label>法人证件起始日期(必填):</label>
        </td>
        <td width="65%">
            <input type="text" width="65%" id="legalCertStartDate" name="legalCertStartDate">(YYYYMMDD)
        </td>
    </tr>
    <tr>
        <td width="35%">
            <label>法人证件结束日期(必填):</label>
        </td>
        <td width="65%">
            <input type="text" width="65%" id="legalCertEndDate" name="legalCertEndDate">(YYYYMMDD)
        </td>
    </tr>
    <tr>
        <td width="35%">
            <label>法人手机号(必填):</label>
        </td>
        <td width="65%">
            <input type="text" width="65%" id="legalMobile" name="legalMobile">
        </td>
    </tr>
    <tr>
        <td width="35%">
            <label>企业联系人姓名(必填):</label>
        </td>
        <td width="65%">
            <input type="text" width="65%" id="contactName" name="contactName">
        </td>
    </tr>
    <tr>
        <td width="35%">
            <label>联系人手机号(必填):</label>
        </td>
        <td width="65%">
            <input type="text" width="65%" id="contactMobile" name="contactMobile">
        </td>
    </tr>
    <tr>
        <td width="35%">
            <label>联系人邮箱:</label>
        </td>
        <td width="65%">
            <input type="text" width="65%" id="contractEmail" name="contractEmail">
        </td>
    </tr>
    <tr>
        <td width="35%">
            <label>开户银行账户名(必填):</label>
        </td>
        <td width="65%">
            <input type="text" width="65%" id="bankAcctName" name="bankAcctName">
        </td>
    </tr>
    <tr>
        <td width="35%">
            <label>开户银行(必填):</label>
        </td>
        <td width="65%">
            <input type="text" width="65%" id="corpBankId" name="corpBankId">
        </td>
    </tr>
    <tr>
        <td width="35%">
            <label>开户银行账户(必填):</label>
        </td>
        <td width="65%">
            <input type="text" width="65%" id="bankAcctNo" name="bankAcctNo">
        </td>
    </tr>
    <tr>
        <td width="35%">
            <label>开户银行支行名称:</label>
        </td>
        <td width="65%">
            <input type="text" width="65%" id="bankBranch" name="bankBranch">
        </td>
    </tr>
    <tr>
        <td width="35%">
            <label>开户行省份:</label>
        </td>
        <td width="65%">
            <input type="text" width="65%" id="bankProv" name="bankProv">
        </td>
    </tr>
    <tr>
        <td width="35%">
            <label>开户银行地区:</label>
        </td>
        <td width="65%">
            <input type="text" width="65%" id="bankArea" name="bankArea">
        </td>
    </tr>
    <tr>
        <td width="35%">
            <label>行业:</label>
        </td>
        <td width="65%">
            <input type="text" width="65%" id="industry" name="industry">
        </td>
    </tr>
    <tr>
        <td colspan="2" align="center">
            <input type="button" value="提交" onclick="submitForm()"/>
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
        str.platCode = $("#platCode").val();
        str.platUserName = $("#platUserName").val();
        str.userType = $("#userType").val();
        str.isOpenPwd = $("#isOpenPwd").val();
        str.smsCode = $("#smsCode").val();
        str.smsId = $("#smsId").val();

        var uInfo = {};
        uInfo.userName = $("#userName").val();
        uInfo.certId = $("#certId").val();
        uInfo.userMobile = $("#userMobile").val();
        uInfo.bankId = $("#bankId").val();
        uInfo.cardNo = $("#cardNo").val();
        uInfo.valiDate = $("#valiDate").val();
        uInfo.custAddress = $("#custAddress").val();
        uInfo.professional = $("#professional").val();
        uInfo.userEmail = $("#userEmail").val();

        var bInfo = {};
        bInfo.corpName = $("#corpName").val();
        bInfo.businessCode = $("#businessCode").val();
        bInfo.institutionCode = $("#institutionCode").val();
        bInfo.taxCode = $("#taxCode").val();
        bInfo.socialCreditCode = $("#socialCreditCode").val();
        bInfo.licenseStartDate = $("#licenseStartDate").val();
        bInfo.licenseEndDate = $("#licenseEndDate").val();
        bInfo.corpBusinessAddress = $("#corpBusinessAddress").val();
        bInfo.corpRegAddress = $("#corpRegAddress").val();
        bInfo.corpFixedTelephone = $("#corpFixedTelephone").val();
        bInfo.businessScope = $("#businessScope").val();
        bInfo.legalName = $("#legalName").val();
        bInfo.legalCertType = $("#legalCertType").val();
        bInfo.legalCertId = $("#legalCertId").val();
        bInfo.legalCertStartDate = $("#legalCertStartDate").val();
        bInfo.legalCertEndDate = $("#legalCertEndDate").val();
        bInfo.legalMobile = $("#legalMobile").val();
        bInfo.contactName = $("#contactName").val();
        bInfo.contactMobile = $("#contactMobile").val();
        bInfo.contractEmail = $("#contractEmail").val();
        bInfo.bankAcctName = $("#bankAcctName").val();
        bInfo.bankId = $("#corpBankId").val();
        bInfo.bankAcctNo = $("#bankAcctNo").val();
        bInfo.bankBranch = $("#bankBranch").val();
        bInfo.bankProv = $("#bankProv").val();
        bInfo.bankArea = $("#bankArea").val();
        bInfo.industry = $("#industry").val();


        str.userInfo = uInfo;
        str.businessInfo = bInfo;

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
