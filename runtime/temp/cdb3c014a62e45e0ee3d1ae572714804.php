<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:36:"./themes/admin/chaxun/viewagent.html";i:1573211109;s:24:"./themes/admin/base.html";i:1571969829;}*/ ?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <title>信千金CMS后台管理</title>
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <link rel="stylesheet" href="__JS__/layui/css/layui.css" media="all">
    <link rel="stylesheet" href="__CSS__/font-awesome.min.css">
	<link rel="Shortcut Icon" type="image/x-icon" href="/favicon.ico">
    <!--CSS引用-->
    
    <link rel="stylesheet" href="__PUBLIC__/css/fxcss/mui.min.css">
    <link rel="stylesheet" href="__PUBLIC__/css/fxcss/style.css">
    <link rel="stylesheet" href="__PUBLIC__/css/fxcss/index.css?v=78945">

    <link rel="stylesheet" href="__CSS__/admin.css">
    <!--[if lt IE 9]>
    <script src="__CSS__/html5shiv.min.js"></script>
    <script src="__CSS__/respond.min.js"></script>
    <![endif]-->
    
</head>
<body>
<div class="layui-layout layui-layout-admin">
    <!--头部-->
    <div class="layui-header header">
        <a href=""><img class="logo" src="__STATIC__/images/logo_admin.png" alt="" width="177px"></a>
		<i id="menu_btn" class="fa fa-bars" style="font-size: 20px;color:#fff;position:absolute;top:20px;left:220px;"></i>
        <ul class="layui-nav" style="position: absolute;top: 0;right: 20px;background: none;">
            <li class="layui-nav-item"><a href="<?php echo url('www.melongs.cn/index/login/login'); ?>" target="_blank">前台首页</a></li>
            <li class="layui-nav-item">
                <a href="javascript:;"><?php echo session('names'); ?></a>
                <dl class="layui-nav-child"> <!-- 二级菜单 -->
                    <dd><a href="<?php echo url('admin/change_password/index'); ?>">修改密码</a></dd>
                    <dd><a href="<?php echo url('admin/login/logout'); ?>">退出登录</a></dd>
                </dl>
            </li>
        </ul>
    </div>

    <!--侧边栏-->
    <div class="layui-side layui-bg-black">
        <div class="layui-side-scroll">
            <ul class="layui-nav layui-nav-tree">
                <li class="layui-nav-item layui-nav-title"><a>管理菜单</a></li>
                <!--管锐更改地方-->
				<!--管锐开始
				<li class="layui-nav-item">
                    <a href="<?php echo url('admin/index/index'); ?>"><i class="fa fa-home"></i> 网站信息</a>
                </li>
				管锐结束-->
				<li class="layui-nav-item">
                    <a href="<?php echo url('admin/index/index'); ?>"><i class="fa fa-home"></i> 系统信息</a>
                </li>
                <?php if(is_array($menu) || $menu instanceof \think\Collection || $menu instanceof \think\Paginator): if( count($menu)==0 ) : echo "" ;else: foreach($menu as $key=>$vo): if(isset($vo['children'])): ?>
                <li class="layui-nav-item">
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
    	color: #373a5a;
    	font-size: 0.7rem;
    	font-weight: bold;
    	margin: 0.4rem 0px 0 0.5rem;
	}
	
	.p_index_yonhs{
		position: absolute;
    	z-index: 99999;
    	color: #373a5a;
    	font-size: 0.43rem;
    	font-weight: bold;
    	margin: 1.3rem 0px 0 0.5rem;
	}
	
	.p_index_yonhss{
		position: absolute;
    	z-index: 99999;
    	color: #fff;
        font-size: 0.5rem;
    	font-weight: bold;
    	margin: 0.78rem 0px 0 5.06rem;
	}
	.score_item {
		width: 100%;
    	float: left;
	}
    .lan_list_left_1 {
        font-family: PingFang-SC-Bold;
        font-size: 0.2rem;
        letter-spacing: 0px;
        color: #333333;
    }

    .lan_list_left_2 {
        font-family: PingFang-SC-Medium;
        font-size: 0.2rem;
        font-weight: normal;
        font-stretch: normal;
        letter-spacing: 0px;
        color: #5961cd;
    }

    .quota_left_2 {
        font-family: PingFang-SC-Bold;
        font-size: 71px;
        font-weight: normal;
        font-stretch: normal;
        letter-spacing: 0px;
        color: #fff36d;
    }
