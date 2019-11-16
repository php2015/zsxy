<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:35:"./themes/default/user/userskfs.html";i:1572052717;}*/ ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>银行卡绑定</title>
    <link rel="stylesheet" href="__PUBLIC__/css/style.css">
    <link rel="stylesheet" href="__PUBLIC__/css/bindBank.css">
    <script src="__PUBLIC__/js/jquery.min.js"></script>
    <script src="__PUBLICS__/layer/layer.js"></script>
    <style>
    	.container{
    		padding-top: 0;
    	}
    </style>
</head>
<body>
<div class="container">
	<img src="__PUBLIC__/img/bank_top.png" alt="" style="width: 100%;">
    <div class="main">
        <input type="hidden" name="banktype" id="banktype" value="银行卡">
        <input type="text" name="banknumber" id="banknumber" value="<?php echo $user['banknumber']; ?>" placeholder="请输入银行卡号">
        <input type="text" name="wname" id="wname" value="<?php echo $user['wname']; ?>"  placeholder="请输入持卡人姓名">
        <input type="text" name="phone"  id="phone" value="<?php echo $user['phone']; ?>" placeholder="请输入手机号">
        <div class="clearfix"></div>
        <p class="bind_tips">*请确认信息无误</p>
        <button class="submit_btn">确定完成</button>
    </div>
</div>

<script type="text/javascript">
    $(".submit_btn").on('click',function () {
        var banktype = $("#banktype").val();
        var banknumber = $("#banknumber").val();
        var wname = $("#wname").val();
        var phone = $("#phone").val();
        
        var patterns = /^[\u4E00-\u9FA5]{1,6}$/;
        
		var pattern = /^1[3456789]\d{9}$/; 
		
		var patternss = /^[\d]{10,20}$/;

        if (banknumber == '') {
            layer.msg('请填写收款账号');
            return false;
        }
        
        if (!patternss.test(banknumber)) {
            layer.msg('请填写正确的账号');
            return false;
        }
        
        if (phone == ''){
            layer.msg('请填写手机号');
            return false;
        }
        
        if(!pattern.test(phone)){
        	 layer.msg('请填写正确手机号');
            return false;
        }
        
        if (wname == '') {
            layer.msg('请填写收款姓名');
            return false;
        }
        
        if(!patterns.test(wname)){
        	 layer.msg('请填写正确姓名');
            return false;
        }
        
        var ufs = layer.load();
        $.ajax({
            url: "<?php echo url('api/user/userskfs'); ?>",
            type: "post",
            datatype: 'json',
            data: {'banktype': banktype, 'banknumber': banknumber, 'wname': wname, 'phone': phone},
            success: function (data) {
                layer.close(ufs);
                if (data == 1) {
                    layer.msg("绑定成功",{time:500},function(){
                        window.location.href = "<?php echo url('index/user/usertx'); ?>";
                    });
                } else if (data == 0) {
                    layer.msg("绑定失败");
                } else if (data.status == 'error'){
                    return false;
                }
            }
        });

    });
</script>
</body>
</html>