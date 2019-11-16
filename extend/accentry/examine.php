<?php require_once ("config/AccEntryConfig.php"); ?>
<head>
    <title>影印件上传接口</title>
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
           value="<?php echo $accEntryConfig['ipsURL']; ?>/user/photocopy/upload">
</form>
<table align="center" border="1" cellpadding="3" cellspacing="0" width="600" bgcolor="#F0F0FF">
    <tr bgcolor="#8070FF">
        <td colspan="2" align="center">
            <span style="color: #FFFF00; "><b>影印件上传接口</b></span>
        </td>
    </tr>
    <?php include_once('newapi.php'); ?>
    <tr>
        <td width="35%">
            <label>平台编号:</label>
        </td>
        <td width="65%">
            <input type="text" width="65%" id="platCode" name="platCode">
        </td>
    </tr>
    <tr>
        <td width="35%">
            <label>平台用户ID(必填):</label>
        </td>
        <td width="65%">
            <input type="text" width="65%" id="ipsUserId" name="ipsUserId">
        </td>
    </tr>
    <tr>
        <td width="35%">
            <label>商户订单号(必填):</label>
        </td>
        <td width="65%">
            <input type="text" width="65%" id="trxId" name="trxId" value="<?php echo $accEntryConfig['merBillNo']; ?>">
        </td>
    </tr>
    <tr>
        <td width="35%">
            <label>订单时间(必填):</label>
        </td>
        <td width="65%">
            <input type="text" width="65%" id="trxDtTm" name="trxDtTm" value="<?php echo $accEntryConfig['date']; ?>">
        </td>
    </tr>
    <tr>
        <td width="35%">影印件类型</td>
        <td width="65%">
            <select name="copyType" id="copyType" style="width: 115px" onchange="changeType()">
                <option selected="selected" value="1">个人身份证</option>
                <option value="2">企业证件</option>
                <option value="3">企业法人身份证</option>
            </select>
        </td>
    </tr>
    <tr>
			<td width="35%">影印件文件</td>
			<td width="65%">
				<div id="enterprise" style="display: none">
					企业证件：&nbsp;&nbsp;&nbsp;<input id="enterpriseCertificate"
						type="file" onchange="previewFile(2)">
				</div>
				<div id="identityCard">
					身份证正面：<input id="frontOfIdentityCard" type="file"
						onchange="previewFile(1)"><br> 身份证反面：<input id="reverseIdCard"
						type="file" onchange="previewFile(3)"><br>
				</div>
			</td>
		</tr>
    <tr>
        <td width="35%">
            <label>异步通知地址(必填):</label>
        </td>
        <td width="65%">
            <input type="text" width="65%" id="notifyUrl" name="notifyUrl">
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
	var certInfo = {};
    function submitForm() {
        var jsonStr = [];
        var str = {};
        //商户请做各必填项的非空校验
        str.account = $("#account").val();
        str.platCode = $("#platCode").val();
        str.platUserName = $("#platUserName").val();
        str.ipsUserId = $("#ipsUserId").val();
        str.trxId = $("#trxId").val();
        str.trxDtTm = $("#trxDtTm").val();
        str.copyType = $("#copyType").val();
        str.notifyUrl = $("#notifyUrl").val();
        str.certInfo = certInfo;
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

    function changeType() {
        var copyType = $("#copyType").val();
        if (copyType === '2') {
            console.log(2);
            $("#enterprise").show();
            $("#identityCard").hide();
        } else {
            console.log(1);
            $("#enterprise").hide();
            $("#identityCard").show();
        }
    }
    
    function previewFile(type) {
        //获取选中图片对象（包含文件的名称、大小、类型等，如file.size）
        var file;
        if (type === 1) {
            file = document.getElementById("frontOfIdentityCard").files[0];
        } else if (type === 2) {
            file = document.getElementById("enterpriseCertificate").files[0];
        } else {
            file = document.getElementById("reverseIdCard").files[0];
        }
        //声明js的文件流
        var reader = new FileReader();
        if (file) {
            //通过文件流将文件转换成Base64字符串
            reader.readAsDataURL(file);
            //转换成功后
            reader.onloadend = function () {
                if (type === 1) {
                    certInfo.identityFront = reader.result;
                } else if (type === 2) {
                    certInfo.enterpriseFront = reader.result;
                } else {
                    certInfo.identityContrary = reader.result;
                }
            }
        }
    }
</script>
</body>
