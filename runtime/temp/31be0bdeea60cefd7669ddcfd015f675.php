<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:37:"./themes/default/price/pricelist.html";i:1573133719;}*/ ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>版本信息</title>
    <link rel="stylesheet" href="__PUBLIC__/css/iconfont.css">
    <link rel="stylesheet" href="__PUBLIC__/css/style.css">
    <link rel="stylesheet" href="__PUBLIC__/css/index.css?v=123456">
    <link rel="stylesheet" href="__PUBLIC__/css/edition.css">
    <script src="__PUBLIC__/js/jquery.min.js"></script>
    <script src="__PUBLIC__/js/mui.min.js"></script>
     <script type="text/javascript" src="__PUBLICS__/layer/layer.js" ></script>
</head>
<body>
<style>

</style>
<div class="container">
    <img class="banner" src="<?php echo $sy['thumb']; ?>" alt="">
    <div class="clearfix"></div>
    <div class="tab_box clearfix">
        <div class="tab_item">
            <a href="<?php echo url('index/index/home'); ?>">
                <img src="__PUBLIC__/img/set.png" alt="">
                <p>推广挣钱</p>
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

    <?php if(isset($goods) && !empty($goods)): $data = ['资信报告'=>70,'消费评估'=>80,'用户画像'=>80]; $class = ['资信报告'=>'','消费评估'=>'','用户画像'=>'','信用额度预估'=>'','以上4个版本一起推广'=>'']; $url = ['资信报告'=>
    '/index/chaxun/yangshi3','消费评估'=>'/index/chaxun/yangshi1','用户画像'=>'/index/chaxun/yangshi2','用户画像1'=>'javascript:void(0);','以上4个版本一起推广'=>'javascript:void(0);'];
    if(is_array($goods) || $goods instanceof \think\Collection || $goods instanceof \think\Paginator): $i = 0; $__LIST__ = $goods;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
    <div class="edition clearfix">
        <img class="edition_pic" src="__PUBLIC__/img/edition_g.png" alt="">
        <div class="edi_cen">
            <p class="edi_p1"><?php echo $vo['tname']; ?></p>
            <p class="edi_p2">
                最高获得<?php $num = isset($data[$vo['tname']]) && !empty($data[$vo['tname']]) ? $data[$vo['tname']] : 0 ; echo $num - $vo['price']; ?>
                佣金</p>
        </div>
        <div class="edi_right"
             style="<?php echo isset($class[$vo['tname']]) && !empty($class[$vo['tname']]) ? $class[$vo['tname']] : ''; ?>">
            <a href="<?php echo url('index/price/priceadd',array('priceid'=>$vo['id'])); ?>" class="edi_btn">推广赚钱</a>
            <a href="<?php  echo $url[$vo['tname']]; ?>" class="edi_btn" >示例报告</a>
        </div>
        <img class="edi_hot" src="__PUBLIC__/img/hot.png" alt="">
    </div>
    <?php endforeach; endif; else: echo "" ;endif; endif; ?>
</div>
</body>
<script>
    $(function () {
        $(".tabbar").click(function () {
            $(this).addClass("active").siblings().removeClass("active")
        })
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