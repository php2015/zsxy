<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:35:"./themes/default/user/userInfo.html";i:1571903641;}*/ ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>基本信息</title>
    <link rel="stylesheet" href="__PUBLIC__/css/style.css">
    <link rel="stylesheet" href="__PUBLIC__/css/userInfo.css">
</head>
<body>
<div class="container">
    <div class="main">
        <ul>
            <li>
                用户头像
                <span><img src="__PUBLIC__/img/head_pic.png" alt=""></span>
            </li>
            <li>
                手机号
                <span><?php echo $user['mobile']; ?></span>
            </li>
            <li>
                提现支付宝
                <a href="<?php echo url('index/user/userskfs1'); ?>" ><span class="no_bind"><?php if(isset($user['bankname']) && !empty($user['bankname'])): ?>已设置<?php else: ?>未设置<?php endif; ?></span></a>
            </li>
            <li>
                提现银行卡
                <a href="<?php echo url('index/user/userskfs'); ?>" ><span class="no_bind"><?php if(isset($user['banknumber']) && !empty($user['banknumber'])): ?>已设置<?php else: ?>未设置<?php endif; ?></span></a>
            </li>
            <li>
                代理级别
                <span>暂无</span>
            </li>
            <li>
                会员ID
                <span><?php echo $user['id']; ?></span>
            </li>
        </ul>
    </div>
</div>
</body>
</html>