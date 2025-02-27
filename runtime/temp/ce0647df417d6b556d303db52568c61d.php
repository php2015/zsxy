<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:36:"./themes/calculator/index/index.html";i:1571815575;}*/ ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>计算器</title>
    <link rel="stylesheet" href="__PUBLICS__/calculator/css/style.css">
    <link rel="stylesheet" href="__PUBLICS__/calculator/css/index.css?v=123">
    <script src="https://cdn.bootcss.com/html2canvas/0.5.0-beta4/html2canvas.js"></script>
    <script src="__PUBLICS__/calculator/js/canvas1image.js"></script>
    <script src="__PUBLICS__/calculator/js/base64.js"></script>
    <script src="__PUBLICS__/calculator/js/jquery-1.8.3.min.js"></script>
    <script src="__PUBLICS__/calculator/layer/layer.js"></script>
</head>
<body>
<div class="container">
    <div class="main">
        <span class="example" style="font-size:0.24rem;display:none;">样例</span>
        <div class="rate_box">
            <div class="rate_item rate_num">
                <div class="circle">
                    <p><span>0</span>元</p>
                </div>
                <p class="rate_ti">总共利息</p>
            </div>
            <div class="rate_item rate_year">
                <div class="circle">
                    <p><span>0</span>%</p>
                </div>
                <p class="rate_ti">真实年化利率</p>
            </div>
            <div class="rate_item rate_month">
                <div class="circle">
                    <p><span>0</span>%</p>
                </div>
                <p class="rate_ti">月利率</p>
            </div>
        </div>
        <p class="rate_tips">*超出国家法律规定36%的<span>0</span>倍</p>
        <div class="content">
            <p class="rate_p">实际到手金额（元）<input class="real_money" type="text" value="" placeholder="请输入实际到手金额" /></p>
            <p class="rate_p">每期还款金额（元）<input class="each_money" type="text" value="" placeholder="请输入每期还款金额" /></p>
            <p class="rate_p">还款期数<input class="times" type="text" value=""  placeholder="请输入还款期数" /></p>
            <p class="rate_p">还款频率</p>
            <div class="btn_warp" style="width:100%;">
                <button class="day" style="display:block;">每日</button>
                <button class="week" style="display:block;">每周</button>
                <button class="active month" style="display:block;">每月</button>
            </div>
            <div class="search_box">
                <button class="count" style="display:block;">计算</button>
                <button class="save_btn" style="display:block;">保存图片</button>
            </div>
        </div>
        <div class="content">
            <p class="lawyer_ques">
                <img src="__PUBLICS__/calculator/img/2.1.png" alt="">法律问答
                <img src="__PUBLICS__/calculator/img/2.2.png" alt="">
            </p>
            <?php $i = 0; if(is_array($data) || $data instanceof \think\Collection || $data instanceof \think\Paginator): if( count($data)==0 ) : echo "" ;else: foreach($data as $key=>$vo): $i++ ;?>
            <div class="question_list clearfix">
                <p class="ques_left" style="font-size:0.26rem;"><?php echo $i; ?>.<?php echo $vo['title']; ?></p>
                <p class="ques_right">
                    <a href="<?php echo url('/calculator/index/unlock',['id'=>$vo['id']]); ?>"><button style="font-size:0.24rem;">查看答案</button></a>
                </p>
            </div>
            <?php endforeach; endif; else: echo "" ;endif; ?>
            <a href="<?php echo url('/calculator/index/lists'); ?>"><button class="see_more" style="font-size:0.24rem;">了解更多问题</button></a>
        </div>
    </div>
    <div class="popup_box">
        <div class="popop" id="popop">
            <ul>
                <li>实际到手金额为<span class="real_num">0</span>元</li>
                <li>每期还款<span class="each_num">0</span>元</li>
                <li>还款期数为<span class="times_num">0</span>期</li>
                <li>还款频率每<span class="frequency"></span>一还</li>
                <li>您的总利息为<span class="total_num">0</span>元</li>
                <li>您的真实年化利率为<span class="year_rate">0</span>%</li>
                <li>您的月利率为<span class="month_rate">0</span>%</li>
            </ul>
            <div class="pop_img"></div>
            <div class="pop_bot" style="padding:0 0.6rem;">
                <div class="erweima">
					<img src="__PUBLICS__/calculator/img/3.4.png" alt="">
				</div>
                <p>网贷真实利率计算器<br><span>长按保存到本地相册</span></p>
                
            </div>
        </div>
    </div>
