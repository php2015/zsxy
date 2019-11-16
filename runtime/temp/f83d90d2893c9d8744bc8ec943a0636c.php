<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:36:"./themes/default/user/userskfs1.html";i:1572073704;}*/ ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>支付宝绑定</title>
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
	<img src="__PUBLIC__/img/alipay_top.png" alt="" style="width: 100%;">
    <div class="main">
    	
        <input type="hidden" name="banktype" id="banktype" value="支付宝">
        <input type="text" name="phone"  id="phone" value="<?php echo $user['phone']; ?>" placeholder="请输入手机号">
        <input type="text" name="banknames" id="banknames" value="<?php echo $user['bankname']; ?>" placeholder="请输入支付宝账号">
        <input type="text" name="wname" id="wname" value="<?php echo $user['wname']; ?>" placeholder="请输入真实姓名">
        <div class="clearfix"></div>
        <p class="bind_tips">*请确认信息无误</p>
        <button class="submit_btn">确定完成</button>
    </div>
</div>


<script type="text/javascript">
    $(".submit_btn").on('click',function () {
        var banktype = $("#banktype").val();
        var wname = $("#wname").val();
        var banknames = $("#banknames").val();
        var phone = $("#phone").val();
        
        var patterns = /^[\u4E00-\u9FA5]{1,6}$/;
        
		var pattern = /^1[3456789]\d{9}$/; 

        if (banknames == '') {
            layer.msg('请填写收款账号');
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
        
         if (phone == ''){
            layer.msg('请填写手机号');
            return false;
        }
        
        if(!pattern.test(phone)){
        	 layer.msg('请填写正确手机号');
            return false;
        }
        
        var ufs = layer.load();
        $.ajax({
            url: "<?php echo url('api/user/userskfs'); ?>",
            type: "post",
            datatype: 'json',
            data: {'banktype': banktype, 'banknames': banknames, 'wname': wname, 'phone': phone},
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