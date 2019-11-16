<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:31:"./themes/default/img/share.html";i:1571815558;}*/ ?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>信千金</title>
    <meta name="viewport" content="width=device-width, initial-scale=1,maximum-scale=1, user-scalable=no">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <link rel="stylesheet" href="__PUBLIC__/css/mui.min.css">
    <script src="__PUBLIC__/js/clipboard.min.js"></script>
    <style type="text/css">
        #list {
            /*避免导航边框和列表背景边框重叠，看起来像两条边框似得；*/
            margin-top: -1px;
        }
    </style>
</head>

<body>

<div class="mui-content">
    <div class="mui-popup mui-popup-in" style="display: block;"><div class="mui-popup-inner">
        <div class="mui-popup-title">信千金</div>
        <div class="mui-popup-text">请选择推广方式？</div>
    </div>
        <div class="mui-popup-buttons">
            <input style="text-align: center; font-size:0.1px; z-index:-999; position:absolute;left:100px;" value="<?php echo $lianjie; ?>" id="foo2"  style="width:300px;"  type="text">
            <span class="mui-popup-button copys" data-clipboard-action="copy" data-clipboard-target="#foo2" id="webcopy">生成链接</span>
            <span class="mui-popup-button"><a href="<?php echo url('index/qrc/view',array('imgid'=>3)); ?>">生成二维码</a></span>
        </div>
    </div>
    <div class="mui-popup-backdrop mui-active" style="display: block;"></div>
</div>
<script src="__PUBLIC__/js/jquery.min.js "></script>
<script src="__PUBLIC__/js/mui.min.js"></script>
<script>
    $("#webcopy").on('click',function(){
        var clipboard = new Clipboard('.copys');
        mui.toast('链接复制成功');
        setTimeout(function(){
            window.location.href="<?php echo url('index/index/index'); ?>";
        },1000)
    });
</script>
</body>

</html>