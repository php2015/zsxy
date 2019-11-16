<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:34:"./themes/admin/withdraw/index.html";i:1571989888;s:24:"./themes/admin/base.html";i:1571969829;}*/ ?>
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
    
<div class="layui-body">
    <!--tab标签-->
    <div class="layui-tab layui-tab-brief">
        <ul class="layui-tab-title">
            <li class="layui-this">提现管理</li>
            <li class=""><a href="<?php echo url('admin/withdraw/add'); ?>">添加提现</a></li>
        </ul>
        <div class="layui-tab-content">
            <div class="layui-tab-item layui-show">
			  <form class="layui-form layui-form-pane" action="<?php echo url('admin/withdraw/index'); ?>" method="get">
				<!--<a class="layui-btn layui-btn-normal layui-btn-radius" target="_blank" href="<?php echo url('admin/user/getAll',['id'=>$vo['id']]); ?>" class="layui-btn layui-btn-normal layui-btn-mini">组织架构图</a>-->
                    <div class="layui-inline">
                        <label class="layui-form-label">关键词</label>
                        <div class="layui-input-inline">
                            <input type="text" name="keyword" value="<?php echo $keyword; ?>" placeholder="请输入关键词" class="layui-input">
                        </div>
                    </div>
					<div class="layui-inline">
						<label class="layui-form-label">开始时间</label>
						<div class="layui-input-inline">
						<input type="text" class="layui-input datetime" name="date1" id="date1" value="<?php echo $date1; ?>">
						</div>
					</div>
					<div class="layui-inline">
						<label class="layui-form-label">结束时间</label>
						<div class="layui-input-inline">
						<input type="text" class="layui-input datetime" name="date2" id="date2" value="<?php echo $date2; ?>">
						</div>
					</div>
                    <div class="layui-inline">
                        <button class="layui-btn">搜索</button>
						
                    </div>
                </form>
                <hr>
                    <table class="layui-table">
                        <thead>
                        <tr>
                        	<th>用户ID</th>
                            <th>用户</th>
                            <th>金额</th>
                            <th>类型</th>
							<th>提现名</th>
							<th>手机</th>
                            <th>卡号</th>
                            <th>状态</th>
                            <th>时间</th>
                            <th>操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php if(is_array($withdraw_list) || $withdraw_list instanceof \think\Collection || $withdraw_list instanceof \think\Paginator): if( count($withdraw_list)==0 ) : echo "" ;else: foreach($withdraw_list as $key=>$vo): ?>
                        <tr>
                        	<td><?php echo $vo['uids']; ?></td>
                            <td><?php echo $vo['names']; ?></td>
                            <td><?php echo $vo['money']; ?></td>
                            <td><?php echo $vo['type']; ?></td>
                            <td><?php echo $vo['wname']; ?></td>
                            <td><?php echo $vo['phone']; ?></td>
                            <td><?php echo $vo['bankcard']; ?></td>
                            <td><?php echo $vo['status']==1 ? '已支付' : '未支付'; ?></td>
                            <td><?php echo date("m-d H:i:s",$vo['create_time']); ?></td>
                            <td>
							<?php if($vo['status']==0): ?>
								<a href="<?php echo url('admin/withdraw/pay',['id'=>$vo['id']]); ?>" class="layui-btn layui-btn-normal layui-btn-mini">支付处理</a>
								<?php endif; ?>
                                <a href="<?php echo url('admin/withdraw/edit',['id'=>$vo['id']]); ?>" class="layui-btn layui-btn-normal layui-btn-mini">编辑</a>
                                <a href="<?php echo url('admin/withdraw/delete',['id'=>$vo['id']]); ?>" class="layui-btn layui-btn-danger layui-btn-mini ajax-delete">删除</a>
								
                            </td>
                        </tr>
                        <?php endforeach; endif; else: echo "" ;endif; ?>
                        </tbody>
                    </table>
					<div style="float:right; font-size:20px;"> 总金额：<?php echo $sum; ?>元</div>
                    <!--分页-->
                    <?php echo $withdraw_list->render(); ?>
                </div>
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
<script src="__JS__/admin.js"></script>


<!--页面JS脚本-->

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