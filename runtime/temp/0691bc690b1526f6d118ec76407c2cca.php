<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:33:"./themes/default/user/usertx.html";i:1572062778;}*/ ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>提现</title>
    <link rel="stylesheet" href="__PUBLIC__/css/style.css">
    <link rel="stylesheet" href="__PUBLIC__/css/withdrawal.css">
    <script src="__PUBLIC__/js/jquery.min.js"></script>
    <script src="__PUBLICS__/layer/layer.js"></script>
</head>
<body>
<style>
    .submit_btn {
        width: 6.1rem;
        height: 0.76rem;
        background-image: linear-gradient(87deg, #a051f2 0%, #7536d4 100%), linear-gradient(#8948d2, #8948d2);
        background-blend-mode: normal, normal;
        border-radius: 0.38rem;
        border: none;
        font-size: 0.3rem;
        color: #ffffff;
        display: block;
        margin: 0.8rem auto 0;
    }
</style>
<div class="container">
    <div class="withdrawal_top">
        <div class="money_box">
            <span>￥</span>
            <input type="text" name="money" id="account" value="">
        </div>
        <p class="withdrawal_ti">可提现余额：<?php echo $user['money']; ?></p>
    </div>
    <div class="withdrawal_way">
        <p>
            <span class="choose <?php if(isset($user['banktype']) && $user['banktype'] == "支付宝"): ?>active<?php endif; ?>" data-id='1'></span>支付宝<a class="withdrawal_p" href="<?php echo url('index/user/userskfs1'); ?>"><?php if(isset($user['bankname']) && !empty($user['bankname'])): ?>已绑定支付宝账号<?php else: ?>未绑定支付宝账号<?php endif; ?></a>
        </p>
        <p>
            <span class="choose <?php if(isset($user['banktype']) && $user['banktype'] == "银行卡"): ?>active<?php endif; ?>" data-id='2'></span>银行卡<a class="withdrawal_p" href="<?php echo url('index/user/userskfs'); ?>"><?php if(isset($user['banknumber']) && !empty($user['banknumber'])): ?>已绑定银行卡号<?php else: ?>未绑定银行卡号<?php endif; ?></a>
        </p>
    </div>
    <div class="explain">
        <p>提现说明：</p>
        <p>1、单笔提现金额50元起，上不封顶</p>
        <p>2、工作日半小时内到账</p>
        <p>3、非工作日24小时内到账</p>
        <p>4、支付宝提现请检查是否关闭了通过手机号或邮箱搜索功能，在支付宝设置处，点击隐私，常用隐私设置，打开通过邮箱和手机号找到我。如果关闭，将无法打款。</p>
    </div>
    <input name="type" type="hidden" value="<?php if(isset($user['banktype']) && $user['banktype'] == "支付宝"): ?>1<?php else: ?>2<?php endif; ?>" >
     <input name="phone" type="hidden" value="<?php if(isset($user['phone']) && !empty($user['phone'])): ?><?php echo $user['phone']; endif; ?>" >
    <button class="submit_btn">确定</button>
</div>
</body>
<script>
    $(function () {
        $(".choose").click(function () {
            $(this).addClass("active").parent().siblings().find(".choose").removeClass("active");
            $('input[name=type]:hidden').val($(this).attr('data-id'));
        })
    });

    $('.submit_btn').on('click', function () {
        var account = $('#account').val();
        //很多判断
        if (account == '') {
            layer.msg('金额不能为空');return;
        }
        if (account < 50) {
            layer.msg('提现金额不能低于50元！');return;
        }
        var type = $('input[name=type]:hidden').val();
        var phone = $('input[name=phone]:hidden').val();
        
        if(phone == ''){
        	layer.msg('请去补全提现信息',{time:5000},function(){
        		if(type == 1){
        			window.location.href = "<?php echo url('index/user/userskfs1'); ?>";
        		}else{
        			window.location.href = "<?php echo url('index/user/userskfs1'); ?>";
        		}
        	})
        }
        
        $(this).attr('id', '');
        var loadi = layer.load();
        $.ajax({
            url: "<?php echo url('api/user/usertx'); ?>",
            type: "post",
            datatype: 'json',
            data: {'account': account,'type':type},
            success: function (data) {
                layer.close(loadi);
                if (data == 1) {
                    layer.msg("提现成功!");
                    window.location.href = "<?php echo url('index/index/index'); ?>";
                } else if (data == 0) {
                    layer.msg("提现失败");
                    return false;
                } else if (data == 2) {
                    layer.msg("余额不足");
                    return false;
                } else if (data == 3) {
                    layer.msg("余额不足");
                    return false;
                } else if (data == 4) {
                    layer.msg("你的提现正在审核");
                    return false;
                } else if (data == 5) {
                    layer.msg("请提交账号");
                    if(type == 1){
                    	 window.location.href = "<?php echo url('index/user/userskfs1'); ?>";
                    }else{
                    	 window.location.href = "<?php echo url('index/user/userskfs'); ?>";
                    }
                   
                } else if (data == 6) {
                    layer.msg('提现金额不能低于50！');
                    return false;
                } else if (data == 88) {
                    layer.msg('当天提现不可超过3笔！');
                    return false;
                } else if (data == 11) {
                    layer.msg("请提交账号姓名");
                    window.location.href = "<?php echo url('index/user/userskfs'); ?>";
                } else if (data == 22) {
                    layer.msg("请提交联系手机号");
                    window.location.href = "<?php echo url('index/user/userskfs'); ?>";
                }
            }
        })
        ;
    });
</script>
</html>