</div>
</body>
<script>
    var real_money = 0;
    var each_money = 0;
    var times = 0;
    var rate_year = 0;
    var rate_month = 0;
    var multiple = 0;
	
	if(Number($(".rate_num span").html()) > 0){
        $(".save_btn").show()
    }else{
        $(".save_btn").hide()
    }

    $(".count").click(function(){
        real_money = Number($(".real_money").val());
        each_money = Number($(".each_money").val());
        times = Number($(".times").val());

        if(!$.isNumeric(real_money) || real_money == ''){
            layer.msg('请输入正确的到手金额');return;
        }

        if(!$.isNumeric(each_money) || each_money == ''){
            layer.msg('请输入正确的每期还款金额');return;
        }

        if(!$.isNumeric(times) || times == ''){
            layer.msg('请输入正确的还款期数');return;
        }
        tp();
		if(Number($(".rate_num span").html()) > 0){
            $(".save_btn").show()
            // $(".popup_box").show()
        }else{
            $(".save_btn").hide()
        }
    });

    $(".btn_warp button").click(function(){
        $(this).addClass("active").siblings().removeClass("active");
        if($(".btn_warp button").eq(0).hasClass("active")){
            if(rate_month){
                tp();
            }
        }else if($(".btn_warp button").eq(1).hasClass("active")){
            if(rate_month){
                tp();
            }
        }else if($(".btn_warp button").eq(2).hasClass("active")){
            if(rate_month){
                tp();
            }
        }
    });


    function tp (){
        if($(".day").hasClass("active")){
            rate_year = parseFloat((((each_money * times) - real_money) / real_money / times * 360 * 100).toFixed(2));
			$(".popop").find(".frequency").html("日")
        }else if($(".week").hasClass("active")){
            rate_year = parseFloat((((each_money * times) - real_money) / real_money / (7 * times) * 360 * 100).toFixed(2));
			$(".popop").find(".frequency").html("周")
        }else if($(".month").hasClass("active")){
            rate_year = parseFloat((((each_money * times) - real_money) / real_money / (30 * times) * 360 * 100).toFixed(2));
			$(".popop").find(".frequency").html("月")
        }

        rate_month = parseFloat((Number(rate_year) / 12).toFixed(1));

        multiple = parseFloat((Number(rate_year) / 36).toFixed(1));

        $(".rate_num").find("span").html(each_money * times - real_money);
        $(".rate_year").find("span").html(rate_year);
        $(".rate_month").find("span").html(rate_month);
        $(".rate_tips").find("span").html(multiple);

        $(".popop").find(".real_num").html(real_money);
        $(".popop").find(".each_num").html(each_money);
        $(".popop").find(".times_num").html(times);
        $(".popop").find(".total_num").html(each_money * times - real_money);
        $(".popop").find(".year_rate").html(rate_year);
        $(".popop").find(".month_rate").html(rate_month);
    }

	var img
    $(".save_btn").click(function(){
        $(".popup_box").show()
		var copyDom = $(".popop");
        var shareContent = document.getElementById("popop");
        var width = shareContent.offsetWidth;//dom宽
        var height = shareContent.offsetHeight;//dom高
        var canvas = document.createElement('canvas');
        var scale = 2;//放大倍数
		var imgType = "image/png";//设置默认下载的图片格式
        canvas.width = width*scale;//canvas宽度
        canvas.height = height*scale;//canvas高度
        var content = canvas.getContext("2d");
        content.scale(scale,scale);
        var rect = copyDom.get(0).getBoundingClientRect();//获取元素相对于视察的偏移量
        content.translate(-rect.left,-rect.top);//设置context位置，值为相对于视窗的偏移量负值，让图片复位
        html2canvas(copyDom[0], {
            dpi: window.devicePixelRatio*2,
            scale:scale,
            canvas:canvas,
            width:width,
            heigth:height,
            useCORS: true //开启html2canvas的useCORS配置，跨域配置，以解决图片跨域的问题
        }).then(function (canvas) {
			var context = canvas.getContext('2d');
            content.mozImageSmoothingEnabled = false;
            content.webkitImageSmoothingEnabled = false;
            content.msImageSmoothingEnabled = false;
            content.imageSmoothingEnabled = false;
			//var url = canvas.toDataURL();
            //var triggerDownload = $("<a>").attr("href", url).attr("download", "详情.png").appendTo("body");
            //triggerDownload[0].click();
            //triggerDownload.remove();
            img = Canvas2Image.convertToImage(canvas, canvas.width, canvas.height,imgType); //将绘制好的画布转换为img标签,默认图片格式为PNG.
			$(".popop").hide();
			$(img).appendTo(".popup_box");
			$(img).css({"width":width,"height":height,"position":"absolute","top":"50%","left":"50%","transform":"translate(-50%,-50%)"})
        });
    });
    $(".popup_box").click(function(){
		$(".popop").show();
        $(".popup_box").hide()
		$(img).hide();
    });

</script>
</html>