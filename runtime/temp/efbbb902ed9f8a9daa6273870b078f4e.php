<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:31:"./themes/default/index/gzh.html";i:1571922208;}*/ ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no" />
    <title>信千金</title>
    <script src="__PUBLIC__/js/mui.min.js"></script>
    <link href="__PUBLIC__/css/mui.min.css" rel="stylesheet"/>
    <link href="__PUBLIC__/css/style.css" rel="stylesheet"/>
     <script src="__PUBLIC__/js/jquery.min.js"></script>
    <script type="__PUBLIC__/text/javascript" charset="utf-8">
    
        mui.init();
    </script>
    <style>
    	.main{
    		position: fixed;
    		height: 100%;
    		background-image: linear-gradient(131deg, #ff8259 0%, #b65282 50%, #6c21ab 100%), linear-gradient(#6eafff, #6eafff);
    		background-blend-mode: normal, normal;
    	}
    	.success_btn{
    		width:2.6rem;
    		height: 0.8rem;
    		display: block;
    		margin: 0 auto;
    		border-radius: 0.4rem;
    		background-image: linear-gradient(82deg, #ffeca8 12%, #ffda59 84%), linear-gradient(#ffde6b, #ffde6b);
    		background-blend-mode: normal, normal;
    		font-size: 0.36rem;
    		text-align: center;
    		line-height: 0.8rem;
    	}
    </style>
</head>
<body style="background-color: #fff;">
    
    <div class="mui-content"  style="">
        <div class="main">
            
            <div style="text-align: center;padding-top: 20px;position: relative;;">
                 <div style="margin-top: 60px;"><h style="font-size: 36px; color: #f47725; "></h></div>
                <div>

                    <img src="<?php echo $gzh['thumb']; ?>" style="width: 40%;" />

                </div>
                <div style="width: 70%;margin-left: 15%;">
                    <p style="font-size:0.28rem;line-height:0.48rem;color:#fff">尊贵的代理商，欢迎加入信千金报告合伙人大家庭，赶快扫上方二维码或直接关注“信千金英雄会”公众号，登录代理中心，开启您的赚钱之旅吧!</p>
                	<p style="font-size:0.24rem; color: #FFEA9F;margin-top:0.2rem;">提示：公众号内可添加客服微信，有更多福利！</p>
                  
                </div>
                <div style="width: 70%;margin:7% auto;height: 140px;">
                    <a class="success_btn" href="<?php echo url('index/index/index'); ?>">注册成功</a>
                </div>
                
            </div>
        </div>
    </div>
</body>
</html>