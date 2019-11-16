<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:34:"./themes/default/user/tuandui.html";i:1572431572;}*/ ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>我的团队</title>
    <link rel="stylesheet" href="__PUBLIC__/css/mui.min.css">
    <link rel="stylesheet" href="__PUBLIC__/css/style.css">
    <link rel="stylesheet" href="__PUBLIC__/css/team.css">
    <script src="__PUBLIC__/js/jquery.min.js"></script>
    <script src="__PUBLIC__/js/mui.min.js"></script>
</head>
<body>
<style>
    .timeimg {
        width: 0.26rem;
        position: absolute;
        top: 86%;
        right: 1.06rem;
        transform: translateY(-50%);
    }
    .mui-pull{
    	bottom: 0!important;
    }
    .mui-table-view:before,.mui-table-view:after{
    	display: none;
    }
    .mui-scroll-wrapper::-webkit-scrollbar { 
    	display: none;
    }
</style>
<div class="container">
    <div class="colour_bg"></div>
    <div class="team_top">
        <div class="top_head clearfix">
            <div class="head_item">
                <p><?php if(isset($aget_sum) && !empty($aget_sum)): ?><?php echo $aget_sum; else: ?>0<?php endif; ?></p>
                <p>团队总人数</p>
            </div>
            <div class="head_item">
                <p><?php if(isset($agent_price) && !empty($agent_price)): ?><?php echo $agent_price; else: ?>0<?php endif; ?></p>
                <p>团队总佣金</p>
            </div>
            <div class="head_item">
                <p><?php if(isset($agent_price_day) && !empty($agent_price_day)): ?><?php echo $agent_price_day; else: ?>0<?php endif; ?></p>
                <p>团队今日佣金</p>
            </div>
        </div>
        <p class="invite">邀请我的人</p>
        <div class="invite_box clearfix">
            <div class="invite_left">
                <img src="__PUBLIC__/img/head_pic.png" alt="">
            </div>
            <div class="invite_right">
                <p class="user_num"><?php echo $agent['mobiles']; ?></p>
                <p class="user_id">ID:<?php echo $agent['id']; ?></p>
                <p class="active_time">上次活跃时间：<?php if(isset($agent['create_time']) && !empty($agent['create_time'])): ?><?php echo date("Y-m-d H:i",$agent['create_time']); else: endif; ?></p>
            </div>
        </div>
    </div>
    <div class="list_box">
        <p class="invite invite1">我邀请的人</p>
        <input class="search_ipt" type="text" value="<?php echo $name; ?>" id="name" name="name" placeholder="搜索ID或手机号">
        <img src="__PUBLIC__/img/icon_search.png" alt="" class="timeimg" id="btn">
        <div class="clearfix"></div>
        <div class="mui-content mui-scroll-wrapper order_box" style="margin-top:81%;padding-top:0px;height:360px;" id="pullrefresh">
            <div class="mui-scroll" style="padding:0;margin:0;background-color: #efeff4;">
                <div class="mui-content-padded" style="background-color: #efeff4;">
                    <div class="mui-input-row mui-search input-search" style="width:100%;background-color: #efeff4;">
                    </div>
                </div>
                <ul id="lis" class="mui-table-view mui-table-view-chevron" style="background-color: #efeff4;">

                </ul>
            </div>
        </div>
    </div>
</div>

<script>
    page = 0;
    limit = 20;
    mui.init({
        pullRefresh: {
            container: "#pullrefresh",//待刷新区域标识，querySelector能定位的css选择器均可，比如：id、.class等
            up: {
                auto:true,
                contentrefresh: "正在加载...",//可选，正在加载状态时，上拉加载控件上显示的标题内容
                contentnomore: '没有更多数据了',//可选，请求完毕若没有更多数据时显示的提醒内容；
                callback: pullupRefresh //必选，刷新函数，根据具体业务来编写，比如通过ajax从服务器获取新数据；
            }
        }
    });

    function pullupRefresh() {
        setTimeout(function () {
            page++;
            data();
        }, 500);
    };

    mui('body').on('tap', 'a', function () {
        window.top.location.href = this.href;
    });

    $("#btn").click(function () {
        var name = $("#name").val();
        window.location.href = "<?php echo url('/index/user/tuandui'); ?>?name=" + name;
    });

    var lis = document.getElementById("lis");

    function data() {
        var name = '<?php echo $name; ?>';
        $.ajax({
            url: "<?php echo url('/index/user/lists'); ?>",
            type: 'post',
            data: {'name':name,"page": page, "limit": limit},
            success: function (data) {
                if (data.length < limit) {
                    mui('#pullrefresh').pullRefresh().endPullupToRefresh(true);
                } else {
                    mui('#pullrefresh').pullRefresh().endPullupToRefresh(false);
                }
                for (var a in data) {
                    var index = '<li style="width: 94%;margin: 0 auto;"><div class="invite_box invite_box1 clearfix">\n' +
                        '            <div class="invite_left">\n' +
                        '                <img src="__PUBLIC__/img/head_pic.png" alt="">\n' +
                        '            </div>\n' +
                        '            <div class="invite_right">\n' +
                        '                <p class="user_num"> '+ data[a].mobile +'</p>\n' +
                        '                <p class="user_id">ID:'+ data[a].id +'</p>\n' +
                        '                <p class="user_profit">累积收益:<span>'+ data[a].total_achievement +'元</span>&nbsp;&nbsp;&nbsp;&nbsp;</p>\n' +
                        '                <p class="active_time">注册时间：'+data[a].create_time +'</p>\n' +
                        '            </div>\n' +
                        '        </div></li>';
                    lis.innerHTML += index;
                }
            }
        });
    }
    
    var bodyH = $("body").height();
    var H = window.screen.height;
    $(".order_box").css("height", H - bodyH + 21 - 64 + "px")
    // mui('.mui-scroll-wrapper')[0].addEventListener('touchmove', function (e) {
    // 	e.stopPropagation();
    // });
</script>


</body>
</html>