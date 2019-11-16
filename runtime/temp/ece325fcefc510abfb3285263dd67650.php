<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:32:"./themes/default/index/home.html";i:1573133787;}*/ ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>首页</title>
    <link rel="stylesheet" href="__PUBLIC__/css/iconfont.css">
    <link rel="stylesheet" href="__PUBLIC__/css/style.css">
    <link rel="stylesheet" href="__PUBLIC__/css/index.css?v=1234">
    <link rel="stylesheet" href="__PUBLIC__/css/edition.css?v=123456">
    <script src="__PUBLIC__/js/jquery.min.js"></script>
    <script src="__PUBLIC__/js/mui.min.js"></script>
    <script type="text/javascript" src="__PUBLICS__/layer/layer.js" ></script>
</head>
<body>
<style>
    .edi_btn {
        text-align: center;
        padding: 0px;
        width: 1.5rem;
        height: 0.5rem;
    }
</style>
<div class="container1">
    <img class="banner" src="<?php if(isset($sy['thumb']) && !empty($sy['thumb'])): ?><?php echo $sy['thumb']; endif; ?>" alt="">
    <div class="clearfix"></div>
    <div class="tab_box clearfix">
        <div class="tab_item">
            <a href="<?php echo url('index/price/pricelist'); ?>">
                <img src="__PUBLIC__/img/set.png" alt="">
                <p>设置版本</p>
            </a>
        </div>
        <div class="tab_item">
            <a href="<?php echo url('user/tuandui'); ?>">
                <img src="__PUBLIC__/img/team.png" alt="">
                <p>我的团队</p>
            </a>
        </div>
        <div class="tab_item">
            <a href="<?php echo url('index/user/chaxunjilu'); ?>">
                <img src="__PUBLIC__/img/order.png" alt="">
                <p>我的客户</p>
            </a>
        </div>
        <div class="tab_item daili">
                <img src="__PUBLIC__/img/agent.png" alt="">
                <p>我的代理</p>
        </div>
    </div>


    <?php if(isset($product) && !empty($product)): ?>
    <div class="container2">
        <?php if(is_array($product) || $product instanceof \think\Collection || $product instanceof \think\Paginator): $i = 0; $__LIST__ = $product;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
        <div class="edition_list">
            <p>名称：<span><?php echo $vo['rename']; ?></span></p>
            <p>成本价格：<span class="edi_money"><?php echo $vo['chengben']; ?></span></p>
            <p>推广价格：<span class="edi_money"><?php echo $vo['price']; ?></span></p>
            <p>获得佣金：<span class="edi_money"><?php echo $vo['yongjin']; ?></span></p>
            <div class="btn_box">
                <a href="<?php echo url('index/qrc/views',array('imgid'=>$vo['id'],'a_g_id'=>$vo['a_g_id'])); ?>" class="spread_ma"
                   style="text-align: center;">二维码推广</a>
                <a href="<?php echo url('index/index/tuiguang',array('imgid'=>$vo['id'],'a_g_id'=>$vo['a_g_id'])); ?>"
                   class="spread_link" style="text-align: center;">链接推广</a>
                <a href="javascript:shanchu(<?php echo $vo['id']; ?>,0)" class="delete" style="text-align: center;">删除</a>
            </div>
        </div>
        <?php endforeach; endif; else: echo "" ;endif; ?>
    </div>
    <?php else: if(isset($goods) && !empty($goods)): $data = ['资信报告'=>70,'消费评估'=>80,'用户画像'=>80]; $class = ['资信报告'=>'','消费评估'=>'','用户画像'=>'','信用额度预估'=>'','以上4个版本一起推广'=>'']; $url = ['资信报告'=>'/index/chaxun/yangshi3','消费评估'=>'/index/chaxun/yangshi1','用户画像'=>'/index/chaxun/yangshi2','信用额度预估'=>'/index/chaxun/yangshi5','以上4个版本一起推广'=>'/index/chaxun/yangshi3']; if(is_array($goods) || $goods instanceof \think\Collection || $goods instanceof \think\Paginator): $i = 0; $__LIST__ = $goods;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
                <div class="edition clearfix">
                <img class="edition_pic" src="__PUBLIC__/img/edition_g.png" alt="">
                <div class="edi_cen">
                    <p class="edi_p1"><?php echo $vo['tname']; ?></p>
                    <p class="edi_p2">最高获得<?php $num = isset($data[$vo['tname']]) && !empty($data[$vo['tname']]) ? $data[$vo['tname']] : 0 ; echo $num - $vo['price']; ?>佣金</p>
                </div>
                <div class="edi_right" style="<?php echo isset($class[$vo['tname']]) && !empty($class[$vo['tname']]) ? $class[$vo['tname']] : ''; ?>">
                    <a href="<?php echo url('index/price/priceadd',array('priceid'=>$vo['id'])); ?>" class="edi_btn" >推广赚钱</a>
                    <a href="<?php  echo $url[$vo['tname']]; ?>" class="edi_btn" >示例报告</a>
                </div>
                <img class="edi_hot" src="__PUBLIC__/img/hot.png" alt="">
                </div>
            <?php endforeach; endif; else: echo "" ;endif; endif; endif; ?>


    <div class="footer">
        <div class="tabbar active">
            <a href="<?php echo url('index/index/home'); ?>">
                <p><span class="iconfont icon-shouye"></span></p>
                <p>首页</p>
            </a>
        </div>
        <div class="tabbar zixun">
            <p><span class="iconfont icon-zixun-dianji"></span></p>
            <p>资讯广场</p>
        </div>
        <div class="tabbar">
            <a href="<?php echo url('index/index/mingxi'); ?>">
                <p><span class="iconfont icon-qianbao"></span></p>
                <p>收入明细</p>
            </a>
        </div>
        <div class="tabbar">
            <a href="<?php echo url('index/index/index'); ?>">
                <p><span class="iconfont icon-wode"></span></p>
                <p>个人中心</p>
            </a>
        </div>
    </div>
</div>
</body>
<script>
    $(function () {
        $(".tabbar").click(function () {
            $(this).addClass("active").siblings().removeClass("active")
        })
        
        
    });
    
    $('.zixun').on('click',function(){
    			layer.msg('暂未开放');
    	});
            
    $('.daili').on('click',function(){
       layer.msg('暂未开放');
    });

    function shanchu(pid, tid) {
        $.ajax({
            url: "<?php echo url('index/index/shanchu'); ?>",
            type: "post",
            datatype: 'json',
            data: {'pid': pid, 'tid': tid},
            success: function (data) {
                if (data == 1) {
                    mui.toast('删除成功');
                    window.location.href = "<?php echo url('index/index/home'); ?>";
                } else {
                    window.location.href = "<?php echo url('index/index/home'); ?>";
                }
            }
        });
    }
</script>
</html>