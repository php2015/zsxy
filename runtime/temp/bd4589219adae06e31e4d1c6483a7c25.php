<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:37:"./themes/default/user/chaxunjilu.html";i:1572855374;}*/ ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>我的客户</title>
    <link rel="stylesheet" href="__PUBLIC__/css/mui.min.css">
    <link rel="stylesheet" href="__PUBLIC__/css/style.css">
    <link rel="stylesheet" href="__PUBLIC__/css/order.css">
    <script src="__PUBLIC__/js/jquery.min.js"></script>
    <script src="__PUBLIC__/js/mui.min.js"></script>
</head>
<style>
    .mui-content-padded{
        margin: 0px;
    }
    .choose_time {
        width: 6.2rem;
        height: 0.36rem;
        float: right;
        position: relative;
        margin-top: 0.14rem;
        background: #f1f1f1;
    }
    .choose_time input {
        width: 40%;
        float: left;
        height: 0.36rem;
        border: none;
        background: rgba(0, 0, 0, 0);
        font-size: 0.24rem;
        line-height: 0.4rem;
        margin: 0;
        padding: 0 0 0 0.2rem;
    }
    .mui-pull{
    	bottom:0!important;
    }
</style>
<body>
<div class="container">
    <div class="time_box">
        <span class="time_ti">搜索：</span>
        <div class="choose_time">
            <input type="text" value="<?php echo $name; ?>" id="name" name="name" placeholder="搜索姓名或手机号">
            <img src="__PUBLIC__/img/icon_search.png" alt="" id="btn">
        </div>
    </div>
    <p class="my_order">我的订单</p>
    <div class="mui-content mui-scroll-wrapper order_box" style="margin-top: 25%;padding-top:0px;height:1000px;"
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
        window.location.href = "<?php echo url('/index/user/chaxunjilu'); ?>?name=" + name;
    });

    var lis = document.getElementById("lis");
    function data() {
        var name = '<?php echo $name; ?>';
        $.ajax({
            url:"<?php echo url('/api/user/chaxunjil'); ?>",
            type:'post',
            data:{'name':name,"page":page,"limit":limit},
            success: function (data) {
                if (data.length < limit) {
                    mui('#pullrefresh').pullRefresh().endPullupToRefresh(true);
                } else {
                    mui('#pullrefresh').pullRefresh().endPullupToRefresh(false);
                }
                
                for (var a in data) {
                	var score = '';
                	if(data[a].a_g_id == 3){
                		score = '<div class="score_num">'+ data[a].json.scorecashon +'</div><p>报告分数</p>'; 
                	}
                    var url = '<?php echo url("index/login/view"); ?>?dingdanids=' + data[a].id ;
                    var index = '<li><a href="' + url + '"> <div class="order_list">\n' +
                        '            <p>姓名：'+ data[a].names +'</p>\n' +
                        '            <p>类型：<span>'+ data[a].bname +'</span></p>\n' +
                        '            <p>手机号：'+ data[a].tel +'</p>\n' +
                        '            <p class="order_time">下单时间：'+ data[a].dates  +'</p>\n' +
                        '            <div class="score_box">\n' + score +
                        '            </div>\n' +
                        '        </div></a></li>';
                    lis.innerHTML += index;
                }
            }
        });
    }
    window.addEventListener('toggle', function (event) {
        if (event.target.id === 'M_Toggle') {
            var isActive = event.detail.isActive;
            var table = document.querySelector('.mui-table-view');
            var card = document.querySelector('.mui-card');
            if (isActive) {
                card.appendChild(table);
                card.style.display = '';
            } else {
                var content = document.querySelector('.mui-content');
                content.insertBefore(table, card);
                card.style.display = 'none';
            }
        }
    });
</script>


</body>
</html>