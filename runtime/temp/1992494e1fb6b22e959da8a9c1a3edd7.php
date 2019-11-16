<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:34:"./themes/default/index/mingxi.html";i:1572322420;}*/ ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>收支明细</title>
    <link rel="stylesheet" href="__PUBLIC__/css/mui.min.css">
    <link rel="stylesheet" href="__PUBLIC__/css/mui.picker.min.css">
    <link rel="stylesheet" href="__PUBLIC__/css/iconfont.css">
    <link rel="stylesheet" href="__PUBLIC__/css/style.css">
    <link rel="stylesheet" href="__PUBLIC__/css/income.css">
    <script src="__PUBLIC__/js/jquery.min.js"></script>
    <script src="__PUBLIC__/js/mui.min.js"></script>
    <script src="__PUBLIC__/js/mui.picker.min.js"></script>
    <script type="text/javascript" src="__PUBLICS__/layer/layer.js"></script>
</head>
<body>
<style>
    .mui-dtpicker {
        position: fixed;
        z-index: 999999;
        border-top: solid 1px #ccc;
        bottom: 0;
        -webkit-transform: translateY(350px);
    }

    .mui-btn-link {
        padding-top: 11px;
        float: 17px;
        font-size: 16px;
        padding-bottom: 6px;
        color: #007aff;
        border: 0;
        background-color: transparent;
    }

    .mui-content-padded {
        margin: 0px;
    }
    .mui-pull{
    	bottom: 0!important;
    }
</style>
<div class="container">
    <div class="head_box">
    	<a href="<?php echo url('index/index/mingxiss'); ?>" class="mui-btn mui-btn-link" style="float: left;">提现记录</a>
        <span style="margin-left: -10%;">收支明细</span>
        <a href="javascript:dianji()" class="mui-btn mui-btn-link mui-pull-right">搜索</a>
    </div>
    <div class="picker_box">
        <div class="time_box">
            <span class="time_ti">时间：</span>
            <div class="choose_time">
                <input type="text" name="start" id="dateSelect" value="<?php echo $start; ?>" placeholder="请选择开始时间">
                <span>至</span>
                <input type="text" name="end" id="dateSelect1" value="<?php echo $end; ?>" placeholder="请选择结束时间">
                <img src="__PUBLIC__/img/calendar.png" alt="">
            </div>
        </div>
    </div>
    <div class="revenue_box clearfix">
        <div class="revenue_left">
            <p>直推佣金：<?php echo $profityiji; ?></p>
            <p>直推订单：<?php echo $dingdan; ?></p>
            <p class="revenue_num"><?php echo $profitsun; ?></p>
            <p>总收益</p>
        </div>
        <div class="revenue_right">
            <p>团队佣金：<?php echo $profiterji; ?></p>
            <p>团队订单：<?php echo $profitnum; ?></p>
            <p class="revenue_num"><?php echo $dayprofi + $dayprice; ?></p>
            <p>今日收益</p>
        </div>
    </div>
    <div class="mui-content mui-scroll-wrapper order_box" style="margin-top: 55%;padding-top:0px;height:300px;"
         id="pullrefresh">
        <div style="padding:0;margin:0;background-color: #efeff4;">
            <div class="mui-content-padded" style="background-color: #efeff4;">
                <div class="mui-input-row mui-search input-search" style="width:100%;background-color: #efeff4;">
                </div>
            </div>


            <ul id="lis" class="mui-table-view mui-table-view-chevron" style="background-color: #efeff4;">

            </ul>

        </div>
    </div>

    <div class="footer" style="z-index:10000000;">
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
        <div class="tabbar active">
            <a href="<?php echo url('index/index/mingxi'); ?>">
                <p><span class="iconfont icon-qianbao"></span></p>
                <p>收入明细</p>
            </a>
        </div>
        <div class="tabbar">
            <a href="<?php echo url('index/index/index'); ?>">
                <p><span class="iconfont icon-wode"></span></p>
                <p>个人中心</p>
            </a>
        </div>
    </div>
</div>
</body>
<?php $a = ['提现'=> '-','退款'=>'-','直推奖励'=>'+','二级奖励'=>'+']; ?>
<script>

	$('.zixun').on('click',function(){
    			layer.msg('暂未开放');
    	});

    var lis = document.getElementById("lis");
    page = 0;
    limit = 20;
    mui.init({
        pullRefresh: {
            container: "#pullrefresh",//待刷新区域标识，querySelector能定位的css选择器均可，比如：id、.class等
            up: {
                auto: true,
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

    function data() {
        var astart = '<?php echo $start; ?>';
        var aend = '<?php echo $end; ?>';
        $.ajax({
            url: "<?php echo url('/index/index/lists'); ?>",
            type: 'post',
            data: {"start": astart, "end": aend, "page": page, "limit": limit},
            success: function (data) {
                if (data.length < limit) {
                    mui('#pullrefresh').pullRefresh().endPullupToRefresh(true);
                } else {
                    mui('#pullrefresh').pullRefresh().endPullupToRefresh(false);
                }
                for (var a in data) {
                    var index = '<li><div class="order_list">\n' +
                        '                        <p> 用户:' + data[a].nameshh + '<span class="order_way">' + data[a].type + '</span></p>\n' +
                        '                        <p>手机号：' + data[a].mobile + '<span class="order_money">金额：' + data[a].money + '</span></p>\n' +
                        '                        <p>时间：' + data[a].create + '</p>\n' +
                        '                    </div></li>';
                    lis.innerHTML += index;
                }
            }
        });
    }


    function dianji(agent, descc) {
        var start = $('#dateSelect').val();
        var end = $('#dateSelect1').val();
        if (start == "undefined" || start == null || start == "") {
            layer.msg("开始时间不能为空");
        } else if (end == "undefined" || end == null || end == "") {
            layer.msg("结束时间不能为空");
        } else {
            window.location.href = '<?php echo url("index/index/mingxi"); ?>?start=' + start + '&end=' + end;
        }
    }

    $(function () {
        $(".tabbar").click(function () {
            $(this).addClass("active").siblings().removeClass("active")
        })
        $("#dateSelect").click(function () {
            var dtPicker = new mui.DtPicker({type: 'datetime'});
            dtPicker.show(function (selectItems) {
                var y = selectItems.y.text;  //获取选择的年
                var m = selectItems.m.text;  //获取选择的月
                var d = selectItems.d.text;  //获取选择的日
                var h = selectItems.h.text;
                var i = selectItems.i.text;
                var date = y + "-" + m + "-" + d + " " + h + ":" + i;
                $("#dateSelect").val(date);
            })
        });
        $("#dateSelect1").click(function () {
            var dtPicker = new mui.DtPicker({type: 'datetime'});
            dtPicker.show(function (selectItems) {
                var y = selectItems.y.text;  //获取选择的年
                var m = selectItems.m.text;  //获取选择的月
                var d = selectItems.d.text;  //获取选择的日
                var h = selectItems.h.text;
                var i = selectItems.i.text;
                var date = y + "-" + m + "-" + d + " " + h + ":" + i;
                $("#dateSelect1").val(date);
            })
        });
        
        var bodyH = $("body").height();
	    var H = window.screen.height;
	    $(".order_box").css("height", H - bodyH  - 64  + "px")
	    })
</script>
</html>