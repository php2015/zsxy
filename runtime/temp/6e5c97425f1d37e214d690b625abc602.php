<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:36:"./themes/calculator/login/index.html";i:1571815575;}*/ ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>登录</title>
    <link rel="stylesheet" href="__PUBLICS__/calculator/admin/css/layui.css">
    <link rel="stylesheet" href="__PUBLICS__/calculator/admin/css/login.css">
</head>
<body>
<div class="main">
    <div class="content">
        <form class="layui-form login-form" style="color:#FFF" action="<?php echo url('/calculator/login/login'); ?>" method="post">
            <input type="text" name="username" placeholder="请输入用户名" required lay-verify="required" autocomplete="off" class="layui-input">
            <input type="password" name="password" placeholder="请输入密码" required lay-verify="required" class="layui-input">
            <button class="layui-btn" lay-submit lay-filter="*" >立即登录</button>
        </form>
    </div>
</div>
</body>
<script src="__PUBLICS__/calculator/admin/js/jquery-1.8.3.min.js"></script>
<script>
    // 定义全局JS变量
    var GV = {
        current_controller:"calculator/<?php echo (isset($controller) && ($controller !== '')?$controller:''); ?>/"
    };
</script>
<script src="__PUBLICS__/calculator/layui/layui.all.js"></script>
<script src="__PUBLICS__/calculator/admin/js/cadmin.js?v=159"></script>
</html>
