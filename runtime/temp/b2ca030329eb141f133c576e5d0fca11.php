<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:32:"./themes/admin/chaxun/index.html";i:1571815584;s:24:"./themes/admin/base.html";i:1571969829;}*/ ?>
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
            <li class="layui-this">查询管理</li>
        </ul>
        <div class="layui-tab-content">
                <div class="layui-tab-item layui-show">
				  <form class="layui-form layui-form-pane" id="myform" action="<?php echo url('admin/chaxun/index'); ?>" method="get">
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
                            <th>版本</th>
                            <th>谁查的</th>
                            <th>推荐人</th>
                            <th>等级</th>
                            <th>查询时间</th>
                            <th>价格</th>
                            <th>查询姓名</th>
                            <th>渠道</th>
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
                            <td><?php echo $vo['product_name']; ?></td>
                            <td><?php echo $vo['names']; ?></td>
                            <td><a href="<?php echo url('/admin/useragent/index',['uid'=>$vo['suid']]); ?>" style="color: #4b9ffa;"><?php echo $vo['pnames']; ?></a></td>
                            <td><?php echo $vo['agent_name']; ?></td>
                            <td><?php echo date("Y-m-d H:i:s",$vo['dates']); ?></td>
                            <td><?php echo $vo['price']; ?></td>
                            <td><?php echo $vo['namess']; ?></td>
                            <td><a href="<?php echo url('/admin/useragent/index',['uid'=>$vo['fuid']]); ?>" style="color: #4b9ffa;"><?php echo $vo['manames']; ?></a></td>
                            <td><?php echo $vo['idcard']; ?></td>
							<td><?php echo $vo['tel']; ?></td>
							
                            <td>
                                <span data-id="<?php echo $vo['id']; ?>" class="detail layui-btn layui-btn-normal layui-btn-mini">详情</span>
                            </td>
                        </tr>
                        <?php endforeach; endif; else: echo "" ;endif; ?>
                        </tbody>
                    </table>
					<div style="float:right; font-size:20px;"> 今日人数：<?php echo $countjin; ?> | 今日金额：<?php echo $sumjin; ?> 元 | 用户人数：<?php echo $count; ?> | 金额：<?php echo $sum; ?> 元</div>
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
<script src="__JS__/admin.js"></script>


<!--页面JS脚本-->

<script>
  	$(function(){
		$('.detail').click(function(){
			var THIS = $(this);
			var id = THIS.data('id');
			$.post("<?php echo url('admin/chaxun/checkid'); ?>",{'id':id},function(res){
				if(res == 1){
					alert('报告超过7天，数据已清理');return false;
				}
				else{
					window.location.href="<?php echo url('admin/chaxun/xiangqing'); ?>?id="+id;
				}
			})
		})
	})
    function addOne(){
		$.get("<?php echo url('admin/chaxun/form'); ?>",function(data){
			$(".form_customer:first").prepend(data);
			form.render('select');
		});
	}
	function excel(){
		 $("#myform").attr('action',"<?php echo url('admin/chaxun/excel'); ?>");
	}
	function search(){
		 $("#myform").attr('action',"<?php echo url('admin/chaxun/index'); ?>");
	}
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