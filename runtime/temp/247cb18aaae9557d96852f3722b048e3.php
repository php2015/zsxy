<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:33:"./themes/default/chaxun/view.html";i:1571981075;}*/ ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>风险报告</title>
    <link rel="stylesheet" href="__PUBLIC__/bg/css/mui.min.css">
    <link rel="stylesheet" href="__PUBLIC__/bg/css/style.css">
    <link rel="stylesheet" href="__PUBLIC__/bg/css/index.css">
    <script src="__PUBLIC__/bg/js/mui.min.js"></script>
    <script src="__PUBLIC__/bg/js/jquery.min.js"></script>
    <script src="__PUBLIC__/bg/js/index.js"></script>
</head>
<body>

<style>
    .risk_box {
        width: 7.1rem;
        margin: 0.3rem 0.2rem;
        border-radius: 0.22rem;
        height: 4.5rem;
    }
    
    .risk_left {
    width: 90%;
    float: left;
    position: relative;
}
</style>

<!--  <a href="/index/complaint/wenti.html">
    <div style="width: 40px;height: 40px;border: 1px solid #ee823a;background: #ee823a;border-radius:100%;position: fixed;right: 5px; top: 300px;z-index: 999;opacity:0.5;">
        <p style="text-align: center;line-height: 39px;margin-left: 3px;color: #fff;font-weight: bold;">帮助</p>
    </div>
</a> -->
<!-- <a href="<?php echo url('/index/complaint/comment'); ?>">
    <div style="width: 40px;height: 40px;border: 1px solid #ee823a;background: #ee823a;border-radius:100%;position: fixed;right: 5px; top: 350px;z-index: 999;opacity:0.5;">
        <p style="text-align: center;line-height: 39px;margin-left: 3px;color: #fff;font-weight: bold;">评论</p>
    </div>
</a> -->
<a href="<?php echo url('/index/complaint/index'); ?>">
    <div style="width: 40px;height: 40px;border: 1px solid #ff9600;background: #ff9600;border-radius:100%;position: fixed;right: 5px; top: 400px;z-index: 999;opacity:0.5;">
        <p style="text-align: center;line-height: 39px;margin-left: 3px;color: #fff;font-weight: bold;">投诉</p>
    </div>
</a>

<a href="<?php echo url('/calculator/index/index'); ?>">
    <div style="width: 40px;height: 40px;border: 1px solid #12a8ce;background: #12a8ce;border-radius:100%;position: fixed;right: 5px; top:450px;z-index: 999;opacity:0.5;">
        <p style="text-align: center;line-height: 39px;margin-left: 3px;color: #fff;font-weight: bold;">计算器</p>
    </div>
</a>

