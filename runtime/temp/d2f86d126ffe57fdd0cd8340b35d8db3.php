<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:34:"./themes/admin/useragent/edit.html";i:1572238710;s:24:"./themes/admin/base.html";i:1571969829;}*/ ?>
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
            <li class=""><a href="<?php echo url('admin/useragent/index'); ?>">代理商管理</a></li>
            <li class=""><a href="<?php echo url('admin/useragent/add'); ?>">添加代理商</a></li>
            <li class="layui-this">编辑代理商</li>
        </ul>
        <div class="layui-tab-content">
            <div class="layui-tab-item layui-show">
                <form class="layui-form form-container" action="<?php echo url('admin/useragent/update'); ?>" method="post">
                    <div class="layui-form-item">
                        <label class="layui-form-label">姓名</label>
                        <div class="layui-input-block">
                            <input type="text" name="names" value="<?php echo $user['names']; ?>" required lay-verify="required" placeholder="请输入姓名" class="layui-input">
                        </div>
                    </div>
                   <!-- <div class="layui-form-item">
                        <label class="layui-form-label">身份证</label>
                        <div class="layui-input-block">
                            <input type="text" name="idcard" value="<?php echo $user['idcard']; ?>" required lay-verify="required|identity" placeholder="请输入身份证" class="layui-input">
                        </div>
                    </div>-->
					<div class="layui-form-item">
                        <label class="layui-form-label">密码</label>
                        <div class="layui-input-block">
                            <input type="text" name="password" placeholder="留空为不改密码" class="layui-input">
                        </div>
                    </div>
                    <div class="layui-form-item">
                        <label class="layui-form-label">电话</label>
                        <div class="layui-input-block">
                            <input type="text" name="mobile" value="<?php echo $user['mobile']; ?>" required lay-verify="required|phone|number" placeholder="请输入手机" class="layui-input">
                        </div>
                    </div>
					<div class="layui-form-item">
                        <label class="layui-form-label">代理商</label>
                        <div class="layui-input-block">
							<select name="agent_class" lay-search>
								<option value="0">无代理商</option>
								<?php if(is_array($agent_list) || $agent_list instanceof \think\Collection || $agent_list instanceof \think\Paginator): if( count($agent_list)==0 ) : echo "" ;else: foreach($agent_list as $key=>$vo): ?>
                                <option value="<?php echo $vo['id']; ?>" <?php if($user['agent_class']==$vo['id']): ?> selected="selected"<?php endif; ?>><?php echo $vo['agent_name']; ?></option>
                                <?php endforeach; endif; else: echo "" ;endif; ?>
                            </select>
                        </div>
                    </div>
					<div class="layui-form-item">
                        <label class="layui-form-label">上级</label>
                        <div class="layui-input-block">
							<select name="pid" lay-search>
								<option value="0"><?php echo $user_list['names']; ?></option>
					
                            </select>
                        </div>
                    </div>
                    
                     <div class="layui-form-item">
                        <label class="layui-form-label">上级ID</label>
                        <div class="layui-input-block">
                            <input type="text" name="pid" value="<?php echo $user['pid']; ?>" required lay-verify="required|pid|number" placeholder="请输入上级ID" class="layui-input">
                        </div>
                    </div>
					
                    <div class="layui-form-item">
                        <label class="layui-form-label">状态</label>
                        <div class="layui-input-block">
                            <input type="radio" name="status" value="1" title="启用" <?php if($user['status']==1): ?> checked="checked"<?php endif; ?>>
                            <input type="radio" name="status" value="0" title="禁用" <?php if($user['status']==0): ?> checked="checked"<?php endif; ?>>
                        </div>
                    </div>
             
                  
                  <div class="layui-form-item">
                        <label class="layui-form-label">余额</label>
                        <div class="layui-input-block">
                            <input type="text" name="money" value="<?php echo $user['money']; ?>"  placeholder="请输入余额" class="layui-input">
                        </div>
                    </div>
					
					<div class="layui-form-item">
                        <label class="layui-form-label">备注</label>
                        <div class="layui-input-block">
                            <input type="text" name="note" value="<?php echo $user['note']; ?>" class="layui-input">
                        </div>
                    </div>
                    <div class="layui-form-item">
                        <div class="layui-input-block">
                             <input type="hidden" name="id" value="<?php echo $user['id']; ?>">
							<button class="layui-btn" lay-submit lay-filter="*">更新</button>
                            <button type="reset" class="layui-btn layui-btn-primary">重置</button>
                        </div>
                    </div>
                </form>
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

<script type="text/javascript">
	form.on('select(province)', function(data){
	   $.post("<?php echo url('admin/user/ajax_city'); ?>",{cid:data.value},function(result){
			$("#city").html("");
			$("#city").html(result);
			form.render('select');
	   },"html");  
	});
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