</style>
<body>
<div class="container">
    <div class="score_box">
        <div class="zsxy_ti">
            <img src="img/xlogo.png" alt="">
        </div>
        <div class="score_grade"><span><?php if(isset($result['dj']) and !empty($result['dj'])): ?> <?php echo $result['dj']; endif; ?>级</span></div>
        <div class="star_box">
            <img src="__PUBLIC__/imgfxs/star_y.png" alt="">
            <img src="__PUBLIC__/imgfxs/star_y.png" alt="">
            <img src="__PUBLIC__/imgfxs/star_y.png" alt="">
            <img src="__PUBLIC__/imgfxs/star_y.png" alt="">
            <img src="__PUBLIC__/imgfxs/star_w.png" alt="">
        </div>
        <div class="score_num">
            <span><?php if(isset($result['fen']) and !empty($result['fen'])): ?> <?php echo $result['fen']; endif; ?></span>
        </div>
        <p class="score_user">您的评分指数</p>
        <div class="score_press">
            <div class="press_blue" id="bar" style="width: 0%;">
                <img src="__PUBLIC__/imgfxs/huojian.png" alt="">
            </div>
        </div>
        <p class="score_per">满分100分，分数越高信用越好<span id="total" style="display: none;"></span></p>
    </div>
    <p class="basic_info" style="display:none;">
        <span>基本信息</span>
    </p>
    <div class="user_card">
        <p class="username"><?php if(isset($result['opnames']) and !empty($result['opnames'])): ?> <?php echo $result['opnames']; endif; ?>&nbsp;&nbsp;<?php if(isset($result['age']) and !empty($result['age'])): ?> <?php echo $result['age']; else: ?>0<?php endif; ?>岁&nbsp;&nbsp;<?php echo $result['ren']; ?></p>
        <div class="user_info">
            <p>
                <img src="__PUBLIC__/imgfxs/shoujihao.png" alt=""><?php if(isset($result['mobile']) and
                !empty($result['mobile'])): ?> <?php echo $result['mobile']; endif; ?>
            </p>
        </div>
        <div class="user_info">
            <p>
                <img src="__PUBLIC__/imgfxs/shenfenzheng.png" alt=""><?php if(isset($result['opcard']) and !empty($result['opcard'])): ?> <?php echo $result['opcard']; endif; ?>
            </p>
        </div>
        <div class="user_info">
            <p>
                <img src="__PUBLIC__/imgfxs/dizhi.png" alt=""><?php if(isset($result['province']) and !empty($result['province'])): ?> <?php echo $result['province']; endif; ?>
            </p>
        </div>
      
        <p class="init_time">报告生成时间：<?php if(isset($result['createAt']) and !empty($result['createAt'])): ?>
            <?php echo $result['createAt']; endif; ?></p>
        <p class="init_time">报告失效时间：<?php if(isset($result['createAts']) and !empty($result['createAts'])): ?>
            <?php echo $result['createAts']; endif; ?></p>
            
        
        <p class="init_time">商户单号：
            <?php if(isset($result['out_trade_no']) and !empty($result['out_trade_no'])): ?><?php echo $result['out_trade_no']; endif; ?>
        </p>
        <p class="init_time">交易单号：
            <?php if(isset($result['transaction_id']) and
            !empty($result['transaction_id'])): ?><?php echo $result['transaction_id']; endif; ?>
        </p>
        <div class="user_tag">
            <p><span>个人信息</span></p>
        </div>
    </div>
    <div class="quota_box">
        <div class="quota_item clearfix">
            <div class="quota_left">
                <p>信用卡预测额度</p>
                <p><?php if(isset($result['fen']) and !empty($result['fen'])): if($result['fen'] <= '40'): ?>
                    5000以下
                    <?php elseif($result['fen'] > '40' and $result['fen']< '61'): ?>
                    5千—1.5万
                    <?php elseif($result['fen'] > '60' and $result['fen']< '73'): ?>
                    1万—2万
                    <?php elseif($result['fen'] > '72' and $result['fen']< '83'): ?>
                    1.5万—3万
                    <?php elseif($result['fen'] > '82'): ?>
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
                	 <?php if(isset($result['fen']) and !empty($result['fen'])): if($result['fen'] <= '40'): ?>
                    10000以下
                    <?php elseif($result['fen'] > '40' and $result['fen']< '61'): ?>
                    8千—2万
                    <?php elseif($result['fen'] > '60' and $result['fen']< '73'): ?>
                    1.5万—3万
                    <?php elseif($result['fen'] > '72' and $result['fen']< '83'): ?>
                    3万—5万
                    <?php elseif($result['fen'] > '82'): ?>
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
    <p class="basic_info basic_info1">
        <span>信用风险评分</span>
    </p>
    <p class="subtitle"><span></span>CREDIT RISK RATING</p>
    <div class="intention_box">
        <div class="intention_wrap">
            <div class="inten_score">
                <span><?php if(isset($result['CPL0082']) && !empty($result['CPL0082'])): ?><?php echo $result['CPL0082']; else: ?>0<?php endif; ?></span>
                <p>履约金额综合指数</p>
            </div>
            <div class="inten_score1">
                <span><?php if(isset($result['CPL0081']) && !empty($result['CPL0081'])): ?><?php echo $result['CPL0081']; else: ?>0<?php endif; ?></span>
                <div class="clearfix"></div>
                <p>信用风险评分</p>
            </div>
            <div class="inten_score2">
                <span><?php if(isset($result['CPL0083']) && !empty($result['CPL0083'])): ?><?php echo $result['CPL0083']; else: ?>0<?php endif; ?></span>
                <p>履约笔数综合指数</p>
            </div>
        </div>
        <img src="__PUBLIC__/imgfxs/xian.png">
        <p class="inten_explain">分数说明</p>
        <p class="inten_explain1">0-100之间，分数越高用户信用越低</p>
        <p class="inten_explain1">0-100之间，指数越大用户逾期可能性越高</p>
    </div>
    <p class="basic_info basic_info1">
        <span>信用逾期说明</span>
    </p>
    <p class="subtitle"><span></span>STATEMENT OF OVERDUE CREDIT</p>
    <div class="search_id loan_box">
        <div class="loan_list loan_list1">
            <p class="loan_list_left">当前是否逾期</p>
            <p class="loan_list_right">
                <span class="loan_tell"><?php if(isset($result['CPL0044']) && $result['CPL0044'] == 1): ?>逾期<?php else: ?>未逾期<?php endif; ?></span>
            </p>
        </div>
        <img class="xian_bor" src="__PUBLIC__/imgfxs/xian.png">
        <div class="loan_list loan_list1">
            <p class="loan_list_left">是否存在逾期未结清</p>
        </div>
        <img class="xian_bor" src="__PUBLIC__/imgfxs/xian.png">
        <div class="loan_list">
            <p class="loan_list_left">最近7天</p>
            <p class="loan_list_right">
                <span class="loan_tell"><?php if(isset($result['CPL0004']) && $result['CPL0004'] == 1): ?>逾期<?php else: ?>未逾期<?php endif; ?></span>
            </p>
        </div>
        <div class="loan_list">
            <p class="loan_list_left">最近14天</p>
            <p class="loan_list_right">
                <span class="loan_tell"><?php if(isset($result['CPL0005']) && $result['CPL0005'] == 1): ?>逾期<?php else: ?>未逾期<?php endif; ?></span>
            </p>
        </div>
        <div class="loan_list">
            <p class="loan_list_left">最近21天</p>
            <p class="loan_list_right">
                <span class="loan_tell"><?php if(isset($result['CPL0047']) && $result['CPL0047'] == 1): ?>逾期<?php else: ?>未逾期<?php endif; ?></span>
            </p>
        </div>
        <div class="loan_list">
            <p class="loan_list_left">最近30天</p>
            <p class="loan_list_right">
                <span class="loan_tell"><?php if(isset($result['CPL0006']) && $result['CPL0006'] == 1): ?>逾期<?php else: ?>未逾期<?php endif; ?></span>
            </p>
        </div>
        <img class="xian_bor loan_list2" src="__PUBLIC__/imgfxs/xian.png">
        <div class="loan_list loan_list1">
            <p class="loan_list_left">是否发生过逾期</p>
        </div>
        <div class="loan_list">
            <p class="loan_list_left">最近7天</p>
            <p class="loan_list_right">
                <span class="loan_tell"><?php if(isset($result['CPL0029']) && $result['CPL0029'] == 1): ?>逾期<?php else: ?>未逾期<?php endif; ?></span>
            </p>
        </div>
        <div class="loan_list">
            <p class="loan_list_left">最近14天</p>
            <p class="loan_list_right">
                <span class="loan_tell"><?php if(isset($result['CPL0030']) && $result['CPL0030'] == 1): ?>逾期<?php else: ?>未逾期<?php endif; ?></span>
            </p>
        </div>
        <div class="loan_list">
            <p class="loan_list_left">最近30天</p>
            <p class="loan_list_right">
                <span class="loan_tell"><?php if(isset($result['CPL0031']) && $result['CPL0031'] == 1): ?>逾期<?php else: ?>未逾期<?php endif; ?></span>
            </p>
        </div>
    </div>
    <div class="dk_fate">
        <p class="fate_ti1">天数</p>
        <p class="fate_ti2">信用贷款</p>
        <div class="fate_box"><?php if(isset($result['CPL0045']) && !empty($result['CPL0045'])): ?><?php echo $result['CPL0045']; else: ?>0<?php endif; ?>天</div>
    </div>
    <p class="basic_info basic_info1">
        <span>贷款机构数</span>
    </p>
    <p class="subtitle"><span></span>NUMBER OF LEADING INSTITUTIONS</p>
    <div class="search_id loan_box">
        <div class="loan_list loan_list1">
            <p class="loan_list_left">总机构数</p>
            <p class="loan_list_right">
                <span class="loan_tell"><?php if(isset($result['CPL0001']) && !empty($result['CPL0001'])): ?><?php echo $result['CPL0001']; else: ?>0<?php endif; ?></span>
            </p>
        </div>
        <div class="loan_list loan_list1">
            <p class="loan_list_left">已结清机构数</p>
            <p class="loan_list_right">
                <span class="loan_tell"><?php if(isset($result['CPL0002']) && !empty($result['CPL0002'])): ?><?php echo $result['CPL0002']; else: ?>0<?php endif; ?></span>
            </p>
        </div>
        <img class="xian_bor" src="__PUBLIC__/imgfxs/xian.png">
        <div class="loan_list loan_list1">
            <p class="loan_list_left">贷款机构数</p>
        </div>
        <div class="loan_list">
            <p class="loan_list_left">最近7天</p>
            <p class="loan_list_right">
                <span class="loan_tell"><?php if(isset($result['CPL0009']) && !empty($result['CPL0009'])): ?><?php echo $result['CPL0009']; else: ?>0<?php endif; ?></span>
            </p>
        </div>
        <div class="loan_list">
            <p class="loan_list_left">最近14天</p>
            <p class="loan_list_right">
                <span class="loan_tell"><?php if(isset($result['CPL0010']) && !empty($result['CPL0010'])): ?><?php echo $result['CPL0010']; else: ?>0<?php endif; ?></span>
            </p>
        </div>
        <div class="loan_list">
            <p class="loan_list_left">最近21天</p>
            <p class="loan_list_right">
                <span class="loan_tell"><?php if(isset($result['CPL0063']) && !empty($result['CPL0063'])): ?><?php echo $result['CPL0063']; else: ?>0<?php endif; ?></span>
            </p>
        </div>
        <div class="loan_list">
            <p class="loan_list_left">最近30天</p>
            <p class="loan_list_right">
                <span class="loan_tell"><?php if(isset($result['CPL0011']) && !empty($result['CPL0011'])): ?><?php echo $result['CPL0011']; else: ?>0<?php endif; ?></span>
            </p>
        </div>
        <div class="loan_list">
            <p class="loan_list_left">最近90天</p>
            <p class="loan_list_right">
                <span class="loan_tell"><?php if(isset($result['CPL0012']) && !empty($result['CPL0012'])): ?><?php echo $result['CPL0012']; else: ?>0<?php endif; ?></span>
            </p>
        </div>
        <div class="loan_list">
            <p class="loan_list_left">最近180天</p>
            <p class="loan_list_right">
                <span class="loan_tell"><?php if(isset($result['CPL0013']) && !empty($result['CPL0013'])): ?><?php echo $result['CPL0013']; else: ?>0<?php endif; ?></span>
            </p>
        </div>
    </div>
    <div class="quota_box">
        <div class="quota_item quota_item2 clearfix">
            <div class="quota_left">
                <p><?php if(isset($result['CPL0007']) && !empty($result['CPL0007'])): ?><?php echo $result['CPL0007']; else: ?>0<?php endif; ?></p>
                <p>消费金融类机构数</p>
                <p>有场景的、分期</p>
            </div>
            <div class="quota_left">
                <p><?php if(isset($result['CPL0008']) && !empty($result['CPL0008'])): ?><?php echo $result['CPL0008']; else: ?>0<?php endif; ?></p>
                <p>网络贷款类机构数</p>
                <p>现金贷</p>
            </div>
        </div>
    </div>
    <p class="basic_info basic_info1">
        <span>交易失败笔数/金额</span>
    </p>
    <p class="subtitle"><span></span>NUMBER OF FAILED TRADES</p>
    <div class="search_id loan_box">
        <div class="loan_list loan_list1">
            <p class="loan_list_left">历史贷款机构交易失败笔数</p>
            <p class="loan_list_right">
                <span class="loan_tell"><?php if(isset($result['CPL0015']) && !empty($result['CPL0015'])): ?><?php echo $result['CPL0015']; else: ?>0<?php endif; ?>笔</span>
            </p>
        </div>
        <img class="xian_bor" src="__PUBLIC__/imgfxs/xian.png">
        <div class="trade_tabbox">
            <table class="trade_tab">
                <tr>
                    <td></td>
                    <td>交易失败笔数</td>
                    <td>交易失败金额</td>
                </tr>
                <tr>
                    <td>最近7天</td>
                    <td><?php if(isset($result['CPL0018']) && !empty($result['CPL0018'])): ?><?php echo $result['CPL0018']; else: ?>0<?php endif; ?></td>
                    <td><?php if(isset($result['CPL0034']) && !empty($result['CPL0034'])): ?><?php echo $result['CPL0034']; else: ?>0<?php endif; ?></td>
                </tr>
                <tr>
                    <td>最近14天</td>
                    <td><?php if(isset($result['CPL0020']) && !empty($result['CPL0020'])): ?><?php echo $result['CPL0020']; else: ?>0<?php endif; ?></td>
                    <td><?php if(isset($result['CPL0036']) && !empty($result['CPL0036'])): ?><?php echo $result['CPL0036']; else: ?>0<?php endif; ?></td>
                </tr>
                <tr>
                    <td>最近21天</td>
                    <td><?php if(isset($result['CPL0065']) && !empty($result['CPL0065'])): ?><?php echo $result['CPL0065']; else: ?>0<?php endif; ?></td>
                    <td><?php if(isset($result['CPL0066']) && !empty($result['CPL0066'])): ?><?php echo $result['CPL0066']; else: ?>0<?php endif; ?></td>
                </tr>
                <tr>
                    <td>最近30天</td>
                    <td><?php if(isset($result['CPL0022']) && !empty($result['CPL0022'])): ?><?php echo $result['CPL0022']; else: ?>0<?php endif; ?></td>
                    <td><?php if(isset($result['CPL0038']) && !empty($result['CPL0038'])): ?><?php echo $result['CPL0038']; else: ?>0<?php endif; ?></td>
                </tr>
                <tr>
                    <td>最近90天</td>
                    <td><?php if(isset($result['CPL0024']) && !empty($result['CPL0024'])): ?><?php echo $result['CPL0024']; else: ?>0<?php endif; ?></td>
                    <td><?php if(isset($result['CPL0040']) && !empty($result['CPL0040'])): ?><?php echo $result['CPL0040']; else: ?>0<?php endif; ?></td>
                </tr>
                <tr>
                    <td>最近180天</td>
                    <td><?php if(isset($result['CPL0026']) && !empty($result['CPL0026'])): ?><?php echo $result['CPL0026']; else: ?>0<?php endif; ?></td>
                    <td><?php if(isset($result['CPL0042']) && !empty($result['CPL0042'])): ?><?php echo $result['CPL0042']; else: ?>0<?php endif; ?></td>
                </tr>
            </table>
        </div>
    </div>
    <p class="basic_info basic_info1">
        <span>还款成功笔数/金额</span>
    </p>
    <p class="subtitle"><span></span>NUMBER OF SUCCESS TRADES</p>
    <div class="search_id loan_box">
        <div class="loan_list loan_list1">
            <p class="loan_list_left">历史贷款机构成功还款笔数</p>
            <p class="loan_list_right">
                <span class="loan_tell"><?php if(isset($result['CPL0014']) && !empty($result['CPL0014'])): ?><?php echo $result['CPL0014']; else: ?>0<?php endif; ?>笔</span>
            </p>
        </div>
        <img class="xian_bor" src="__PUBLIC__/imgfxs/xian.png">
        <div class="trade_tabbox">
            <table class="trade_tab">
                <tr>
                    <td></td>
                    <td>还款成功笔数</td>
                    <td>还款成功金额(元)</td>
                </tr>
                <tr>
                    <td>最近7天</td>
                    <td><?php if(isset($result['CPL0019']) && !empty($result['CPL0019'])): ?><?php echo $result['CPL0019']; else: ?>0<?php endif; ?></td>
                    <td><?php if(isset($result['CPL0035']) && !empty($result['CPL0035'])): ?><?php echo $result['CPL0035']; else: ?>0<?php endif; ?></td>
                </tr>
                <tr>
                    <td>最近14天</td>
                    <td><?php if(isset($result['CPL0021']) && !empty($result['CPL0021'])): ?><?php echo $result['CPL0021']; else: ?>0<?php endif; ?></td>
                    <td><?php if(isset($result['CPL0037']) && !empty($result['CPL0037'])): ?><?php echo $result['CPL0037']; else: ?>0<?php endif; ?></td>
                </tr>
                <tr>
                    <td>最近21天</td>
                    <td><?php if(isset($result['CPL0064']) && !empty($result['CPL0064'])): ?><?php echo $result['CPL0064']; else: ?>0<?php endif; ?></td>
                    <td><?php if(isset($result['CPL0067']) && !empty($result['CPL0067'])): ?><?php echo $result['CPL0067']; else: ?>0<?php endif; ?></td>
                </tr>
                <tr>
                    <td>最近30天</td>
                    <td><?php if(isset($result['CPL0023']) && !empty($result['CPL0023'])): ?><?php echo $result['CPL0023']; else: ?>0<?php endif; ?></td>
                    <td><?php if(isset($result['CPL0039']) && !empty($result['CPL0039'])): ?><?php echo $result['CPL0039']; else: ?>0<?php endif; ?></td>
                </tr>
                <tr>
                    <td>最近90天</td>
                    <td><?php if(isset($result['CPL0025']) && !empty($result['CPL0025'])): ?><?php echo $result['CPL0025']; else: ?>0<?php endif; ?></td>
                    <td><?php if(isset($result['CPL0041']) && !empty($result['CPL0041'])): ?><?php echo $result['CPL0041']; else: ?>0<?php endif; ?></td>
                </tr>
                <tr>
                    <td>最近180天</td>
                     <td><?php if(isset($result['CPL0027']) && !empty($result['CPL0027'])): ?><?php echo $result['CPL0027']; else: ?>0<?php endif; ?></td>
                    <td><?php if(isset($result['CPL0043']) && !empty($result['CPL0043'])): ?><?php echo $result['CPL0043']; else: ?>0<?php endif; ?></td>
                </tr>
            </table>
        </div>
    </div>


    <p class="basic_info basic_info1">
        <span>消费金融类</span>
    </p>
    <p class="subtitle"><span></span>CONSUMER FINANCE</p>
    <div class="search_id loan_box">
        <div class="loan_list loan_list1">
            <p class="loan_list_left lan_list_left_1" style="font-size: 0.28rem;">最后一次交易失败后还款次数</p>
            <p class="loan_list_right">
                <span class="loan_tell lan_list_left_2" style="font-size: 0.28rem;"><?php if(isset($result['CPL0069']) && !empty($result['CPL0069'])): ?><?php echo $result['CPL0069']; else: ?>0<?php endif; ?>次</span>
            </p>
        </div>
        <img class="xian_bor" src="__PUBLIC__/imgfxs/xian.png">
        <div class="loan_list loan_list1">
            <p class="loan_list_left lan_list_left_1" style="font-size: 0.28rem;">交易失败到下一次还款成功最短天数</p>
            <p class="loan_list_right">
                <span class="loan_tell lan_list_left_2" style="font-size: 0.28rem;"><?php if(isset($result['CPL0057']) && !empty($result['CPL0057'])): ?><?php echo $result['CPL0057']; else: ?>0<?php endif; ?> 天</span>
            </p>
        </div>
        <img class="xian_bor" src="__PUBLIC__/imgfxs/xian.png">
        <div class="loan_list loan_list1">
            <p class="loan_list_left lan_list_left_1" style="font-size: 0.28rem;">交易失败到下一次还款成功最长天数</p>
            <p class="loan_list_right">
                <span class="loan_tell lan_list_left_2" style="font-size: 0.28rem;"><?php if(isset($result['CPL0054']) && !empty($result['CPL0054'])): ?><?php echo $result['CPL0054']; else: ?>0<?php endif; ?>天</span>
            </p>
        </div>
        <img class="xian_bor" src="__PUBLIC__/imgfxs/xian.png">
        <div class="loan_list loan_list1">
            <p class="loan_list_left lan_list_left_1" style="font-size: 0.28rem;">交易失败到下一次还款成功的平均天数</p>
            <p class="loan_list_right">
                <span class="loan_tell lan_list_left_2" style="font-size: 0.28rem;"><?php if(isset($result['CPL0060']) && !empty($result['CPL0060'])): ?><?php echo $result['CPL0060']; else: ?>0<?php endif; ?>天</span>
            </p>
        </div>
        <img class="xian_bor" src="__PUBLIC__/imgfxs/xian.png">
    </div>


    <p class="basic_info basic_info1">
        <span>小贷担保类</span>
    </p>
    <p class="subtitle"><span></span>SMALL LOAN GUARANTEE CLASS</p>
    <div class="search_id loan_box">
        <div class="loan_list loan_list1">
            <p class="loan_list_left lan_list_left_1" style="font-size: 0.28rem;">最后一次交易失败后还款次数</p>
            <p class="loan_list_right">
                <span class="loan_tell lan_list_left_2" style="font-size: 0.28rem;"><?php if(isset($result['CPL0053']) && !empty($result['CPL0053'])): ?><?php echo $result['CPL0053']; else: ?>0<?php endif; ?>次</span>
            </p>
        </div>
        <img class="xian_bor" src="__PUBLIC__/imgfxs/xian.png">
        <div class="loan_list loan_list1">
            <p class="loan_list_left lan_list_left_1" style="font-size: 0.28rem;">交易失败到下一次还款成功最短天数</p>
            <p class="loan_list_right">
                <span class="loan_tell lan_list_left_2" style="font-size: 0.28rem;"><?php if(isset($result['CPL0058']) && !empty($result['CPL0058'])): ?><?php echo $result['CPL0058']; else: ?>0<?php endif; ?>天</span>
            </p>
        </div>
        <img class="xian_bor" src="__PUBLIC__/imgfxs/xian.png">
        <div class="loan_list loan_list1">
            <p class="loan_list_left lan_list_left_1" style="font-size: 0.28rem;">交易失败到下一次还款成功最长天数</p>
            <p class="loan_list_right">
                <span class="loan_tell lan_list_left_2" style="font-size: 0.28rem;"><?php if(isset($result['CPL0055']) && !empty($result['CPL0055'])): ?><?php echo $result['CPL0055']; else: ?>0<?php endif; ?>天</span>
            </p>
        </div>
        <img class="xian_bor" src="__PUBLIC__/imgfxs/xian.png">
        <div class="loan_list loan_list1">
            <p class="loan_list_left lan_list_left_1" style="font-size: 0.28rem;">交易失败到下一次还款成功的平均天数</p>
            <p class="loan_list_right">
                <span class="loan_tell lan_list_left_2" style="font-size: 0.28rem;"><?php if(isset($result['CPL0061']) && !empty($result['CPL0061'])): ?><?php echo $result['CPL0061']; else: ?>0<?php endif; ?>天</span>
            </p>
        </div>
        <img class="xian_bor" src="__PUBLIC__/imgfxs/xian.png">
    </div>


    <p class="basic_info basic_info1">
        <span>交易信息</span>
    </p>
    <p class="subtitle"><span></span>SMALL LOAN GUARANTEE CLASS</p>
    <div class="search_id loan_box">
        <div class="loan_list loan_list1">
            <p class="loan_list_left lan_list_left_1" style="font-size: 0.28rem;">最近一次交易距离当前天数</p>
            <p class="loan_list_right">
                <span class="loan_tell lan_list_left_2" style="font-size: 0.28rem;"><?php if(isset($result['CPL0068']) && !empty($result['CPL0068'])): ?><?php echo $result['CPL0068']; else: ?>0<?php endif; ?>天</span>
            </p>
        </div>
        <img class="xian_bor" src="__PUBLIC__/imgfxs/xian.png">
        <div class="loan_list loan_list1">
            <p class="loan_list_left lan_list_left_1" style="font-size: 0.28rem;">最后一次交易失败后还款次数</p>
            <p class="loan_list_right">
                <span class="loan_tell lan_list_left_2" style="font-size: 0.28rem;"><?php if(isset($result['CPL0069']) && !empty($result['CPL0069'])): ?><?php echo $result['CPL0069']; else: ?>0<?php endif; ?>次</span>
            </p>
        </div>
        <img class="xian_bor" src="__PUBLIC__/imgfxs/xian.png">
        <div class="loan_list loan_list1">
            <p class="loan_list_left lan_list_left_1" style="font-size: 0.28rem;">交易失败到下一次还款成功最短天数</p>
            <p class="loan_list_right">
                <span class="loan_tell lan_list_left_2" style="font-size: 0.28rem;"><?php if(isset($result['CPL0059']) && !empty($result['CPL0059'])): ?><?php echo $result['CPL0059']; else: ?>0<?php endif; ?>天</span>
            </p>
        </div>
        <img class="xian_bor" src="__PUBLIC__/imgfxs/xian.png">
        <div class="loan_list loan_list1">
            <p class="loan_list_left lan_list_left_1" style="font-size: 0.28rem;">交易失败到下一次还款成功最长天数</p>
            <p class="loan_list_right">
                <span class="loan_tell lan_list_left_2" style="font-size: 0.28rem;"><?php if(isset($result['CPL0056']) && !empty($result['CPL0056'])): ?><?php echo $result['CPL0056']; else: ?>0<?php endif; ?>天</span>
            </p>
        </div>
        <img class="xian_bor" src="__PUBLIC__/imgfxs/xian.png">
        <div class="loan_list loan_list1">
            <p class="loan_list_left lan_list_left_1" style="font-size: 0.28rem;">交易失败到下一次还款成功的平均天数</p>
            <p class="loan_list_right">
                <span class="loan_tell lan_list_left_2" style="font-size: 0.28rem;"><?php if(isset($result['CPL0062']) && !empty($result['CPL0062'])): ?><?php echo $result['CPL0062']; else: ?>0<?php endif; ?>天</span>
            </p>
        </div>
        <img class="xian_bor" src="__PUBLIC__/imgfxs/xian.png">
    </div>


    <p class="basic_info basic_info1">
        <span>还款信息</span>
    </p>
    <p class="subtitle"><span></span>REPAYMENT INFORMATION</p>
    <div class="quota_box" style="margin-top: 0.2rem;">
        <div class="quota_item quota_item4 clearfix">
            <div class="quota_left">
                <p style="font-family: PingFang-SC-Bold;font-size: 0.5rem;font-weight: normal;font-stretch: normal;letter-spacing: 0px;color: #fff36d;">
                   <?php if(isset($result['CPL0068']) && !empty($result['CPL0068'])): ?><?php echo $result['CPL0068']; else: ?>0<?php endif; ?>天</p>
                <p style="	font-family: PingFang-SC-Bold;font-size: 0.3rem;font-weight: normal;font-stretch: normal;color: #ffffff;">
                    最近一次还款成功距离<br/>
                    当前天数</p>
            </div>
            <div class="quota_left">
                <p style="font-family: PingFang-SC-Bold;font-size: 0.5rem;font-weight: normal;font-stretch: normal;letter-spacing: 0px;color: #fff36d;">
                    <?php if(isset($result['CPL0076']) && !empty($result['CPL0076'])): ?><?php echo $result['CPL0076']; else: ?>0<?php endif; ?>笔</p>
                <p style="	font-family: PingFang-SC-Bold;font-size: 0.3rem;font-weight: normal;font-stretch: normal;color: #ffffff;">
                    近20次还款成功笔数
                </p>
            </div>
        </div>
    </div>

    <div class="quota_box" style="margin-top: 0.2rem;">
        <div class="quota_item quota_item5 clearfix">
            <div class="quota_left">
                <p style="font-family: PingFang-SC-Bold;font-size: 0.5rem;font-weight: normal;font-stretch: normal;letter-spacing: 0px;color: #fff36d;">
                    <?php if(isset($result['CPL0077']) && !empty($result['CPL0077'])): ?><?php echo $result['CPL0077'] * 200; else: ?>0<?php endif; ?>元</p>
                <p style="	font-family: PingFang-SC-Bold;font-size: 0.3rem;font-weight: normal;font-stretch: normal;color: #ffffff;">
                    近5次还款成功总金额</p>
            </div>
            <div class="quota_left">
                <p style="font-family: PingFang-SC-Bold;font-size: 0.5rem;font-weight: normal;font-stretch: normal;letter-spacing: 0px;color: #fff36d;">
                     <?php if(isset($result['CPL0078']) && !empty($result['CPL0078'])): ?><?php echo $result['CPL0078'] * 200; else: ?>0<?php endif; ?>元</p>
                <p style="	font-family: PingFang-SC-Bold;font-size: 0.3rem;font-weight: normal;font-stretch: normal;color: #ffffff;">
                    近20次还款成功总金额
                </p>
            </div>
        </div>
    </div>

  



    <p class="basic_info basic_info1">
        <span>失信情况总览</span>
    </p>
    <p class="subtitle"><span></span>GENERAL INFORMATION ON BREACH OF TRUST</p>
    <div class="implement_box">
       <div class="mui-card-content-inner"
             style="padding: 30px;padding-bottom: 50px;height: 140px;background-image: url(/public/index/report/sfxx.png);background-size: 60% 155px;margin-left: 24%;background-repeat: no-repeat;"></div>
        <p style="text-align: center;clear: both;font-size:14px;">查询成功，无失信被执行人检测的相关信息。</p>
    </div>
    <div class="implement_box">
       <div class="mui-card-content-inner"
             style="padding: 30px;padding-bottom: 50px;height: 140px;background-image: url(/public/index/report/sfxx.png);background-size: 60% 155px;margin-left: 24%;background-repeat: no-repeat;"></div>
        <p style="text-align: center;clear: both;font-size:14px;">查询成功，无法院被执行人检测的相关信息。</p>
    </div>


    <p class="basic_info basic_info1">
        <span>网贷风险信息</span>
    </p>
    <p class="subtitle"><span></span>NETWORK LOAN RISK INFORMATION</p>
    <div class="search_id wagndai_risk">
        <p class="implement_item">
            <span class="info_left">手机号是否命中网贷重点关注名单</span>
            <span class="info_right">否</span>
        </p>
        <p class="implement_item">
            <span class="info_left">身份证是否命中网贷重点关注名单</span>
            <span class="info_right">否</span>
        </p>
        <p class="implement_item">
            <span class="info_left">身份证是否命中外部黑名单</span>
            <span class="info_right">否</span>
        </p>
        <p class="implement_item">
            <span class="info_left">身份证是否存在信贷逾期历史记录</span>
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
            <span class="info_left">身份证是否命中信贷逾期后还款名单</span>
            <span class="info_right">否</span>
        </p>
        <p class="implement_item">
            <span class="info_left">身份证是否命中车辆租赁违约名单</span>
            <span class="info_right">否</span>
        </p>
        <p class="implement_item">
            <span class="info_left">身份证对应人是否存在助学贷款欠费历史</span>
            <span class="info_right">否</span>
        </p>
    </div>
    <p class="basic_info basic_info1">
        <span>手机号对应风险信息</span>
    </p>
    <p class="subtitle"><span></span>CELLPHONE NUMBER CORRESPONDS</p>
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
            <span class="info_left">手机号命中信贷逾期名单</span>
            <span class="info_right">未发现</span>
        </p>
        <p class="implement_item">
            <span class="info_left">手机号命中车辆租赁违约名单</span>
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
        <p class="implement_item">
            <span class="info_left">手机号命中信贷逾期后还款名单</span>
            <span class="info_right">未发现</span>
        </p>
    </div>
    <p class="basic_info basic_info1">
        <span>身份证风险对应信息</span>
    </p>
    <p class="subtitle"><span></span>IDCARD RISK INFORMATION</p>
    <div class="search_id wagndai_risk">
        <p class="implement_item">
            <span class="info_left">身份证格式校验错误</span>
            <span class="info_right">未发现</span>
        </p>
        <p class="implement_item">
            <span class="info_left">身份证归属地位于高风险较为集中地区</span>
            <span class="info_right">未发现</span>
        </p>
        <p class="implement_item">
            <span class="info_left">身份证命中法院失信名单</span>
            <span class="info_right">未发现</span>
        </p>
        <p class="implement_item">
            <span class="info_left">身份证命中犯罪通缉名单</span>
            <span class="info_right">未发现</span>
        </p>
        <p class="implement_item">
            <span class="info_left">身份证命中法院执行名单</span>
            <span class="info_right">未发现</span>
        </p>
        <p class="implement_item">
            <span class="info_left">身份证命中法院结案名单</span>
            <span class="info_right">未发现</span>
        </p>
        <p class="implement_item">
            <span class="info_left">身份证命中信贷逾期名单</span>
            <span class="info_right">未发现</span>
        </p>
        <p class="implement_item">
            <span class="info_left">身份证命中信贷逾期后还款名单</span>
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
            <span class="info_left">身份证命中车辆租赁违约名单</span>
            <span class="info_right">未发现</span>
        </p>
        <p class="implement_item">
            <span class="info_left">身份证姓名命中信贷逾期模糊名单</span>
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
<script src="__JS__/admin.js"></script>


  <script src="__PUBLIC__/js/mui.min.js"></script>
    <script src="__PUBLIC__/js/jquery.min.js"></script>
    <script src="__PUBLIC__/js/index.js"></script>

<!--页面JS脚本-->

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
        var bar = document.getElementById("bar");
        var total = document.getElementById("total");
        bar.style.width = parseInt(bar.style.width) + 1 + "%";
        total.innerHTML = bar.style.width;
        if (bar.style.width == "75%") {
            window.clearTimeout(timeout);
            return;
        }
        var timeout = window.setTimeout("run()", 10);
    }

    run();
</script>

</body>
<script>
    $(function(){
        $("#menu_btn").click(function(){
            $('.layui-side').animate({width:'toggle'},350,function(){
                if($(".layui-side").is(":hidden")){
                    $(".layui-body").css({"left":"10px","transition":"0.35s"});
                    $(".layui-footer").css({"left":"0px","transition":"0.35s"});
                }else{
                    $(".layui-body").css({"left":"210px","transition":"0.35s"});
                    $(".layui-footer").css({"left":"200px","transition":"0.35s"});
                }
            });
            
        })
    })
</script>
</html>