<div class="container">
    <div class="score_box">
        <div class="zsxy_ti">
            <img src="__PUBLIC__/bg/img/xlogo.png" alt="">
        </div>
        <div class="score_grade"><span><?php if(isset($result['grade']) and !empty($result['grade'])): ?> <?php echo $result['grade']; else: ?>D<?php endif; ?>级</span>
        </div>
        <div class="star_box">
            <img src="__PUBLIC__/bg/img/star_y.png" alt="">
            <img src="__PUBLIC__/bg/img/star_y.png" alt="">
            <img src="__PUBLIC__/bg/img/star_y.png" alt="">
            <img src="__PUBLIC__/bg/img/star_y.png" alt="">
            <img src="__PUBLIC__/bg/img/star_w.png" alt="">
        </div>
        <p class="score_user">您的评分指数</p>
        <div class="score_num">
            <span><?php if(isset($result['fraction']) and !empty($result['fraction'])): ?> <?php echo $result['fraction']; else: ?>95<?php endif; ?></span>
        </div>
        <div class="score_press">
            <div class="press_blue" id="bar" style="width: 0%;">
                <img src="__PUBLIC__/bg/img/huojian.png" alt="">
            </div>
        </div>
        <p class="score_per">满分100分，分数越高信用越好<span id="total" style="display: none;"></span></p>
    </div>
    <p class="basic_info">
        <span>基本信息</span>
    </p>
    <div class="user_card">
        <p class="username"><?php if(isset($result['opnames']) and !empty($result['opnames'])): ?> <?php echo $result['opnames']; endif; ?>&nbsp;&nbsp;<?php if(isset($result['ningling']) and !empty($result['ningling'])): ?> <?php echo $result['ningling']; else: ?>0<?php endif; ?>岁&nbsp;&nbsp;<?php echo $result['ren']; ?></p>
        <div class="user_info">
            <p>
                <img src="__PUBLIC__/bg/img/shoujihao1.png" alt=""><?php if(isset($result['mobile']) and
                !empty($result['mobile'])): ?> <?php echo $result['mobile']; endif; ?>
            </p>
            <p>
                <img src="__PUBLIC__/bg/img/guishudi1.png" alt=""><?php if(isset($result['phoneLocation']) and !empty($result['phoneLocation'])): ?> <?php echo $result['phoneLocation']; endif; ?>
            </p>
        </div>
        <div class="user_info">
            <p>
                <img class="shenfen" src="__PUBLIC__/bg/img/shenfenzheng1.png" alt=""><?php if(isset($result['opcard']) and !empty($result['opcard'])): ?> <?php echo $result['opcard']; endif; ?>
            </p>
            <p>
                <img src="__PUBLIC__/bg/img/address1.png" alt=""><?php if(isset($result['province']) and !empty($result['province'])): ?> <?php echo $result['province']; endif; ?>
            </p>
        </div>
        <p class="init_time">交易单号：
            <?php if(isset($result['transaction_id']) and
            !empty($result['transaction_id'])): ?><?php echo $result['transaction_id']; endif; ?>
        </p>
        <p class="init_time">商户单号：
            <?php if(isset($result['out_trade_no']) and !empty($result['out_trade_no'])): ?><?php echo $result['out_trade_no']; endif; ?>
        </p>
        <p class="init_time">报告生成时间：<?php if(isset($result['createAt']) and !empty($result['createAt'])): ?>
            <?php echo $result['createAt']; endif; ?></p>
        <p class="init_time">报告失效时间：<?php if(isset($result['createAts']) and !empty($result['createAts'])): ?>
            <?php echo $result['createAts']; endif; ?></p>
    </div>
    <div class="risk_box clearfix">
        <div class="risk_left">
            <p class="risk_ti">
                <span>风险解读</span>
            </p>
            <ul>
                <?php if(isset($result['fraction']) and !empty($result['fraction'])): if($result['fraction'] <= '40'):                         $socreasho01 = ['网络小贷高风险','信贷逾期后还款名单','风险群体名单','多头借贷严重名单','网贷黑名单','羊毛党名单','恶意注册名单'];
                        foreach($socreasho01 as $key => $value){
                ?>
                <li><?php echo  $value ?></li>
                <?php } elseif($result['fraction'] > '40' and $result['fraction'] < '61'):                         $socreasho02 = ['网络小贷高风险','信贷逾期后还款名单','风险群体名单','多头借贷严重名单','网贷灰名单','羊毛党名单'];
                        foreach($socreasho02 as $key => $value){
                ?>
                <li><?php echo  $value ?></li>
                <?php } elseif($result['fraction'] > '60' and $result['fraction'] < '73'):                         $socreasho03 = ['网络小贷高风险','风险群体名单','网贷灰名单'];
                        foreach($socreasho03 as $key => $value){
                ?>
                <li><?php echo  $value ?></li>
                <?php } elseif($result['fraction'] > '72' and $result['fraction'] < '83'):                         $socreasho04 = ['机构关注名单'];
                        foreach($socreasho04 as $key => $value){
                ?>
                <li><?php echo  $value ?></li>
                <?php } elseif($result['fraction'] > '82'): ?>
                <li>查询成功，未检测到风险</li>
                <?php endif; else: ?>
                <li>查询成功，未检测到风险</li>
                <?php endif; ?>
            </ul>
            <div class="vertical_line">
                <span></span>
            </div>
        </div>
        <div class="risk_right">

        </div>
    </div>
    <div class="quota_box">
        <div class="quota_item clearfix">
            <div class="quota_left">
                <p>信用卡预测额度</p>
                <p>
                    <?php if(isset($result['fraction']) and !empty($result['fraction'])): if($result['fraction'] <= '40'): ?>
                    5000以下
                    <?php elseif($result['fraction'] > '40' and $result['fraction']< '61'): ?>
                    5千—1.5万
                    <?php elseif($result['fraction'] > '60' and $result['fraction']< '73'): ?>
                    1万—2万
                    <?php elseif($result['fraction'] > '72' and $result['fraction']< '83'): ?>
                    1.5万—3万
                    <?php elseif($result['fraction'] > '82'): ?>
                    3万以上
                    <?php else: ?>
                    无
                    <?php endif; else: ?>
                    无
                    <?php endif; ?>
                </p>
            </div>
            <div class="quota_left">
                <p>贷款预测额度</p>
                <p>
                    <?php if(isset($result['fraction']) and !empty($result['fraction'])): if($result['fraction'] <= '40'): ?>
                    10000以下
                    <?php elseif($result['fraction'] > '40' and $result['fraction']< '61'): ?>
                    8千—2万
                    <?php elseif($result['fraction'] > '60' and $result['fraction']< '73'): ?>
                    1.5万—3万
                    <?php elseif($result['fraction'] > '72' and $result['fraction']< '83'): ?>
                    3万—5万
                    <?php elseif($result['fraction'] > '82'): ?>
                    5万以上
                    <?php else: ?>
                    无
                    <?php endif; else: ?>
                    无
                    <?php endif; ?>
                </p>
            </div>
        </div>
    </div>
    <div class="plate_title">
        <span class="circular circular1"></span>
        <span class="circular circular2"></span>
        <span class="circular circular3"></span>
        风险等级评分
        <span class="circular circular3"></span>
        <span class="circular circular2"></span>
        <span class="circular circular1"></span>
    </div>
    <div class="intention_box">
        <div class="intention_wrap">
            <div class="intention_score">
                <div class="score_bot"><?php if(isset($result['score']) and
                    !empty($result['score'])): ?><?php echo $result['score']; else: ?>0<?php endif; ?>
                </div>
                <p class="intention_ti">分数</p>
                <p class="intention_txt">20分及以下：等级较好</p>
                <p class="intention_txt">20分 - 80分：等级一般</p>
                <p class="intention_txt">80分及以上：等级较差</p>
            </div>
            <div class="intention_score">
                <div class="score_bot">
                    <?php if(isset($result['riskLevel']) and
                    !empty($result['riskLevel'])): ?><?php echo $result['riskLevel']; else: ?>0<?php endif; ?>
                </div>
                <p class="intention_ti">风险</p>
                <p class="intention_txt">低：较小的欺诈和失信风险</p>
                <p class="intention_txt">中：有一定欺诈和失信风险</p>
                <p class="intention_txt">高：较高的欺诈和失信风险</p>
            </div>
        </div>
    </div>
    <p class="basic_info basic_info1">
        <span>多平台申请借款</span>
    </p>
    <div class="search_id apply_num clearfix">
        <div class="apply_list">
            <p class="apply_left">近7天内</p>
            <p class="apply_right"><?php if(isset($result['one_week']) and
                !empty($result['one_week'])): ?><?php echo $result['one_week']; else: ?>0<?php endif; ?></p>
        </div>
        <div class="apply_list">
            <p class="apply_left">近1个月内</p>
            <p class="apply_right"><?php if(isset($result['January']) and
                !empty($result['January'])): ?><?php echo $result['January']; else: ?>0<?php endif; ?></p>
        </div>
        <div class="apply_list">
            <p class="apply_left">近3个月内</p>
            <p class="apply_right"><?php if(isset($result['March']) and
                !empty($result['March'])): ?><?php echo $result['March']; else: ?>0<?php endif; ?></p>
        </div>
        <div class="apply_list">
            <p class="apply_left">近六个月内</p>
            <p class="apply_right"><?php if(isset($result['June']) and
                !empty($result['June'])): ?><?php echo $result['June']; else: ?>0<?php endif; ?></p>
        </div>
        <div class="apply_list">
            <p class="apply_left">近一年内</p>
            <p class="apply_right"><?php if(isset($result['December']) and
                !empty($result['December'])): ?><?php echo $result['December']; else: ?>0<?php endif; ?></p>
        </div>
    </div>
    <div class="search_id loan_box">
        <i class="mui-icon mui-icon-arrowleft previous"></i>
        <i class="mui-icon mui-icon-arrowright next"></i>
        <div class="loan_tab clearfix">
            <div class="loan_item">

                <p class="loan_ti">近7天内（<?php if(isset($result['one_week']) and
                    !empty($result['one_week'])): ?><?php echo $result['one_week']; else: ?>0<?php endif; ?>次）</p>
                <?php if(isset($result['apply_loan']) and !empty($result['apply_loan']['Apply7_day'])): if(is_array($result['apply_loan']['Apply7_day']) || $result['apply_loan']['Apply7_day'] instanceof \think\Collection || $result['apply_loan']['Apply7_day'] instanceof \think\Paginator): $i = 0; $__LIST__ = $result['apply_loan']['Apply7_day'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
                <div class="loan_list">
                    <p class="loan_list_left" style="color: #39b2ff;"><?php echo $vo['dimension']; ?></p>
                </div>
                <?php if(is_array($vo['detail']) || $vo['detail'] instanceof \think\Collection || $vo['detail'] instanceof \think\Paginator): $i = 0; $__LIST__ = $vo['detail'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?>
                <div class="loan_list">
                    <p class="loan_list_left"><?php echo $v['industry_display_name']; ?></p>
                    <p class="loan_list_right">
                        <span class="loan_tell"><?php echo $v['count']; ?></span>
                    </p>
                </div>
                <?php endforeach; endif; else: echo "" ;endif; endforeach; endif; else: echo "" ;endif; endif; ?>

            </div>
            <div class="loan_item">


                <p class="loan_ti">近1个月内（<?php if(isset($result['January']) and
                    !empty($result['January'])): ?><?php echo $result['January']; else: ?>0<?php endif; ?>次）</p>
                <?php if(isset($result['apply_loan']) and !empty($result['apply_loan']['Apply1_month'])): if(is_array($result['apply_loan']['Apply1_month']) || $result['apply_loan']['Apply1_month'] instanceof \think\Collection || $result['apply_loan']['Apply1_month'] instanceof \think\Paginator): $i = 0; $__LIST__ = $result['apply_loan']['Apply1_month'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
                <div class="loan_list">
                    <p class="loan_list_left" style="color: #39b2ff;"><?php echo $vo['dimension']; ?></p>
                </div>
                <?php if(is_array($vo['detail']) || $vo['detail'] instanceof \think\Collection || $vo['detail'] instanceof \think\Paginator): $i = 0; $__LIST__ = $vo['detail'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?>
                <div class="loan_list">
                    <p class="loan_list_left"><?php echo $v['industry_display_name']; ?></p>
                    <p class="loan_list_right">
                        <span class="loan_tell"><?php echo $v['count']; ?></span>
                    </p>
                </div>
                <?php endforeach; endif; else: echo "" ;endif; endforeach; endif; else: echo "" ;endif; endif; ?>
            </div>
            <div class="loan_item">


                <p class="loan_ti">近3个月内（<?php if(isset($result['March']) and
                    !empty($result['March'])): ?><?php echo $result['March']; else: ?>0<?php endif; ?>次）</p>
                <?php if(isset($result['apply_loan']) and !empty($result['apply_loan']['Apply3_month'])): if(is_array($result['apply_loan']['Apply3_month']) || $result['apply_loan']['Apply3_month'] instanceof \think\Collection || $result['apply_loan']['Apply3_month'] instanceof \think\Paginator): $i = 0; $__LIST__ = $result['apply_loan']['Apply3_month'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
                <div class="loan_list">
                    <p class="loan_list_left" style="color: #39b2ff;"><?php echo $vo['dimension']; ?></p>
                </div>
                <?php if(is_array($vo['detail']) || $vo['detail'] instanceof \think\Collection || $vo['detail'] instanceof \think\Paginator): $i = 0; $__LIST__ = $vo['detail'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?>
                <div class="loan_list">
                    <p class="loan_list_left"><?php echo $v['industry_display_name']; ?></p>
                    <p class="loan_list_right">
                        <span class="loan_tell"><?php echo $v['count']; ?></span>
                    </p>
                </div>
                <?php endforeach; endif; else: echo "" ;endif; endforeach; endif; else: echo "" ;endif; endif; ?>
            </div>
            <div class="loan_item">


                <p class="loan_ti">近6个月内（<?php if(isset($result['June']) and
                    !empty($result['June'])): ?><?php echo $result['June']; else: ?>0<?php endif; ?>次）</p>
                <?php if(isset($result['apply_loan']) and !empty($result['apply_loan']['Apply6_month'])): if(is_array($result['apply_loan']['Apply6_month']) || $result['apply_loan']['Apply6_month'] instanceof \think\Collection || $result['apply_loan']['Apply6_month'] instanceof \think\Paginator): $i = 0; $__LIST__ = $result['apply_loan']['Apply6_month'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
                <div class="loan_list">
                    <p class="loan_list_left" style="color: #39b2ff;"><?php echo $vo['dimension']; ?></p>
                </div>
                <?php if(is_array($vo['detail']) || $vo['detail'] instanceof \think\Collection || $vo['detail'] instanceof \think\Paginator): $i = 0; $__LIST__ = $vo['detail'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?>
                <div class="loan_list">
                    <p class="loan_list_left"><?php echo $v['industry_display_name']; ?></p>
                    <p class="loan_list_right">
                        <span class="loan_tell"><?php echo $v['count']; ?></span>
                    </p>
                </div>
                <?php endforeach; endif; else: echo "" ;endif; endforeach; endif; else: echo "" ;endif; endif; ?>
            </div>
            <div class="loan_item">

                <?php if(isset($result['apply_loan']) and !empty($result['apply_loan']['Apply12_month'])): ?>
                <p class="loan_ti">近12个月内（<?php if(isset($result['December']) and
                    !empty($result['December'])): ?><?php echo $result['December']; else: ?>0<?php endif; ?>次）</p>

                <?php if(is_array($result['apply_loan']['Apply12_month']) || $result['apply_loan']['Apply12_month'] instanceof \think\Collection || $result['apply_loan']['Apply12_month'] instanceof \think\Paginator): $i = 0; $__LIST__ = $result['apply_loan']['Apply12_month'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
                <div class="loan_list">
                    <p class="loan_list_left" style="color: #39b2ff;"><?php echo $vo['dimension']; ?></p>
                </div>
                <?php if(is_array($vo['detail']) || $vo['detail'] instanceof \think\Collection || $vo['detail'] instanceof \think\Paginator): $i = 0; $__LIST__ = $vo['detail'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?>
                <div class="loan_list">
                    <p class="loan_list_left"><?php echo $v['industry_display_name']; ?></p>
                    <p class="loan_list_right">
                        <span class="loan_tell"><?php echo $v['count']; ?></span>
                    </p>
                </div>
                <?php endforeach; endif; else: echo "" ;endif; endforeach; endif; else: echo "" ;endif; endif; ?>
            </div>

        </div>
    </div>
    <p class="break_faith">
        <span>命中风险关注名单</span>
    </p>
    <?php if(isset($result['attention']) and !empty($result['attention'])): if(is_array($result['attention']) || $result['attention'] instanceof \think\Collection || $result['attention'] instanceof \think\Paginator): $i = 0; $__LIST__ = $result['attention'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;if(is_array($vo) || $vo instanceof \think\Collection || $vo instanceof \think\Paginator): $i = 0; $__LIST__ = $vo;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?>
    <div class="search_id">
        <div class="risk_con">
            <p>匹配类型：<span><?php echo $v['hit_type_display_name']; ?></span></p>
            <p>风险类型：<span><?php echo $v['fraud_type_display_name']; ?></span></p>
            <p>风险等级：<span><?php echo $v['risk_level']; ?></span></p>
            <p>证据时间：<span><?php echo date("Y-m-d",substr($v['evidence_time'],0,-3)); ?></span></p>
        </div>

    </div>
    <?php endforeach; endif; else: echo "" ;endif; endforeach; endif; else: echo "" ;endif; else: ?>
    <div class="search_id">
        <div class="mui-card-content-inner"
             style="padding: 30px;padding-bottom: 50px;height: 140px;background-image: url(/public/index/report/sfxx.png);background-size: 60% 155px;margin-left: 24%;background-repeat: no-repeat;"></div>
        <p style="text-align: center;clear: both;font-size:14px;">查询成功，无身份关联检测的相关信息。</p>

    </div>
    <?php endif; ?>
    <p class="basic_info basic_info1">
        <span>身份关联信息</span>
    </p>
    <?php if(isset($result['association']) and !empty($result['association'])): if(is_array($result['association']) || $result['association'] instanceof \think\Collection || $result['association'] instanceof \think\Paginator): $i = 0; $__LIST__ = $result['association'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;if(is_array($vo) || $vo instanceof \think\Collection || $vo instanceof \think\Paginator): $i = 0; $__LIST__ = $vo;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?>
    <div class="search_id">
        <div class="relation_info">
            <p class="rela_ti1"><?php echo $v['risk_name']; ?></p>
            <p class="rela_ti2"><?php echo $v['note']; ?></p>
            <p class="rela_ti2">指标个数: <span><?php echo $v['count']; ?></span></p>
            <div class="rela_ti2 clearfix">
                <p class="rela_tileft"><?php echo $v['note'] == '3个月身份证关联手机号数' ? '手机号:' : '身份证:'; ?></p>
                <p class="rela_tileft">
                    <?php if(is_array($v['data']) || $v['data'] instanceof \think\Collection || $v['data'] instanceof \think\Paginator): $i = 0; $__LIST__ = $v['data'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$b): $mod = ($i % 2 );++$i;?>
                    <span><?php echo strlen($b) == 18 ? substr_replace($b,'*******',4,-4) : substr_replace($b,'****',3,-4); ?></span>
                    <?php endforeach; endif; else: echo "" ;endif; ?>
                </p>
            </div>
        </div>
    </div>
    <?php endforeach; endif; else: echo "" ;endif; endforeach; endif; else: echo "" ;endif; else: ?>
    <div class="search_id">
        <div class="mui-card-content-inner"
             style="padding: 30px;padding-bottom: 50px;height: 140px;background-image: url(/public/index/report/sfxx.png);background-size: 60% 155px;margin-left: 24%;background-repeat: no-repeat;"></div>
        <p style="text-align: center;clear: both;font-size:14px;">查询成功，无身份关联检测的相关信息。</p>
    </div>
    <?php endif; ?>
    <p class="break_faith">
        <span>失信情况总览</span>
    </p>
    <div class="implement_box">
        <p class="implement_ti">
            <span>失信被执行人</span>
        </p>
        <?php if(isset($result['dishonesty']) and !empty($result['dishonesty'])): if(is_array($result['dishonesty']) || $result['dishonesty'] instanceof \think\Collection || $result['dishonesty'] instanceof \think\Paginator): $i = 0; $__LIST__ = $result['dishonesty'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
        <p class="implement_info">
            <span><?php if(isset($vo['case_date']) and !empty($vo['case_date']) and is_numeric($vo['case_date'])){echo date('Y-m-d',strtotime($vo['case_date']));}else if(isset($vo['case_date']) and !empty($vo['case_date']) and !is_numeric($vo['case_date'])){echo $vo['case_date']; } ?></span>
            <span><?php if(isset($vo['province']) and !empty($vo['province'])): ?><?php echo $vo['province']; endif; ?></span>
            <span> <?php if(isset($vo['execute_court']) and !empty($vo['execute_court'])): ?><?php echo $vo['execute_court']; endif; ?></span>
        </p>
        <p class="implement_item">
            <span class="info_left">风险类型：</span>
            <span class="info_right"> <?php if(isset($vo['fraud_type_display_name']) and !empty($vo['fraud_type_display_name'])): ?><?php echo $vo['fraud_type_display_name']; endif; ?></span>
        </p>
        <p class="implement_item">
            <span class="info_left">执行人姓名：</span>
            <span class="info_right"> <?php if(isset($vo['executed_name']) and !empty($vo['executed_name'])): ?><?php echo $vo['executed_name']; endif; ?></span>
        </p>
        <p class="implement_item">
            <span class="info_left">执行案号：</span>
            <span class="info_right"> <?php if(isset($vo['case_code']) and !empty($vo['case_code'])): ?><?php echo $vo['case_code']; endif; ?></span>
        </p>
        <p class="implement_item">
            <span class="info_left">性别：</span>
            <span class="info_right"> <?php if(isset($vo['gender']) and !empty($vo['gender'])): ?><?php echo $vo['gender']; endif; ?></span>
        </p>
        <p class="implement_item">
            <span class="info_left">执行法院：</span>
            <span class="info_right"> <?php if(isset($vo['evidence_court']) and !empty($vo['evidence_court'])): ?><?php echo $vo['evidence_court']; endif; ?></span>
        </p>
        <p class="implement_item">
            <span class="info_left">立案时间：</span>
            <span class="info_right"><?php if(isset($vo['case_date']) and !empty($vo['case_date']) and is_numeric($vo['case_date'])){echo date('Y-m-d',strtotime($vo['case_date']));}else if(isset($vo['case_date']) and !empty($vo['case_date']) and !is_numeric($vo['case_date'])){echo $vo['case_date']; } ?></span>
        </p>
        <p class="implement_item">
            <span class="info_left">做出执行依据单位：</span>
            <span class="info_right"> <?php if(isset($vo['evidence_court']) and !empty($vo['evidence_court'])): ?><?php echo $vo['evidence_court']; endif; ?></span>
        </p>

        <p class="implement_item">
            <span class="info_left">生效法律文书确定的义务：</span>
        <p><span style="font-size: 0.26rem;color: #333333; text-align: right; line-height: 30px;"> <?php if(isset($vo['term_duty']) and !empty($vo['term_duty'])): ?><?php echo $vo['term_duty']; endif; ?></span>
        </p>
        </p>

        <p class="implement_item">
            <span class="info_left">执行依据文号：</span>
            <span class="info_right"> <?php if(isset($vo['execute_code']) and !empty($vo['execute_code'])): ?><?php echo $vo['execute_code']; endif; ?></span>
        </p>

        <p class="implement_item">
            <span class="info_left">被执行人的履行情况：</span>
            <span class="info_right"> <?php if(isset($vo['carry_out']) and !empty($vo['carry_out'])): ?><?php echo $vo['carry_out']; endif; ?></span>
        </p>

        <?php endforeach; endif; else: echo "" ;endif; else: ?>
        <div class="mui-card-content-inner"
             style="padding: 30px;padding-bottom: 50px;height: 140px;background-image: url(/public/index/report/sfxx.png);background-size: 60% 155px;margin-left: 24%;background-repeat: no-repeat;"></div>
        <p style="text-align: center;clear: both;font-size:14px;">查询成功，无失信被执行人检测的相关信息。</p>
        <?php endif; ?>
    </div>
    <div class="implement_box">
        <p class="implement_ti">
            <span>法院被执行人</span>
        </p>
        <?php if(isset($result['carried']) and !empty($result['carried'])): foreach($result['carried'] as $vo){ if(isset($vo['term_duty']) && !empty($vo['term_duty'])){ continue; }

        ?>

        <p class="implement_info">
            <span><?php  if(isset($vo['case_date']) and !empty($vo['case_date'])){echo $vo['case_date'];} ?></span>

            <span> <?php if(isset($vo['execute_court']) and !empty($vo['execute_court'])){echo $vo['execute_court'];}  ?></span>
        </p>
        <p class="implement_item">
            <span class="info_left">执行案号：</span>
            <span class="info_right"><?php if(isset($vo['case_code']) and !empty($vo['case_code'])){echo $vo['case_code'];} ?></span>
        </p>
        <p class="implement_item">
            <span class="info_left">执行标的：</span>
            <span class="info_right"><?php if(isset($vo['execute_subject']) and !empty($vo['execute_subject'])){echo $vo['execute_subject'];} ?></span>
        </p>
        <p class="implement_item">
            <span class="info_left">立案时间：</span>
            <span class="info_right"><?php if(isset($vo['case_date']) and !empty($vo['case_date'])){echo $vo['case_date'];} ?></span>
        </p>
        <p class="implement_item">
            <span class="info_left">执行法院：</span>
            <span class="info_right"><?php if(isset($vo['evidence_court']) and !empty($vo['evidence_court'])){echo $vo['evidence_court'];}?></span>
        </p>
        <p class="implement_item">
            <span class="info_left">案件状态：</span>
            <span class="info_right"><?php if(isset($vo['execute_status']) and !empty($vo['execute_status'])){echo $vo['execute_status'];} ?></span>
        </p>
        <div class="horizontal_line"></div>

        <?php } foreach($result['carried'] as $vo){ if(!isset($vo['term_duty']) && empty($vo['term_duty'])){ continue; }

        ?>


        <p class="implement_item">
            <span class="info_left">法律文书确定的义务：</span>
            <span class="info_right"><?php if(isset($vo['term_duty']) and !empty($vo['term_duty'])){echo $vo['term_duty'];} ?></span>
        </p>
        <p class="implement_item">
            <span class="info_left">执行依据文号：</span>
            <span class="info_right"><?php if(isset($vo['execute_code']) and !empty($vo['execute_code'])){echo $vo['execute_code'];} ?></span>
        </p>
        <p class="implement_item">
            <span class="info_left">被执行人行为具体情形：</span>
            <span class="info_right"><?php if(isset($vo['specific_circumstances']) and !empty($vo['specific_circumstances'])){echo $vo['specific_circumstances'];}?></span>
        </p>
        <p class="implement_item">
            <span class="info_left">省份：</span>
            <span class="info_right"><?php if(isset($vo['province']) and !empty($vo['province'])){echo $vo['province'];}?></span>
        </p>
        <p class="implement_item">
            <span class="info_left">案件状态：</span>
            <span class="info_right"><?php if(isset($vo['fraud_type_display_name']) and !empty($vo['fraud_type_display_name'])){echo $vo['fraud_type_display_name'];} ?></span>
        </p>
        <div class="horizontal_line"></div>

        <?php } else: ?>
        <div class="mui-card-content-inner"
             style="padding: 30px;padding-bottom: 50px;height: 140px;background-image: url(/public/index/report/sfxx.png);background-size: 60% 155px;margin-left: 24%;background-repeat: no-repeat;"></div>
        <p style="text-align: center;clear: both;font-size:14px;">查询成功，无法院被执行人检测的相关信息。</p>
        <?php endif; ?>
    </div>
    <div class="plate_title">
        <span class="circular circular1"></span>
        <span class="circular circular2"></span>
        <span class="circular circular3"></span>
        联系人风险
        <span class="circular circular3"></span>
        <span class="circular circular2"></span>
        <span class="circular circular1"></span>
    </div>
    <div class="search_id contact_box">
        <p class="contact_txt">直接联系人黑名单人数：<span><?php if(isset($result['blacklist']) and !empty($result['blacklist'])): ?><?php echo $result['blacklist']; else: ?>0<?php endif; ?></span>
        </p>
        <p class="contact_txt">间接联系人黑名单人数：<span><?php if(isset($result['zjblacklist']) and !empty($result['zjblacklist'])): ?><?php echo $result['zjblacklist']; else: ?>0<?php endif; ?></span>
        </p>
        <p class="contact_txt">主动联系人人数：<span><?php if(isset($result['initiative']) and !empty($result['initiative'])): ?><?php echo $result['initiative']; else: ?>0<?php endif; ?></span>
        </p>
        <p class="contact_txt">被动联系人人数：<span><?php if(isset($result['passive']) and !empty($result['passive'])): ?><?php echo $result['passive']; else: ?>0<?php endif; ?></span>
        </p>
        <p class="contact_tips">小金说：身边的黑名单朋友过多，也会对大数据造成影响，物以类聚，人以群分。</p>
    </div>
    <p class="basic_info basic_info1">
        <span>高风险命中查询</span>
    </p>
    <div class="search_id risk_hit">
        <p class="implement_ti">
            <span>消费及汽车金融类高风险</span>
        </p>
        <div class="risk_list">
            <p>消费金融高风险<span>否</span></p>
            <p>风险类型：负债偏高</p>
        </div>
        <div class="risk_list">
            <p>融资租赁高风险<span>否</span></p>
            <p>风险类型：汽车租赁违约</p>
        </div>
        <div class="risk_list">
            <p>汽车金融高风险<span>否</span></p>
            <p>风险类型：车贷风险名单</p>
        </div>
        <div class="risk_list">
            <p>车辆租赁违约名单<span>否</span></p>
            <p>风险类型：汽车租赁违约</p>
        </div>
    </div>
    <div class="search_id risk_hit">
        <p class="implement_ti">
            <span>银行及法院类高风险</span>
        </p>
        <div class="risk_list">
            <p>银行机构高风险<span>否</span></p>
            <p>风险类型：负债率高，频繁申贷，职业异常</p>
        </div>
        <div class="risk_list">
            <p>非银行机构高风险<span>否</span></p>
            <p>风险类型：机构代办，异常审核</p>
        </div>
        <div class="risk_list">
            <p>机构关注名单
                <?php if(isset($result['fraction']) and !empty($result['fraction'])): if($result['fraction'] > '72' and $result['fraction'] < '83'): ?>
                <span class="risk_yes">是</span>
                <?php else: ?>
                <span>否</span>
                <?php endif; else: ?>
                <span>否</span>
                <?php endif; ?>
            </p>
            <p>风险类型：当事人风险指数有增高倾向</p>
        </div>
        <div class="risk_list">
            <p>法院失信名单<span>否</span></p>
            <p>风险类型：法院失信人</p>
        </div>
        <div class="risk_list">
            <p>法院执行名单<span>否</span></p>
            <p>风险类型：法院执行人</p>
        </div>
        <div class="risk_list">
            <p>犯罪通缉名单<span>否</span></p>
            <p>风险类型：刑事犯罪</p>
        </div>
    </div>
    <div class="search_id risk_hit">
        <p class="implement_ti">
            <span>风险群体类高风险</span>
        </p>
        <div class="risk_list">
            <p>风险群体名单
                <?php if(isset($result['fraction']) and !empty($result['fraction'])): if($result['fraction'] <= '40'): ?>
                <span class="risk_yes">是</span>
                <?php elseif($result['fraction'] > '40' and $result['fraction']< '61'): ?>
                <span class="risk_yes">是</span>
                <?php elseif($result['fraction'] > '60' and $result['fraction']< '73'): ?>
                <span class="risk_yes">是</span>
                <?php elseif($result['fraction'] > '72' and $result['fraction']< '83'): ?>
                <span>否</span>
                <?php elseif($result['fraction'] > '82'): ?>
                <span>否</span>
                <?php else: ?>
                <span>否</span>
                <?php endif; else: ?>
                <span>否</span>
                <?php endif; ?>
            </p>
            <p>风险类型：负债率高，频繁申贷，职业异常</p>
        </div>
        <div class="risk_list">
            <p>欺诈风险名单<span>否</span></p>
            <p>风险类型：仿冒风险，资料异常</p>
        </div>
        <div class="risk_list">
            <p>高负债名单<span>否</span></p>
            <p>风险类型：负债过高</p>
        </div>
        <div class="risk_list">
            <p>行业黑名单<span>否</span></p>
            <p>风险类型：从事行业风险过高</p>
        </div>
        <div class="risk_list">
            <p>羊毛党名单
                <?php if(isset($result['fraction']) and !empty($result['fraction'])): if($result['fraction'] <= '40'): ?>
                <span class="risk_yes">是</span>
                <?php elseif($result['fraction'] > '40' and $result['fraction']< '61'): ?>
                <span class="risk_yes">是</span>
                <?php elseif($result['fraction'] > '60' and $result['fraction']< '73'): ?>
                <span>否</span>
                <?php elseif($result['fraction'] > '72' and $result['fraction']< '83'): ?>
                <span>否</span>
                <?php elseif($result['fraction'] > '82'): ?>
                <span>否</span>
                <?php else: ?>
                <span>否</span>
                <?php endif; else: ?>
                <span>否</span>
                <?php endif; ?>
            </p>
            <p>风险类型：恶意注册，刷单</p>
        </div>
        <div class="risk_list">
            <p>恶意注册名单
                <?php if(isset($result['fraction']) and !empty($result['fraction'])): if($result['fraction'] <= '40'): ?>
                <span class="risk_yes">是</span>
                <?php elseif($result['fraction'] > '40' and $result['fraction']< '61'): ?>
                <span>否</span>
                <?php elseif($result['fraction'] > '60' and $result['fraction']< '73'): ?>
                <span>否</span>
                <?php elseif($result['fraction'] > '72' and $result['fraction']< '83'): ?>
                <span>否</span>
                <?php elseif($result['fraction'] > '82'): ?>
                <span>否</span>
                <?php else: ?>
                <span>否</span>
                <?php endif; else: ?>
                <span>否</span>
                <?php endif; ?>
            </p>
            <p>风险类型：异常支付，异常注册</p>
        </div>
        <div class="risk_list">
            <p>身份证命中高风险区域<span>否</span></p>
            <p>风险类型：身份证所属地区逾期风险较集中</p>
        </div>
    </div>
    <div class="search_id risk_hit">
        <p class="implement_ti">
            <span>信贷及逾期类高风险</span>
        </p>
        <div class="risk_list">
            <p>网络小贷高风险
                <?php if(isset($result['fraction']) and !empty($result['fraction'])): if($result['fraction'] <= '40'): ?>
                <span class="risk_yes">是</span>
                <?php elseif($result['fraction'] > '40' and $result['fraction'] < '61'): ?>
                <span class="risk_yes">是</span>
                <?php elseif($result['fraction'] > '60' and $result['fraction']< '73'): ?>
                <span class="risk_yes">是</span>
                <?php elseif($result['fraction'] > '72' and $result['fraction']< '83'): ?>
                <span>否</span>
                <?php elseif($result['fraction'] > '82'): ?>
                <span>否</span>
                <?php else: ?>
                <span>否</span>
                <?php endif; else: ?>
                <span>否</span>
                <?php endif; ?>
            </p>
            <p>风险类型：异常支付，仿冒风险</p>
        </div>
        <div class="risk_list">
            <p>线下小贷高风险<span>否</span></p>
            <p>风险类型：机构代办，资料异常</p>
        </div>
        <div class="risk_list">
            <p>信贷逾期名单<span>否</span></p>
            <p>风险类型：逾期欠款</p>
        </div>
        <div class="risk_list">
            <p>信贷逾期后还款名单
                <?php if(isset($result['fraction']) and !empty($result['fraction'])): if($result['fraction'] <= '40'): ?>
                <span class="risk_yes">是</span>
                <!-- <span style="background:red;border-radius: 18px; padding-left: 10px;padding-right: 10px; font-size:13px;color:#fff;"> 命中</span> -->
                <?php elseif($result['fraction'] > '40' and $result['fraction']< '61'): ?>
                <span class="risk_yes">是</span>
                <?php elseif($result['fraction'] > '60' and $result['fraction']< '73'): ?>
                <span>否</span>
                <?php elseif($result['fraction'] > '72' and $result['fraction']< '83'): ?>
                <span>否</span>
                <?php elseif($result['fraction'] > '82'): ?>
                <span>否</span>
                <?php else: ?>
                <span>否</span>
                <?php endif; else: ?>
                <span>否</span>
                <?php endif; ?>
            </p>
            <p>风险类型：从事行业风险过高</p>
        </div>
        <div class="risk_list">
            <p>网贷黑名单

                <?php if(isset($result['fraction']) and !empty($result['fraction'])): if($result['fraction'] <= '40'): ?>
                <span class="risk_yes">是</span>
                <?php elseif($result['fraction'] > '40' and $result['fraction']< '61'): ?>
                <span>否</span>
                <?php elseif($result['fraction'] > '60' and $result['fraction']< '73'): ?>
                <span>否</span>
                <?php elseif($result['fraction'] > '72' and $result['fraction']< '83'): ?>
                <span>否</span>
                <?php elseif($result['fraction'] > '82'): ?>
                <span>否</span>
                <?php else: ?>
                <span>否</span>
                <?php endif; else: ?>
                <span>否</span>
                <?php endif; ?>
            </p>
            <p>风险类型：信用异常</p>
        </div>
        <div class="risk_list">
            <p>网贷灰名单

                <?php if(isset($result['fraction']) and !empty($result['fraction'])): if($result['fraction'] <= '40'): ?>
                <span>否</span>
                <?php elseif($result['fraction'] > '40' and $result['fraction']< '61'): ?>
                <span class="risk_yes">是</span>
                <?php elseif($result['fraction'] > '60' and $result['fraction']< '73'): ?>
                <span class="risk_yes">是</span>
                <?php elseif($result['fraction'] > '72' and $result['fraction']< '83'): ?>
                <span>否</span>
                <?php elseif($result['fraction'] > '82'): ?>
                <span>否</span>
                <?php else: ?>
                <span>否</span>
                <?php endif; else: ?>
                <span>否</span>
                <?php endif; ?>

            </p>
            <p>风险类型：多头借款，有逾期倾向</p>
        </div>
        <div class="risk_list">
            <p>多头借贷严重名单
                <?php if(isset($result['fraction']) and !empty($result['fraction'])): if($result['fraction'] <= '40'): ?>
                <span class="risk_yes">是</span>
                <?php elseif($result['fraction'] > '40' and $result['fraction']< '61'): ?>
                <span class="risk_yes">是</span>
                <?php elseif($result['fraction'] > '60' and $result['fraction']< '73'): ?>
                <span>否</span>
                <?php elseif($result['fraction'] > '72' and $result['fraction']< '83'): ?>
                <span>否</span>
                <?php elseif($result['fraction'] > '82'): ?>
                <span>否</span>
                <?php else: ?>
                <span>否</span>
                <?php endif; else: ?>
                <span>否</span>
                <?php endif; ?>
            </p>
            <p>风险类型：频繁注册申请贷款</p>
        </div>
        <div class="risk_list">
            <p>存在信用逾期历史记录<span>否</span></p>
            <p>风险类型：逾期，逾期后还款</p>
        </div>
    </div>
    <p class="break_faith">
        <span>网贷风险信息</span>
    </p>
    <div class="search_id wagndai_risk">
        <p class="implement_item">
            <span class="info_left">身份证是否命中外部黑名单</span>
            <span class="info_right">否</span>
        </p>
        <p class="implement_item">
            <span class="info_left">身份证是否命中高风险关注名单</span>
            <span class="info_right">否</span>
        </p>
        <p class="implement_item">
            <span class="info_left">手机号是否命中高风险关注名单</span>
            <span class="info_right">否</span>
        </p>
        <p class="implement_item">
            <span class="info_left">手机号是否命中通讯小库号</span>
            <span class="info_right">否</span>
        </p>
        <p class="implement_item">
            <span class="info_left">手机号是否命中虚假号码库</span>
            <span class="info_right">否</span>
        </p>
        <p class="implement_item">
            <span class="info_left">手机号是否命中诈骗骚扰库</span>
            <span class="info_right">否</span>
        </p>
        <p class="implement_item">
            <span class="info_left">身份证是否命中风险群体网络</span>
            <span class="info_right">否</span>
        </p>
        <p class="implement_item">
            <span class="info_left">身份证对应人是否存在助学贷款欠费历史</span>
            <span class="info_right">否</span>
        </p>
    </div>
    <p class="basic_info basic_info1">
        <span>身份证风险对应信息</span>
    </p>
    <div class="search_id wagndai_risk">
        <p class="implement_item">
            <span class="info_left">身份证格式校验错误</span>
            <span class="info_right">未发现</span>
        </p>
     
        <p class="implement_item">
            <span class="info_left">身份证命中犯罪通缉名单</span>
            <span class="info_right">未发现</span>
        </p>
 
        <p class="implement_item">
            <span class="info_left">身份证对应人存在助学贷款欠费历史</span>
            <span class="info_right">未发现</span>
        </p>
        <p class="implement_item">
            <span class="info_left">身份证命中高风险关注名单</span>
            <span class="info_right">未发现</span>
        </p>
      
        <p class="implement_item">
            <span class="info_left">身份证命中欠款公司法人代表名单</span>
            <span class="info_right">未发现</span>
        </p>
        <p class="implement_item">
            <span class="info_left">身份证命中欠税公司法人代表名单</span>
            <span class="info_right">未发现</span>
        </p>
        <p class="implement_item">
            <span class="info_left">身份证命中故意违章乘车名单</span>
            <span class="info_right">未发现</span>
        </p>
        <p class="implement_item">
            <span class="info_left">身份证命中欠税名单</span>
            <span class="info_right">未发现</span>
        </p>
    </div>
    <p class="break_faith">
        <span>手机号对应风险信息</span>
    </p>
    <div class="search_id wagndai_risk">
        <p class="implement_item">
            <span class="info_left">手机号命中虚假号码库</span>
            <span class="info_right">未发现</span>
        </p>
        <p class="implement_item">
            <span class="info_left">手机号命中通信小号库</span>
            <span class="info_right">未发现</span>
        </p>
        <p class="implement_item">
            <span class="info_left">手机号命中诈骗骚扰库</span>
            <span class="info_right">未发现</span>
        </p>
        <p class="implement_item">
            <span class="info_left">手机号命中高风险关注名单</span>
            <span class="info_right">未发现</span>
        </p>
     
        <p class="implement_item">
            <span class="info_left">手机号疑似乱填</span>
            <span class="info_right">未发现</span>
        </p>
        <p class="implement_item">
            <span class="info_left">手机号命中欠款公司法人代表名单</span>
            <span class="info_right">未发现</span>
        </p>
    </div>
    <p class="basic_info basic_info1">
        <span>多头借贷风险分析</span>
    </p>
    <div class="search_id wagndai_risk">
        <p class="implement_item">
            <span class="info_left">7天内设备或身份证或手机号申请次数过多</span>
            <span class="info_right">未发现</span>
        </p>
        <p class="implement_item">
            <span class="info_left">1个月内同一个设备或手机号申请被拒次数过多</span>
            <span class="info_right">未发现</span>
        </p>
        <p class="implement_item">
            <span class="info_left">1个月内设备或身份证或手机号申请次数过多</span>
            <span class="info_right">未发现</span>
        </p>
        <p class="implement_item">
            <span class="info_left">3个月内身份证关联多个申请信息</span>
            <span class="info_right">未发现</span>
        </p>
        <p class="implement_item">
            <span class="info_left">3个月内申请信息关联多个身份证</span>
            <span class="info_right">未发现</span>
        </p>
        <p class="implement_item">
            <span class="info_left">3个月内申请人身份证关联配偶手机数过多</span>
            <span class="info_right">未发现</span>
        </p>
        <p class="implement_item">
            <span class="info_left">3个月内申请人身份证关联母亲手机数过多</span>
            <span class="info_right">未发现</span>
        </p>
        <p class="implement_item">
            <span class="info_left">3个月内申请人身份证关联父亲手机数过多</span>
            <span class="info_right">未发现</span>
        </p>
        <p class="implement_item">
            <span class="info_left">3个月内申请人身份证作为联系人出现的次数过多</span>
            <span class="info_right">未发现</span>
        </p>
        <p class="implement_item">
            <span class="info_left">3个月内申请人在多个平台被放款 </span>
            <span class="info_right">未发现</span>
        </p>
    </div>
    <p class="break_faith">
        <span>放款平台</span>
    </p>
    <div class="search_id loan_box">
        <?php if(isset($result['apply_loan']['loan']) and !empty($result['apply_loan']['loan'])): if(is_array($result['apply_loan']['loan']) || $result['apply_loan']['loan'] instanceof \think\Collection || $result['apply_loan']['loan'] instanceof \think\Paginator): $i = 0; $__LIST__ = $result['apply_loan']['loan'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
        <div class="search_id risk_hit">
            <p class="implement_ti">
                <span><?php echo $vo['dimension']; ?></span>
            </p>
            <?php if(is_array($vo['detail']) || $vo['detail'] instanceof \think\Collection || $vo['detail'] instanceof \think\Paginator): $i = 0; $__LIST__ = $vo['detail'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?>
            <div class="risk_list">
                <p><?php echo $v['industry_display_name']; ?><span class="loan_tell"><?php echo $v['count']; ?></span></p>
            </div>
            <?php endforeach; endif; else: echo "" ;endif; ?>
        </div>
        <?php endforeach; endif; else: echo "" ;endif; else: ?>
        <div class="search_id">
            <div class="mui-card-content-inner"
                 style="padding: 30px;padding-bottom: 50px;height: 140px;background-image: url(/public/index/report/sfxx.png);background-size: 60% 155px;margin-left: 24%;background-repeat: no-repeat;"></div>
            <p style="text-align: center;clear: both;font-size:14px;">查询成功，无放款平台检测的相关信息。</p>

        </div>
        <?php endif; ?>
    </div>
    <p class="break_faith">
        <span>实名信息验证</span>
    </p>
    <div class="idinfo_date">
        <div class="details_item">
            <p class="details_ti">身份证关联信息</p>
            <div class="details_bot">
                <p class="implement_item">
                    <span class="info_left">关联手机号个数</span>
                    <span class="info_right">
                        <?php if(isset($result['January']) and !empty($result['January'])): ?><?php echo ceil($result['January']*0.2); else: ?>1<?php endif; ?></span>
                </p>
                <p class="implement_item">
                    <span class="info_left">关联邮箱个数</span>
                    <span class="info_right"><?php if(isset($result['January']) and !empty($result['January'])): ?><?php echo ceil($result['January']*0.3); else: ?>1<?php endif; ?></span>
                </p>
                <p class="implement_item">
                    <span class="info_left">关联姓名个数</span>
                    <span class="info_right"><?php if(isset($result['January']) and !empty($result['January'])): ?><?php echo ceil($result['January']*0.2); else: ?>1<?php endif; ?></span>
                </p>
                <p class="implement_item">
                    <span class="info_left">关联家庭地址个数</span>
                    <span class="info_right">
                        <?php $b = isset($result['January']) && !empty($result['January']) ? ceil($result['January']*0.4) : 0; echo isset($result['January']) && !empty($result['January']) ? ($b > 2 ? $b : 2) :2 ; ?>
                    </span>
                </p>
                <p class="implement_item">
                    <span class="info_left">关联公司地址个数</span>
                    <span class="info_right"><?php if(isset($result['January']) and !empty($result['January'])): ?><?php echo ceil($result['January']*0.2); else: ?>0<?php endif; ?></span>
                </p>
                <p class="implement_item">
                    <span class="info_left">身份证号是否关联异常</span>
                    <span class="info_right">否</span>
                </p>
            </div>
        </div>
    </div>


    <div class="conceal_propose">
        <div class="plate_title">
            <span class="circular circular1"></span>
            <span class="circular circular2"></span>
            <span class="circular circular3"></span>
            提高评分消除风险建议
            <span class="circular circular3"></span>
            <span class="circular circular2"></span>
            <span class="circular circular1"></span>
        </div>
        <div class="search_id propose_box">
            <p>1.三个月不要注册申请超过20次贷款，控制申请频率</p>
            <p>2.如果有逾期或者被执行等不良记录，保持良好的信用1-2年，记录可以滚动覆盖过去</p>
            <p>3.保持良好的借贷习惯，切勿频繁申请，拒绝不明平台的审核邀请</p>
            <p>4.信用卡一年申请不超过6次，含同一机构，网贷3个月内申请不超过20次</p>
            <p>5.减少和网贷黑名单这类人群的联系，使自己的朋友圈都是优良高素质群体</p>
        </div>
        <div class="plate_title">
            <span class="circular circular1"></span>
            <span class="circular circular2"></span>
            <span class="circular circular3"></span>
            申贷小技巧
            <span class="circular circular3"></span>
            <span class="circular circular2"></span>
            <span class="circular circular1"></span>
        </div>
        <div class="search_id propose_box">
            <p>1.下载借款APP及申请的时候，平台需要获取定位、通讯录等权限，务必选择允许或者同意</p>
            <p>2.务必使用自己的实名制手机号，且号码使用超过半年</p>
            <p>3.如果手机号非本人实名，暂时只申请查征信上征信类的贷款，这类贷款不看重手机号是否实名制</p>
            <p>4.预留的联系人一定不能是银行或网贷有不良记录的，通话记录一定要和本人较多的</p>
            <p>5.删除手机中关于贷款、中介、赌博、网贷有逾期未还者</p>
            <p>6.把预留的三个联系人在通讯录中改成真名</p>
            <p>7.把支付宝收货地址多的删掉，留下一个家庭和一个公司的</p>
            <p>8.把支付宝的网贷授权取消掉，申请网贷的同时，申请完一家，申请第二家的时候取消上一家的授权</p>
            <p>9.淘宝的收获地址尽量与支付宝保持一致</p>
            <p>10.放款机构普遍认为已婚有子女、高学历者，稳定性高，逾期率低，更容易通过</p>
            <p>11.人脸识别五官露出来，不带眼镜帽子，光线适中</p>
            <p>12.签字必须要正楷，字迹不可潦草</p>
            <p>13.接回访电话时，按照所填资料如实回答，表现自己的还款意愿和还款能力，信用卡账单尽量网银导入</p>
            <p>14。下载及申请的时候，务必使用手机自带的流量，关闭WIFI信号</p>
        </div>
        <div class="plate_title">
            <span class="circular circular1"></span>
            <span class="circular circular2"></span>
            <span class="circular circular3"></span>
            贷款最难及容易通过的行业
            <span class="circular circular3"></span>
            <span class="circular circular2"></span>
            <span class="circular circular1"></span>
        </div>
        <div class="search_id propose_box">
            <p>
                <span>最难通过的行业</span>
            </p>
            <p>1.房地产有关的所有行业，包括建筑、装饰、建材、房产中介</p>
            <p>2.美容美发</p>
            <p>3.KTV</p>
            <p>4.洗脚城</p>
            <p>5.农林渔牧</p>
            <p>6.金融行业</p>
        </div>
        <div class="search_id propose_box">
            <p>
                <span>容易通过的行业</span>
            </p>
            <p>1.大型国企事业单位</p>
            <p>2.连锁型商场、超市</p>
            <p>3.大型工厂</p>
            <p>4.医药行业</p>
            <p>5.科技公司</p>
            <p>6.商贸公司</p>
            <p>7.汽车用品</p>
            <p>8.物流公司</p>
            <p class="industry_tips">小金说：有实体经营，收入稳定的公司更容易通过贷款申请哦！</p>
        </div>
    </div>
    <button class="see_more_btn">点击查看更多信息</button>
    <div class="bot_box">
        <p class="data_txt">
            信千金报告由本人授权查询，数据来源包括芝麻信用、各大运营商、各类征信平台、各大贷款平台、京东、淘宝等众多平台，信千金只做大数据信息的获取及分析，不对原始数据做任何修改，信用报告仅供参考使用。如你对报告有异议，出于对合作平台数据隐私的保护，信千金将不做任何解释。</p>
        <img class="go_top" src="__PUBLIC__/img/fanhuidingbu.png" alt="">
    </div>
</div>
<script>
    var bu = 1;
    var nums = $(".score_num span").text();

    function zhuan() {
        $(".score_num span").text(bu);
        bu++;
        if (bu > nums) {
            clearInterval(setin);
        }
    }

    var setin = setInterval(zhuan, 15)

    function run() {
    	var scorecashon = '<?php if(isset($result['fraction']) and !empty($result['fraction'])): ?> <?php echo $result['fraction']; else: ?>95<?php endif; ?>';
        var num = parseInt(scorecashon) + 3;
        var bar = document.getElementById("bar");
        var total = document.getElementById("total");
        bar.style.width = parseInt(bar.style.width) + 1 + "%";
        total.innerHTML = bar.style.width;
        if (bar.style.width == num + "%") {
            window.clearTimeout(timeout);
            return;
        }
        var timeout = window.setTimeout("run()", 10);
    }

    run();
</script>
</body>
</html>