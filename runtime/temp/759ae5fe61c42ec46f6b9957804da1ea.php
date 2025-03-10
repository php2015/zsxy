<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:35:"./themes/default/img/imglist01.html";i:1572330131;}*/ ?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>信千金</title>
    <link href="/public/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="/public/bootstrap/css/base.css" rel="stylesheet" type="text/css" />

</head>
<style>
    .container{
        padding:0;
    }
    .circleChart_canvas{
        margin-left: auto;
        margin-right: auto;
        display: block;
        transform: rotate(133deg) ! important ;
        position: absolute;
        top: -107px;
        left: 47px;
    }
    .circleChart_text{
        position: absolute;
        line-height: 100px;
        top: -114px ! important;
        left: 43px;
        width: 104px ! important ;
        margin: 0px;
        padding: 0px;
        color:#f77926;
        text-align: center;
        font-size: 14.2857px;
        font-weight: normal;
        font-family: sans-serif;
    }

    .table>thead>tr>th {
        vertical-align: bottom;
        border-bottom:1px solid #f85220;
        border-left:1px solid #f85220;
    }

    .table {
        width: 100%;
        max-width: 100%;
        margin-bottom: 0px;
    }

    .table>tbody>tr>th,td {
        vertical-align: bottom;
        border-bottom:1px solid #f85220;
        border-left:1px solid #f85220;
    }
    .main{width:100%;position:relative;margin:auto;}
    .layer{position:relative;}
    .layer03-panel{position:relative;float:left;}
    .layer03-left-chart{position:relative;float:left;}
</style>
<body style="">

<div class="container" style="background-color:#fff;    border-bottom: 10px solid #fff;">
   
    <header class="mui-bar-nav" style="-webkit-box-shadow: 0 0 0px rgba(255, 255, 255, 0.85);height: 396px;width: 100%;background-image: url(/public/index/img/proxy04.png);background-size: 100% 100%;background-repeat: no-repeat;">
        <a class="mui-action-back mui-icon mui-icon-left-nav mui-pull-left" style="color: #fff;"></a>
        <p style="position: absolute;top: 278px;left: 30px;right: 30px;color: #fff;font-size: 14px;line-height: 23px;">好友通过您的二维码或者链接注册成为信千金合伙人，自动成为您的下级代理，好友成功推荐用户付费查询，您可以获得收益。</p>
    </header>

    <div style="border: 0px solid #fff6e1;background-color: #fff6e1;margin-right: 20px; margin-left: 20px;border-radius: 9px;margin-top: -23px;    border-bottom: 10px solid #fff6e1;">
        <img src="/public/index/img/proxy02.png" style="width: 80%;margin-top: -36px; margin-left: 37px;">
        <p style="margin-top: -35px;text-align: center;color: #fff;font-size: 15px;font-weight: bold;">简单三步 &nbsp 轻松拿红包</p>

        <div style="margin-left: 14px;margin-top: 25px;line-height: 22px;">
            <p>
                <span style="display: block;width: 21px;border: 1px solid #fa7a19;background: #fa7a19;border-radius: 56%;margin-left: 6px;text-align: center;color: #fff;font-weight: bolder;float: left;">
                    1
                </span>
                <span style=" display: block;margin-left: 37px;font-size: 15px;font-weight: bold;color: #6a6a6a;">
                    点击立即邀请按钮，给好友发送链接或海报
                </span>
            </p>
            <p>
                <span style="display: block;width: 21px;border: 1px solid #fa7a19;background: #fa7a19;border-radius: 56%;margin-left: 6px;text-align: center;color: #fff;font-weight: bolder;float: left;">
                    2
                </span>
                <span style=" display: block;margin-left: 37px;font-size: 15px;font-weight: bold;color: #6a6a6a;">
                    好友通过您的链接或海报扫描后，注册成为代理
                </span>
            </p>
            <p>
                <span style="display: block;width: 21px;border: 1px solid #fa7a19;background: #fa7a19;border-radius: 56%;margin-left: 6px;text-align: center;color: #fff;font-weight: bolder;float: left;">
                    3
                </span>
                <span style=" display: block;margin-left: 37px;font-size: 15px;font-weight: bold;color: #6a6a6a;">
                    好友成功推荐用户查询信千金，您即可获得代理收益
                </span>
            </p>
        </div>
    </div>
    <a href="<?php echo url('index/img/share'); ?>" style="text-decoration: none;color: #fff;">
    <div style="border: 1px solid #f96a1b; background-color: #f96a1b;margin-right: 20px;margin-left: 20px;border-radius: 50px;margin-top: 15px;text-align: center;line-height: 39px;font-size: 18px;">
        立即邀请
    </div>
    </a>
    <div style="background-color: #f96a1b; width: 50%; margin: 25px auto;margin-left: 94px;border-radius: 50px;text-align: center;line-height: 27px;font-size: 18px;margin-right: 102px;">
        <p style="color: #fff;">分佣力度表</p>
    </div>

    <div style="border: 1px solid #f85220;background-color: #fff;margin-right: 20px; margin-left: 20px;border-radius: 9px;">
        <table class="table">
            <thead>
            </thead>
            <tbody>
            	<tr>
                <th style="border-left: 0px solid #fff; text-align: center;">产品</th>
                <td style="text-align: center;">直推奖励</td>
                <td style="text-align: center;">团队奖励</td>
            	</tr>
               <tr>
                <th style="border-left: 0px solid #fff; text-align: center;">资信报告</th>
                <td style="text-align: center;">最高 61.2&nbsp 元</td>
                <td style="text-align: center;">1.5 &nbsp 元</td>
            	</tr>
            </tbody>
        </table>
    </div>
</div>

</div>

</body>
</html>
<script src="/public/bootstrap/js/jquery-2.2.3.min.js"></script>
<script src="/public/bootstrap/js/bootstrap.min.js"></script>