<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:30:"./themes/admin/note/index.html";i:1571815580;s:24:"./themes/admin/base.html";i:1571969829;}*/ ?>
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
    
<script src="http://libs.baidu.com/jquery/2.1.1/jquery.min.js"></script>
<script src="__JS__/layer.js"></script>
<div class="layui-body">
    <!--tab标签-->
    <div class="layui-tab layui-tab-brief">
        <ul class="layui-tab-title">
            <li class="layui-this">文章列表</li>
            <li class=""><a href="<?php echo url('admin/note/add'); ?>">添加文章</a></li>
        </ul>
        <div class="layui-tab-content">
            <div class="layui-tab-item layui-show">

                <form class="layui-form layui-form-pane" action="<?php echo url('admin/note/index'); ?>" method="get">
                    <div class="layui-inline">
                        <label class="layui-form-label">关键词</label>
                        <div class="layui-input-inline">
                            <input type="text" name="keyword" value="<?php echo $keyword; ?>" placeholder="请输入关键词" class="layui-input">
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
                        <th>ID</th>
                       <th>标题</th>
						 <th>简介</th>
						 <th>分类</th>
                       	<th>排序</th>
						<th>时间</th>
                        <th width="8%">操作</th>
                       
                    </tr>
                    </thead>
                    <tbody>
                    <?php if(is_array($note_list) || $note_list instanceof \think\Collection || $note_list instanceof \think\Paginator): if( count($note_list)==0 ) : echo "" ;else: foreach($note_list as $key=>$vo): ?>
                    <tr>
                        <td><?php echo $vo['id']; ?></td>
                     	<td><b><a style="color:#007aff" href="javascript:title(<?php echo $vo['id']; ?>)"><?php echo $vo['title']; ?></a></b></td>
						<td><?php echo $vo['jianjie']; ?></td>
						<td><?php echo $vo['tname']; ?></td>
                        <td><?php echo $vo['descc']; ?></td>
                        <td><?php echo date("Y-m-d H:i:s",$vo['lasttime']); ?></td>
                      
                      
                        <td style="text-align:center">
						
                            <a href="<?php echo url('admin/note/edit',['id'=>$vo['id']]); ?>" class="layui-btn layui-btn-normal layui-btn-mini">编辑</a>
                            <a href="<?php echo url('admin/note/delete',['id'=>$vo['id']]); ?>" class="layui-btn layui-btn-danger layui-btn-mini ajax-delete">删除</a>
                        </td>
                      
                       
                    </tr>
                    <?php endforeach; endif; else: echo "" ;endif; ?>
                    </tbody>
                </table>
                <div style="width: 820px;height: 100%;padding: 10px;display: inline-block;position: relative;background: #fff;overflow-y: scroll;">
                    <div id="lis" style="width:100px;text-align:center;padding-top:15px;font-size:30px;"></div>
                    <div id="marks">
                       
                    </div>
                </div>
               
                <!--分页-->
                <?php echo $note_list->render(); ?>
            </div>
        </div>
    </div>
</div>
 <script>
            var lis=document.getElementById("lis");
            var marks=document.getElementById("marks");
                            function title(id) { 
                              
                              $.ajax({
                                        url:'<?php echo url('admin/note/title'); ?>',
                                        type:"post",
                                        datatype:'json',
                                        data:{'id':id},
                                        
                                        success:function(data){
                                          layer.open({
                                                  type: 1,
                                                  title: false,
                                                  area: ['820px','1000px'], //宽高
                                                  closeBtn: 0,
                                                  shadeClose: true,
                                                  skin: 'yourclass',
                                                  content: '<div style="padding:50px;"><h2 class="detail-title" style="box-sizing: border-box; font-size: 24px; text-align: center; font-weight: 400; padding-right: 40px; white-space: normal;padding-bottom:20px;"></br>'+data.title+'</h2><div>'+data.content+'</div></div>'
                                                });
                                            }
                                });
                            }  
                        </script>


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