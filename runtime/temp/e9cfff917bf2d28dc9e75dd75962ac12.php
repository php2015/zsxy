<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:33:"./themes/default/login/login.html";i:1571993597;}*/ ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>登录</title>
    <link rel="stylesheet" href="__PUBLIC__/css/style.css">
    <link rel="stylesheet" href="__PUBLIC__/css/login.css">
</head>
<body>
<style>
    .login{
        width: 1.4rem;
        width: 1.3rem;
        height: 1.3rem;
        margin: 0.2rem 0.25rem 0.3rem;
    }
</style>
<div class="container">
    <div class="logo_box">
        <img class="login" src="<?php echo $login['thumb']; ?>" alt="">
    </div>
    <div class="login_box">
        <p class="login_p">登录</p>
        <div class="ipt_box">
            <img src="__PUBLIC__/img/phone.png" alt="">
            <input id="usernames" name="username" type="text" placeholder="输入手机号">
        </div>
        <div class="ipt_box">
            <img src="__PUBLIC__/img/password.png" alt="">
            <input id="password" name="password"  type="password" placeholder="输入密码">
        </div>
       <p class="forget"><a href="<?php echo url('index/login/weixin'); ?>">忘记密码？</a></p>
        <button class="login_btn" id="btn">立即登录</button>
        <div class="clearfix"></div>
        <p class="register"><a href="<?php echo url('index/login/daili'); ?>">注册代理</a></p>
    </div>
</div>
</body>
</html>

<script type="text/javascript" src="__PUBLIC__/js/jquery.min.js" ></script>
<script type="text/javascript" src="__PUBLICS__/layer/layer.js" ></script>
<script type="text/javascript">
    $('#btn').on('click',function(){
        var username =$("#usernames").val();
        var password = $("#password").val();
        if(username == ''){
            layer.msg('手机号码不能为空');
            return false;
        }
        if(password == ''){
            layer.msg('密码不能为空');
            return false;
        }
        $.ajax({
            url:"<?php echo url('api/login/login'); ?>",
            type:"post",
            datatype:'json',
            data:{'mid':username,'password':password},
            success:function(data){
                if(data.status=='success'){
                    if(data.isStaff == 1){
                        window.location.href = "<?php echo url('index/yindex'); ?>";
                    }else {
                        window.location.href = "<?php echo url('index/index'); ?>";
                    }
                } else if(data.status=='edit'){
                        window.location.href="<?php echo url('index/login/editpd'); ?>";
                }else if(data.status=='error'){
                    layer.msg(data.msg);
                    return false;
                }
            }
        })
    })
</script>
</body>
</html>