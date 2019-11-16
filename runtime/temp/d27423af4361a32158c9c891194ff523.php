<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:38:"./themes/dailishang/product/index.html";i:1573029106;s:29:"./themes/dailishang/base.html";i:1572661643;}*/ ?>
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
            <li class="layui-this">版本管理</li>
           <!-- <li class=""><a href="<?php echo url('admin/product/add'); ?>">添加版本</a></li>-->
        </ul>
        <div class="layui-tab-content">
            <div class="layui-tab-item layui-show">

                <form class="layui-form layui-form-pane" action="<?php echo url('dailishang/product/add'); ?>" method="get">
                   <div class="layui-inline">
				<?php if(is_array($goods_list) || $goods_list instanceof \think\Collection || $goods_list instanceof \think\Paginator): if( count($goods_list)==0 ) : echo "" ;else: foreach($goods_list as $key=>$vo): ?>您当前<?php echo $vo['tname']; ?>成本价为：<?php echo $vo['price']; ?>元</br><?php endforeach; endif; else: echo "" ;endif; ?>
                  </div>
                   <?php if($isok == '1'): ?>
                    <div class="layui-inline">
                        
                        <button class="layui-btn">添加版本</button>
					</div>
					<?php endif; ?>
                </form>
                <hr>

                <table class="layui-table">
                    <thead>
                    <tr>
                        <th style="width: 30px;">ID</th>
                       
						<th>版本</th>
                        <th>自定义价格</th>
                        <th>背景图片</th>
                        <th>时间</th>
                        <th>推广链接</th>
                      	<th>操作</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php if(is_array($product_list) || $product_list instanceof \think\Collection || $product_list instanceof \think\Paginator): if( count($product_list)==0 ) : echo "" ;else: foreach($product_list as $key=>$vo): ?>
                    <tr>
                        <td><?php echo $vo['id']; ?></td>
                       
                        <td><?php echo $vo['product_name']; ?></td>
                        <td><?php echo $vo['price']; ?></td>
                       <td><center><img style="height:80px; width:50px;" src="<?php echo $vo['thumbs']; ?>"/></center></td>
						<td><?php echo date("Y-m-d H:i:s",$vo['createtime']); ?></td>
						<td>
                      		<?php switch($vo['a_g_id']): case "7": ?>http://www.xalanfeng.cn/index.php/index/chaxun/query5/price/<?php echo $vo['price']; ?>/pid/<?php echo $vo['id']; break; case "4": ?>http://www.xalanfeng.cn/index.php/index/chaxun/query1/price/<?php echo $vo['price']; ?>/pid/<?php echo $vo['id']; break; case "5": ?>http://www.xalanfeng.cn/index.php/index/chaxun/query2/price/<?php echo $vo['price']; ?>/pid/<?php echo $vo['id']; break; default: ?>
                            		http://www.xalanfeng.cn/index/chaxun/query/price/<?php echo $vo['price']; ?>/pid/<?php echo $vo['id']; endswitch; ?>
                      </td>
						
						
                        <td style="width:100px">
                            <a href="
                            <?php switch($vo['a_g_id']): case "7": ?>/index.php/index/chaxun/query5/price/<?php echo $vo['price']; ?>/pid/<?php echo $vo['id']; break; case "4": ?>/index.php/index/chaxun/query1/price/<?php echo $vo['price']; ?>/pid/<?php echo $vo['id']; break; case "5": ?>/index.php/index/chaxun/query2/price/<?php echo $vo['price']; ?>/pid/<?php echo $vo['id']; break; default: ?>
                                    	/index/chaxun/query/price/<?php echo $vo['price']; ?>/pid/<?php echo $vo['id']; endswitch; ?>
                                     " target="_blank" class="layui-btn layui-btn-normal layui-btn-mini">查看</a>
                            <a href="<?php echo url('/dailishang/product/delete',['id'=>$vo['id']]); ?>" class="layui-btn layui-btn-danger layui-btn-mini ajax-delete">删除</a>
                        </td>
                    </tr>
                    <?php endforeach; endif; else: echo "" ;endif; ?>
                    </tbody>
                </table>
				
                <!--分页-->
                <?php echo $product_list->render(); ?>
              
            
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

</body>
</html>