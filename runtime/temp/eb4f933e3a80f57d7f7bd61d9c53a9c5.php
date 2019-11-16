<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:40:"./themes/dailishang/chaxun/portrait.html";i:1572863610;s:29:"./themes/dailishang/base.html";i:1572661643;}*/ ?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <title>信千金代理商后台管理</title>
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <link rel="stylesheet" href="__JS__/layui/css/layui.css" media="all">
    <link rel="stylesheet" href="__CSS__/font-awesome.min.css">
	<link rel="Shortcut Icon" type="image/x-icon" href="/favicon.ico">
    <!--CSS引用-->
    
    <link rel="stylesheet" href="__PUBLIC__/css/style.css">
    <link rel="stylesheet" href="__PUBLIC__/css/portrait.css?v=123456">

    <link rel="stylesheet" href="__CSS__/admin.css">
    <!--[if lt IE 9]>
    <script src="__CSS__/html5shiv.min.js"></script>
    <script src="__CSS__/respond.min.js"></script>
    <![endif]-->
    <style>
    	.layui-nav-itemed>a{
    		background: #406cef!important;
    	}
    	.layui-nav-tree .layui-nav-bar{
    		background: #406cef!important;
    	}
    </style>
  	 
</head>
<body>
<div class="layui-layout layui-layout-admin">
    <!--头部-->
    <div class="layui-header header" style="background:#26386d;">
        <a href=""><img class="logo" src="__STATIC__/images/logo_admin.png" alt="" width="177px"></a>
        <ul class="layui-nav" style="position: absolute;top: 0;right: 20px;background: none;">
            <li class="layui-nav-item"><a href="<?php echo url('www.melongs.cn/index/login/login'); ?>" target="_blank">前台首页</a></li>
           
            <li class="layui-nav-item">
                <a href="javascript:;"><?php echo session('dailishang_names'); ?></a>
                <dl class="layui-nav-child"> <!-- 二级菜单 -->
                    <dd><a href="<?php echo url('dailishang/ChangePassword/index'); ?>">修改密码</a></dd>
                    <dd><a href="<?php echo url('dailishang/login/logout'); ?>">退出登录</a></dd>
                </dl>
            </li>
        </ul>
    </div>

    <!--侧边栏-->
    <div class="layui-side layui-bg-black" style="background:#1d294d;">
        <div class="layui-side-scroll">
            <ul class="layui-nav layui-nav-tree" style="background:#1d294d;">
                <!--管锐更改地方-->
				<!--管锐开始
				<li class="layui-nav-item">
                    <a href="<?php echo url('admin/index/index'); ?>"><i class="fa fa-home"></i> 网站信息</a>
                </li>
				管锐结束-->
				
                <?php if(is_array($menu) || $menu instanceof \think\Collection || $menu instanceof \think\Paginator): if( count($menu)==0 ) : echo "" ;else: foreach($menu as $key=>$vo): if(isset($vo['children'])): ?>
                <li class="layui-nav-item layui-nav-itemed">
                    <a href="javascript:;"><i class="<?php echo $vo['icon']; ?>"></i> <?php echo $vo['title']; ?></a>
                    <dl class="layui-nav-child">
                        <?php if(is_array($vo['children']) || $vo['children'] instanceof \think\Collection || $vo['children'] instanceof \think\Paginator): if( count($vo['children'])==0 ) : echo "" ;else: foreach($vo['children'] as $key=>$v): ?>
                        <dd><a href="<?php echo url($v['name']); ?>"> <?php echo $v['title']; ?></a></dd>
                        <?php endforeach; endif; else: echo "" ;endif; ?>
                    </dl>
                </li>
                <?php else: ?>
                <li class="layui-nav-item">
                    <a href="<?php echo url($vo['name']); ?>"><i class="<?php echo $vo['icon']; ?>"></i> <?php echo $vo['title']; ?></a>
                </li>
                <?php endif; endforeach; endif; else: echo "" ;endif; ?>

                <li class="layui-nav-item" style="height: 30px; text-align: center"></li>
            </ul>
        </div>
    </div>

    <!--主体-->
    
<div class="layui-body" style="">
    <div class="layui-tab layui-tab-brief">
        <ul class="layui-tab-title">
            <a href="<?php echo url('admin/chaxun/index'); ?>">
                <li class="layui-this">返回</li>
            </a>
            <li>查询信息</li>
            <a href="http://www.xalanfeng.cn/index/login/view.html?dingdanids=<?php echo $dingdanid; ?>" target="_blank">
                <li class="layui-this"> 前台地址</li>
            </a>
        </ul>
       <style>
           .container {
               min-width: 320px;
               max-width: 750px;
               margin: 0 auto;
               position: relative;
           }
           .num{
               position: absolute;
               width: 100%;
               top: 2rem;
               text-align: center;
               font-size: 0.4rem;
               font-weight: bold;
               color: #39b2ff;
           }
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
            <p>是否银联高端用户：<?php if(isset($result['YLZC007']) && !empty($result['YLZC007'])): ?><?php echo $result['YLZC007']; else: ?>无<?php endif; ?></p>
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
                    <p>消费偏好：<?php if(isset($result['YLZC010']) && !empty($result['YLZC010'])): ?><?php echo $result['YLZC010']; else: ?>无<?php endif; ?></p>
                </div>
                <img class="ability_pic3" src="__PUBLIC__/img/bank/t6.png" alt="">
            </div>
        </div>
    </div>


    <!--底部-->
    <div class="layui-footer footer">
        <div class="layui-main">
            <p>2018 - 2021  </p>
        </div>
    </div>
</div>

<script>
    // 定义全局JS变量
    var GV = {
        current_controller: "admin/<?php echo (isset($controller) && ($controller !== '')?$controller:''); ?>/",
        base_url: "__STATIC__"
    };
</script>
<!--JS引用-->
<script src="__JS__/jquery.min.js"></script>
<script src="__JS__/layui/lay/dest/layui.all.js"></script>
<script src="__PUBLICS__/layer/layer.js"></script>
<script src="__JS__/admin.js"></script>


<!--页面JS脚本-->

</body>
</html>