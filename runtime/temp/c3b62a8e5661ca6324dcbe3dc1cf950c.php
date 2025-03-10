<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:33:"./themes/default/login/daili.html";i:1571908852;}*/ ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>注册</title>
    <link rel="stylesheet" href="__PUBLIC__/css/style.css">
    <link rel="stylesheet" href="__PUBLIC__/css/login.css">
    <script src="__PUBLIC__/js/jquery.min.js"></script>
    <script src="__PUBLICS__/layer/layer.js"></script>
</head>
<style>
    .login {
        width: 1.4rem;
        width: 1.3rem;
        height: 1.3rem;
        margin: 0.2rem 0.25rem 0.3rem;
    }
</style>
<body>
<div class="container">
    <div class="logo_box">
        <img class="login" src="<?php echo $login['thumb']; ?>" alt="">
    </div>
    <div class="login_box">
        <p class="login_p">注册</p>
        <div class="ipt_box">
            <img src="__PUBLIC__/img/username.png" alt="">
            <input type="text" id="username" name="username" placeholder="请输入姓名">
        </div>
        <div class="ipt_box">
            <img src="__PUBLIC__/img/phone.png" alt="">
            <input type="text" id="mobile" name="mobile" placeholder="请输入手机号">
        </div>
        <div class="ipt_box">
            <img src="__PUBLIC__/img/password.png" alt="">
            <input type="password" id="password" name="password" placeholder="请输入密码">
        </div>
        <div class="ipt_box">
            <img src="__PUBLIC__/img/password.png" alt="">
            <input type="password" id="qrpassword" name="qrpassword" placeholder="请确认密码">
        </div>
        <label data-v-22c62a4e="" class="protocol" style="font-size:14px;clear: both;padding: 0px;">
            <input id="radio" name="radio" type="checkbox" class="radio" style="margin-left: 32px;">
            <span data-v-22c62a4e="" class="checkbox radioInput"></span>
            我已阅读并同意<a href="<?php echo url('index/login/protocol'); ?>" style="color: #f7572d;">《用户注册协议》</a>
        </label>
        <button class="login_btn">注册代理</button>
        <div class="clearfix"></div>
    </div>
</div>


<script type="text/javascript">
    $(".login_btn").on('click',function () {
        var username = $("#username").val();
        var password = $("#password").val();
        var qrpassword = $("#qrpassword").val();
        if (qrpassword != password) {
            layer.msg('两次输入密码不一样');
            return false;
        }
        var mobile = $("#mobile").val();
        var code = $("#code").val();
        var pid = $("#pid").val();
        var radio = $('input[name="radio"]:checked').val();
        if (mobile == '') {
            layer.msg('手机号码不能为空');
            return false;
        }
        if (mobile.length !== 11) {
            layer.msg("手机号码格式不正确！");
            return false;
        }
        if (radio == null || radio == undefined || radio == "") {
            layer.msg('请确认查询协议');
            return false;
        }
        if (username == '') {
            layer.msg('姓名不能为空');
            return false;
        }
        if (password == '') {
            layer.msg('密码不能为空');
            return false;
        }
        if (code == '') {
            layer.msg('验证码不能为空');
            return false;
        }
        $.ajax({
            url: "<?php echo url('api/login/zhuce'); ?>",
            type: "post",
            datatype: 'json',
            data: {'username': username, 'mobile': mobile, 'password': password, 'code': code, 'pid': pid},
            success: function (data) {
                if (data == 1) {
                    layer.msg("注册成功");
                    window.location.href = "<?php echo url('index/gzh'); ?>";
                } else if (data == 2) {
                    layer.msg("验证码不正确!");
                    return false;
                } else if (data == 3) {
                    layer.msg("身份证已经注册过!");
                    return false;
                } else if (data == 4) {
                    layer.msg("手机号已经注册过!");
                    return false;
                } else if (data == 0) {
                    layer.msg("注册失败");
                    return false;
                }else if (data == 20) {
                    layer.msg("姓名重复");
                    return false;
                }
            }
        });
    });
</script>


</body>
</html>