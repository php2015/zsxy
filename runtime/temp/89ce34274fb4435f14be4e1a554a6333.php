<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:37:"./themes/dailishang/chaxun/index.html";i:1571815573;s:29:"./themes/dailishang/base.html";i:1572661643;}*/ ?>
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
    
<div class="layui-body">
    <!--tab标签-->
    <div class="layui-tab layui-tab-brief">
        <ul class="layui-tab-title">
            <li class="layui-this">查询管理</li>
        </ul>
        <div class="layui-tab-content">
                <div class="layui-tab-item layui-show">
				  <form class="layui-form layui-form-pane" id="myform" action="<?php echo url('dailishang/chaxun/index'); ?>" method="get">
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
									<button onclick="search()" class="layui-btn">搜索</button>
					</div>
                    	<div class="layui-inline">
									<button onclick="excel()" class="layui-btn">导出EXCEL</button>
								</div>
                </form>
                <hr>
                    <table class="layui-table">
                        <thead>
                        <tr>
                            <th style="width: 30px;">ID</th>
                          	<th>付款场景</th>
                           	<th>订单编号</th>
                            <th>查询时间</th>
                            <th>查询类型</th>
                            <th>价格</th>
                            <th>查询姓名</th>
                            <th>查询身份证</th>
                            <th>查询电话</th>
                            <th>操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php if(is_array($chaxun_list) || $chaxun_list instanceof \think\Collection || $chaxun_list instanceof \think\Paginator): if( count($chaxun_list)==0 ) : echo "" ;else: foreach($chaxun_list as $key=>$vo): ?>
                        <tr>
                           	<td><?php echo $vo['id']; ?></td>
                          	<td><?php echo $vo['source']==2 ? '<span style="color:green;">支付宝</span>' : '<span style="color:red;">微信</span>'; ?></td>
                            <td><?php echo $vo['ordernumber']; ?></td>
                            <td><?php echo date("Y-m-d H:i:s",$vo['dates']); ?></td>
                            <td><?php echo $vo['product_name']; ?></td>
                            <td><?php echo $vo['price']; ?></td>
                            <td><?php echo $vo['namess']; ?></td>
                            <td><?php echo $vo['idcard']; ?></td>
							<td><?php echo $vo['tel']; ?></td>
                            <td>
                                <span data-id="<?php echo $vo['id']; ?>" class="detail layui-btn layui-btn-normal layui-btn-mini">详情</span>
                            </td>
                        </tr>
                        <?php endforeach; endif; else: echo "" ;endif; ?>
                        </tbody>
                    </table>
					<div style="float:right; font-size:20px;"> 用户人数：<?php echo $count; ?></div>
                    <!--分页-->
                    <?php echo $chaxun_list->render(); ?>
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
<script src="__PUBLICS__/layer/layer.js"></script>
<script src="__JS__/admin.js"></script>


<!--页面JS脚本-->

<script>
  	$(function(){
		$('.detail').click(function(){
			var THIS = $(this);
			var id = THIS.data('id');
			$.post("<?php echo url('dailishang/chaxun/checkid'); ?>",{'id':id},function(res){
				if(res == 1){
					alert('报告超过7天，数据已清理');return false;
				}
				else{
					window.location.href="<?php echo url('dailishang/chaxun/xiangqing'); ?>?id="+id;
				}
			})
		})
	})
    function addOne(){
		$.get("<?php echo url('dailishang/chaxun/form'); ?>",function(data){
			$(".form_customer:first").prepend(data);
			form.render('select');
		});
	}
	function excel(){
		 $("#myform").attr('action',"<?php echo url('dailishang/chaxun/excel'); ?>");
	}
	function search(){
		 $("#myform").attr('action',"<?php echo url('dailishang/chaxun/index'); ?>");
	}
</script>

</body>
</html>