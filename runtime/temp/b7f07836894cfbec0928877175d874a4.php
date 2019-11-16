<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:36:"./themes/default/login/portrait.html";i:1573008736;}*/ ?>
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
            <p>姓名：<?php if(isset($result['opnames']) && !empty($result['opnames'])): ?><?php echo $result['opnames']; endif; ?></p>
            <p>年龄：<?php if(isset($result['age']) && !empty($result['age'])): ?><?php echo $result['age']; endif; ?></p>
            <p>性别：<?php if(isset($result['sex']) && !empty($result['sex'])): ?><?php echo $result['sex']; endif; ?></p>
            <p>身份证：<?php if(isset($result['opcard']) && !empty($result['opcard'])): ?><?php echo $result['opcard']; endif; ?></p>
            <p>手机号：<?php if(isset($result['mobile']) && !empty($result['mobile'])): ?><?php echo $result['mobile']; endif; ?></p>
            <p>银行卡号：<?php if(isset($result['account_no']) && !empty($result['account_no'])): ?><?php echo $result['account_no']; endif; ?></p>
            <p>检测时间：<?php if(isset($result['dates']) && !empty($result['dates'])): ?><?php echo $result['dates']; endif; ?></p>
        	
        </div>
        <div class="card_box" style="height: 3.5rem;">
        	<p>卡名称：<?php if(isset($result['YLZC005']) && !empty($result['YLZC005'])): ?><?php echo $result['YLZC005']; else: ?>无<?php endif; ?></p>
            <p>发卡行：<?php if(isset($result['YLZC008']) && !empty($result['YLZC008'])): ?><?php echo $result['YLZC008']; else: ?>无<?php endif; ?></p>
            <p>卡品牌：<?php if(isset($result['YLZC003']) && !empty($result['YLZC003'])): ?><?php echo $result['YLZC003']; else: ?>无<?php endif; ?></p>
            <p>卡性质：<?php if(isset($result['YLZC002']) && !empty($result['YLZC002'])): ?><?php echo $result['YLZC002']; else: ?>无<?php endif; ?></p>
            <p>借贷标记：<?php if(isset($result['YLZC001']) && !empty($result['YLZC001'])): ?><?php echo $result['YLZC001']; else: ?>无<?php endif; ?></p>
            <p>商户单号：<?php if(isset($result['out_trade_no']) && !empty($result['out_trade_no'])): ?><?php echo $result['out_trade_no']; endif; ?></p>
        	<p>交易单号：<?php if(isset($result['transaction_id']) && !empty($result['transaction_id'])): ?><?php echo $result['transaction_id']; endif; ?></p>
            <img src="__PUBLIC__/img/bank/card.png" alt="">
        </div>
         <div style="width: 6.7rem;height: 2.3rem;border-radius: 0.18rem;margin: 0.3rem auto;position: relative;">
         	<p class="p_index_yonh">是否</p>
         	<p class="p_index_yonhs">银联高端用户</p>
         		<p class="p_index_yonhss"><?php if(isset($result['YLZC007']) && !empty($result['YLZC007'])): ?><?php echo $result['YLZC007']; else: ?>否<?php endif; ?></p>
         	<img src="__PUBLIC__/bg/imgs/shifou.png" alt="" style="width:100%">
         </div>
        <div class="grade_report">
            <p class="report_ti">综合评分报告</p>
            <div class="grade_box clearfix">
               <?php if(isset($result['RMS002']) && !empty($result['RMS002'])): ?>
                <div class="grade_item">
                    <div class="score_box"><?php if(isset($result['RMS002']) && !empty($result['RMS002'])): ?><?php echo $result['RMS002']; else: ?>0<?php endif; ?></div>
                    <p>消费能力评分</p>
                </div>
                <?php endif; if(isset($result['RMS003']) && !empty($result['RMS003'])): ?>
                <div class="grade_item">
                    <div class="score_box"><?php if(isset($result['RMS003']) && !empty($result['RMS003'])): ?><?php echo $result['RMS003']; else: ?>0<?php endif; ?></div>
                    <p>信用得分</p>
                </div>
                <?php endif; ?>
            </div>
            <p class="grade_com"><span>总评：</span>0—1000分，数值越大表示卡上承载了越多的非生活必须类消费，消费自由度越高。</p>
        </div>
        <div class="ability_box clearfix">
            <div class="ability_left">
                <div class="ability_top1">
                    <p>钱包位置：&#9733 &#9733 &#9733 &#9733 <span>&#9733</span></p>
                </div>
                <p class="ability_p1"></p>
                <p class="ability_p1"><?php if(isset($result['YLZC017']) && !empty($result['YLZC017'])): ?><?php echo $result['YLZC017']; else: ?>无<?php endif; ?></p>
                <img class="ability_pic2" src="__PUBLIC__/img/bank/t1.png" alt="">
            </div>
              <div class="ability_right ability_right4">
                <div class="ability_top1 ability_top4">
                    <p>价值评定：&#9733 &#9733 &#9733 &#9733 <span>&#9733</span></p>
                </div>
                <p class="ability_p2"> <?php if(isset($result['YLZC014']) && !empty($result['YLZC014'])): ?><?php echo $result['YLZC014']; else: ?>无<?php endif; ?> </p>
                 <img class="ability_pic3" src="__PUBLIC__/img/bank/t2.png" alt="">
            </div>
			<div class="ability_right">
                <div class="ability_top1 ability_top2">
                    <p>消费能力：&#9733 &#9733 &#9733 &#9733 <span>&#9733</span></p>
                </div>
                <p class="ability_p1"><?php if(isset($result['YLZC009']) && !empty($result['YLZC009'])): ?><?php echo $result['YLZC009']; else: ?>无<?php endif; ?></p>
                <img class="ability_pic2" src="__PUBLIC__/img/bank/t3.png" alt="">
            </div>
			<div class="ability_right">
                <div class="ability_top1 ability_top6">
                    <p>消费趋势：&#9733 &#9733 &#9733 &#9733 <span>&#9733</span></p>
                </div>
                <p class="ability_p2" style="color: #333;"><?php if(isset($result['YLZC013']) && !empty($result['YLZC013'])): ?><?php echo $result['YLZC013']; else: ?>无<?php endif; ?></p>
                <img class="ability_pic6" src="__PUBLIC__/img/bank/t4.png" alt="">
            </div>
			<div class="ability_left">
                <div class="ability_top1 ability_top5">
                    <p>消费自由度</p>
                </div>
                <p class="ability_p1"><?php if(isset($result['CSSS001']) && !empty($result['CSSS001'])): ?><?php echo $result['CSSS001']; else: ?>无<?php endif; ?></p>
                <img class="ability_pic3" src="__PUBLIC__/img/bank/t5.png" alt="">
            </div>
           
            <div class="ability_left ability_left3">
                <div class="ability_top1 ability_top3">
                    <p>消费偏好</p>
                </div>
                <p class="ability_p2"> <?php if(isset($result['YLZC010']) && !empty($result['YLZC010'])): ?><?php echo $result['YLZC010']; else: ?>无<?php endif; ?> </p>
                <img class="ability_pic2" src="__PUBLIC__/img/bank/t6.png" alt="">
            </div>
        </div>
    </div>
</body>
</html>