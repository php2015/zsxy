<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:37:"./themes/default/chaxun/yangshi2.html";i:1572853090;}*/ ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>用户画像</title>
    <link rel="stylesheet" href="__PUBLIC__/css/style.css">
    <link rel="stylesheet" href="__PUBLIC__/css/portrait.css?v=123456">
</head>
<style>
	.p_index_yonh{
	    position: absolute;
    	z-index: 99999;
    	color: #ae7418;
    	font-size: 0.7rem;
    	font-weight: bold;
    	margin: 0.4rem 0px 0 0.5rem;
	}
	
	.p_index_yonhs{
		position: absolute;
    	z-index: 99999;
    	color: #ae7418;
    	font-size: 0.43rem;
    	font-weight: bold;
    	margin: 1.3rem 0px 0 0.5rem;
	}
	
	.p_index_yonhss{
		position: absolute;
    	z-index: 99999;
    	color: #ae7418;
    	font-size: 0.5rem;
    	font-weight: bold;
    	margin: 0.93rem 0px 0 5.03rem;
	}
	.grade_item {
    	width: 100%;
    	float: left;
    	text-align: center;
	}
	.ability_left,.ability_right{
		width: 100%;
	}
	.ability_p1 {
    	font-size: 0.26rem;
    	line-height: 0.36rem;
    	color: #333333;
    	padding: 0 0.2rem;
    	width: 50%;
    	float: left;
	}
	
	.ability_p2 {
    	font-size: 0.26rem;
    	line-height: 0.36rem;
    	color: #fff;
    	padding: 0.2rem 0.2rem;
    	width: 50%;
    	float: right;
	}
</style>
<body>
    <div class="container">
        <div class="info_box">
            <p class="info_ti">基本资料</p>
            <p>姓名：张珊</p>
            <p>性别：女</p>
            <p>年龄：24</p>
            <p>身份证：452727******71866</p>
            <p>手机号：18344555658</p>
            <p>银行卡号：651432159846546465</p>
            <p>检测时间：2019-10-20 15:51</p>
        </div>
        <div class="card_box">
            <p>卡名称：IC绿卡通</p>
            <p>发卡行：中国邮政储蓄银行</p>
            <p>卡品牌：银联标准卡</p>
            <p>卡性质：准贷记卡</p>
            <p>借贷标记：借记卡</p>
            <p>是否银联高端用户：否</p>
            <img src="__PUBLIC__/img/bank/card.png" alt="">
        </div>
        
         <div style="width: 6.7rem;height: 2.3rem;border-radius: 0.18rem;margin: 0.3rem auto;position: relative;">
         	<p class="p_index_yonh">是否</p>
         	<p class="p_index_yonhs">银联高端用户</p>
         		<p class="p_index_yonhss">是</p>
         	<img src="__PUBLIC__/bg/imgs/shifou.png" alt="" style="width:100%">
         </div>
        
        
        
        
        <div class="grade_report">
            <p class="report_ti">综合评分报告</p>
            <div class="grade_box clearfix">
                <div class="grade_item">
                    <div class="score_box">80</div>
                    <p>消费能力评分</p>
                </div>
            </div>
            <p class="grade_com"><span>总评：</span>0—1000分，数值越大表示卡上承载了越多的非生活必须类消费，消费自由度越高。</p>
        </div>
        <div class="ability_box clearfix">
            <div class="ability_left">
                <div class="ability_top1">
                    <p>钱包位置：&#9733 &#9733 &#9733 &#9733 <span>&#9733</span></p>
                </div>
                <p class="ability_p1">居中（特殊）：主要用于某一两次大额支付服务，用卡次数少、商户类型少，总划卡金额及单笔高，刷卡消费比较不稳定；</p>
                <img class="ability_pic2" src="__PUBLIC__/img/bank/t1.png" alt="">
            </div>
            <div class="ability_right ability_right4">
                <div class="ability_top1 ability_top4">
                    <p>价值评定：&#9733 &#9733 &#9733 &#9733 <span>&#9733</span></p>
                </div>
                <p class="ability_p2">文艺小资：消费场所高端，交易金额较高，但显著低于高端人群，客户价值高</p>
                <img class="ability_pic3" src="__PUBLIC__/img/bank/t2.png" alt="">
            </div>
            <div class="ability_right">
                <div class="ability_top1 ability_top2">
                    <p>消费能力：&#9733 &#9733 &#9733 &#9733 <span>&#9733</span></p>
                </div>
                <p class="ability_p1">高额消费</p>
                <img class="ability_pic2" src="__PUBLIC__/img/bank/t3.png" alt="">
            </div>
           
          
            <div class="ability_right">
                <div class="ability_top1 ability_top6">
                    <p>消费趋势：&#9733 &#9733 &#9733 &#9733 <span>&#9733</span></p>
                </div>
                <p class="ability_p2" style="color: #333;">（与地域相比）相当</p>
                <img class="ability_pic6" src="__PUBLIC__/img/bank/t4.png" alt="">
            </div>
            
            <div class="ability_left">
                <div class="ability_top1 ability_top5">
                    <p>消费自由度</p>
                </div>
                <p class="ability_p1">0—1000分，数值越大表示卡上承载了越多的非生活必须类消费，消费自由度越高。</p>
                <img class="ability_pic3" src="__PUBLIC__/img/bank/t5.png" alt="">
            </div>
             <div class="ability_left ability_left3">
                <div class="ability_top1 ability_top3">
                    <p>消费偏好：购物消费</p>
                </div>
                <img class="ability_pic3" src="__PUBLIC__/img/bank/t6.png" alt="">
            </div>
        </div>
    </div>
</body>
</html>