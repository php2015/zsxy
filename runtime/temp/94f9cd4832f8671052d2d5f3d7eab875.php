<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:33:"./themes/default/index/index.html";i:1571921728;}*/ ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>个人中心</title>
    <link rel="stylesheet" href="__PUBLIC__/css/iconfont.css">
    <link rel="stylesheet" href="__PUBLIC__/css/style.css">
    <link rel="stylesheet" href="__PUBLIC__/css/user.css">
    <script src="__PUBLIC__/js/jquery.min.js"></script>
    <script type="text/javascript" src="__PUBLICS__/layer/layer.js" ></script>
</head>
<body>
<div class="container">
    <div class="head_box">
        <div class="head_top clearfix">
            <a href="<?php echo url('index/user/userinfo'); ?>"><img class="head_left" src="__PUBLIC__/img/head_pic.png" alt=""></a>
            <div class="head_cen">
                <p><?php echo $user['mobile']; ?></p>
                <p>ID：<?php echo $user['id']; ?></p>
            </div>
            <div class="head_right clearfix">
                <img src="__PUBLIC__/img/ranking.png" alt="">
                <img src="__PUBLIC__/img/icon_message.png" alt="">
            </div>
        </div>

        <p class="notice">
            <span style="display: block;float: left;">通知</span>
            <marquee scrollamount="5" id="ad-main" style="float: left;width: 74%;">
                <?php echo $str_msg; ?>
            </marquee>
            <button>查看</button>
        </p>
    </div>
    <div class="income_box clearfix">
        <div class="income_item">
            <p><?php echo $user['total_achievement']; ?></p>
            <p>总收入</p>
        </div>
        <div class="income_item">
            <p><?php echo $user['money']; ?></p>
            <p>余额</p>
        </div>
        <div class="income_item">
  
           <p><?php if(!empty($profit_id)): ?><?php echo $profit_id; else: ?>0.00<?php endif; ?></p>
            <p>已提现金额</p>
        </div>
        <div class="withdrawal_box"><a href="<?php echo url('user/usertx'); ?>">提现</a></div>
    </div>
    <div class="banner_box clearfix">
        <img src="<?php echo $gr['thumb']; ?>" alt="">
    </div>
    <div class="tab_box clearfix">
        <div class="tab_item">
            <a href="<?php echo url('index/img/imglist'); ?>">
                <img src="__PUBLIC__/img/icon_invite.png" alt="">
                <p>邀请代理</p>
            </a>
        </div>
        <div class="tab_item">
            <a href="<?php echo url('user/tuandui'); ?>">
                <img src="__PUBLIC__/img/icon_team.png" alt="">
                <p>我的团队</p>
            </a>
        </div>
        <div class="tab_item">
            <a href="<?php echo url('user/chaxunjilu'); ?>">
                <img src="__PUBLIC__/img/icon_order.png" alt="">
                <p>我的客户</p>
            </a>
        </div>
        <div class="tab_item daili">
            <a href="javascript:;">
                <img src="__PUBLIC__/img/icon_upload.png" alt="">
                <p>升级代理</p>
            </a>
        </div>
        <div class="tab_item">
            <a href="<?php echo url('index/index/onenote','id=4'); ?>">
                <img src="__PUBLIC__/img/icon_operate.png" alt="">
                <p>操作说明</p>
            </a>
        </div>
        <div class="tab_item">
            <a href="<?php echo url('index/index/bang'); ?>">
                <img src="__PUBLIC__/img/icon_rank.png" alt="">
                <p>排行榜</p>
            </a>
        </div>
        <div class="tab_item">
            <a href="<?php echo url('index/index/weixin'); ?>">
                <img src="__PUBLIC__/img/icon_customer.png" alt="">
                <p>联系客服</p>
            </a>
        </div>
        <div class="tab_item">
            <a href="<?php echo url('index/user/feedback'); ?>">
                <img src="__PUBLIC__/img/icon_feed.png" alt="">
                <p>意见反馈</p>
            </a>
        </div>
        <div class="tab_item">
            <a href="<?php echo url('index/login/tuichu'); ?>">
                <img src="__PUBLIC__/img/icon_quit.png" alt="">
                <p>退出</p>
            </a>
        </div>
    </div>
    <div class="footer">
        <div class="tabbar">
            <a href="<?php echo url('index/index/home'); ?>">
                <p><span class="iconfont icon-shouye"></span></p>
                <p>首页</p>
            </a>
        </div>
        <div class="tabbar zixun">
            <p><span class="iconfont icon-zixun-dianji"></span></p>
            <p>资讯广场</p>
        </div>
        <div class="tabbar">
            <a href="<?php echo url('index/index/mingxi'); ?>">
                <p><span class="iconfont icon-qianbao"></span></p>
                <p>收入明细</p>
            </a>
        </div>
        <div class="tabbar active">
            <a href="<?php echo url('index/index/index'); ?>">
                <p><span class="iconfont icon-wode"></span></p>
                <p>个人中心</p>
            </a>
        </div>
    </div>
</div>
</body>
<script>
    $(function () {
    	
    	 $('.daili').on('click',function(){
    			layer.msg('暂未开放');
    	});
    	
    	$('.zixun').on('click',function(){
    			layer.msg('暂未开放');
    	});
    	
        $(".tabbar").click(function () {
            $(this).addClass("active").siblings().removeClass("active")
        })
    })
</script>
</html>