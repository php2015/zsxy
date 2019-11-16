<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:37:"./themes/calculator/index/unlock.html";i:1571815575;}*/ ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>问题解答</title>
    <link rel="stylesheet" href="__PUBLICS__/calculator/css/style.css">
    <link rel="stylesheet" href="__PUBLICS__/calculator/css/index.css">
</head>
<body>
<div class="container">
    <div class="answer_box">
        <p class="answer_ti">1.<?php echo $data['title']; ?></p>
        <div class="answer_cen">
            <img class="cen_pic" src="__PUBLICS__/calculator/img/5.2.png" alt="">
            <div class="cen_right">
                <span></span>
                <p>专业律师团队<br/>为您解答</p>
            </div>
        </div>
        <div class="answer_txt">
            <p style="font-size:0.24rem;">首先，法律规定：</p>
            <p style="font-size:0.24rem;"><?php echo mb_substr($data['content'],0,40,'utf-8'); ?></p>
           
        </div>
        <div style="width: 100%;position: relative;margin-top: -4%;">
        	<img src="__PUBLICS__/calculator/img/5.1.jpg" alt="" style="width: 100%;">
        </div>

    </div>
    <a href="<?php echo url('/calculator/pay/pay',['id'=>$data['id'],'price'=>$data['price']]); ?>"><div class="answer_bot">
        <p style="font-size: 0.4rem;">点击解锁查看<span style="font-size: 0.2rem;">（需付费<?php echo $data['price']; ?>元）</span></p>
    </div></a>
</div>
</body>
</html>
<script src="__PUBLIC__/js/jquery.min.js"></script>
<script src="/public/layer/layer.js"></script>
<script text="">
</script>