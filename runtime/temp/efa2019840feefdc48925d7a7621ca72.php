<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:36:"./themes/default/price/priceadd.html";i:1572697359;}*/ ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>设置版本</title>
    <link rel="stylesheet" href="__PUBLIC__/css/style.css">
    <link rel="stylesheet" href="__PUBLIC__/css/setver.css?v="1234">
    <script src="__PUBLIC__/js/jquery.min.js"></script>
    <script src="__PUBLIC__/js/mui.min.js"></script>
    <script type="text/javascript" src="__PUBLICS__/layer/layer.js" ></script>
</head>
<body>
<?php
	$product = '';
	if($goods['id'] == 2){
		$product = '6.8~80 元';
	}else if($goods['id'] == 3){
		$product = '8.8~70 元';
	}else if($goods['id'] == 4){
		$product = '5~80 元';
	}else if($goods['id'] == 5){
		$product = '5~80 元';
	}else if($goods['id'] == 7){
		$product = '3.88~25 元';
	}
?>
<div class="container">
    <div class="set_top">
        <p class="version_ti"><?php if($agent['isoem_title'] == 0): ?><?php echo $goods['tname']; endif; ?>报告</p>
        <ul>
            <li>名称<span>
                <?php if($agent['isoem_title'] == 0): ?>
                    <input name="productname"  disabled="disabled" value="<?php echo $goods['tname']; ?>" id="productname" type="text" style="border:none;text-align: right;">
                <?php else: ?>
                    <input name="productname"  value="<?php echo $goods['tname']; ?>" id="productname" type="text" placeholder="自定义版本名称" style="border:none;text-align: right;">
                <?php endif; ?>
            </span></li>
            <li>成本价格<span>
                <?php if($agent['isoem_price'] == 0): if($agentgoods['price'] == ''): ?>
							<?php echo $goods['price']; else: ?>
							<?php echo $agentgoods['price']; endif; else: if($agentgoods['price'] == ''): ?>
						    <?php echo $goods['price']; else: ?>
						    <?php echo $agentgoods['price']; endif; endif; ?>
            </span></li>
            <li>推广价格
                <?php if($agent['isoem_price'] == 0): if($agentgoods['price'] == ''): ?>
                        <input id="price" name="price"  value="<?php echo $goods['price']; ?>" type="text" style="border:none;text-align: right;">
                    <?php else: ?>
                        <input id="price" name="price" value="<?php echo $agentgoods['price']; ?>" type="text" style="border:none;text-align: right;">
                    <?php endif; else: if($agentgoods['price'] == ''): ?>
                        <input id="price" name="price" value="" placeholder="建议售价：<?php echo $product; ?>" type="text" style="border:none;text-align: right;">
                    <?php else: ?>
                        <input id="price" name="price" value="" placeholder="建议售价：<?php echo $product; ?>" type="text" style="border:none;text-align: right;">
                    <?php endif; endif; ?>
            </li>
           
        </ul>
    </div>
    <div class="explain">
        <p class="explain_ti">商品说明</p>
        <p class="explain_txt">网贷黑名单检测、信贷逾期金额、风险命中信息、运营商报告等等。</p>
        <p class="explain_ti">推广说明</p>
        <p class="explain_txt">在系统规定的范围内，设定好需要推广价格，点击保存。选择设定好的版本，使用二维码或者链接推广。发送给用户，用户看到的就是您预设的推广价格，用户付费后，佣金一秒到账。用户报告可在我的订单中直接查看</p>
        <p class="explain_ti">返佣说明</p>
        <p class="explain_txt">自主定价模式，平台只收取成本价，会员自行设定售价，超出成本价部分全部是会员的佣金，邀请用户查询支付成功后，立即获得佣金，直接结算至后台余额中。</p>
        <p class="explain_comm" style="display:none;">本人直推返佣</p>
        <div class="table_box" style="display:none;">
            <table border="0" cellspacing="0" cellpadding="0">
                <tr>
                    <td>初级代理</td>
                    <td>中级代理</td>
                    <td>高级代理</td>
                </tr>
                <tr>
                    <td>57.2</td>
                    <td>59.2</td>
                    <td>61.2</td>
                </tr>
            </table>
        </div>
        <p class="explain_comm" style="display:none;">团队直推返佣</p>
        <div class="table_box table_box1" style="display:none;">
            <table border="0" cellspacing="0" cellpadding="0">
                <tr>
                    <td>初级代理</td>
                    <td>中级代理</td>
                    <td>高级代理</td>
                </tr>
                <tr>
                    <td>0.5</td>
                    <td>1.0</td>
                    <td>2.0</td>
                </tr>
            </table>
        </div>
    </div>
    <input id="goodid" name="goodid" value="<?php echo $goodid; ?>" type="hidden">
    <div class="save_btn">
        <a href="javascript:baocun(<?php echo $bjurlone['id']; ?>)">
            <button>保存自定义版本</button>
        </a>
    </div>
</div>

<script type="text/javascript">
    mui.init({
        swipeBack:true //启用右滑关闭功能
    });
    function baocun(bid){
        var productname = $('#productname').val();
        var price = $('#price').val();
        var marks =$('#marks').val();
        var goodid =$('#goodid').val();
        //很多判断
        if(productname == ''){
            layer.msg('名称不能为空');
            return;
        }
        if(price == ''){
            layer.msg('价格不能为空');
            return;
        }
        if(goodid == ''){
            layer.msg('请返回选择版本');
            return;
        }
        $.ajax({
            url:'/index/price/add.html',
            type:"post",
            datatype:'json',
            data:{'productname':productname,'price':price,'marks':marks,'goodid':goodid,'bid':bid},
            success:function(data){
                if(data == 1){
                    layer.msg("自定义版本成功！");
                    window.location.href="/index/index/home.html";
                }else if(data== 0){
                    layer.msg("自定义版本错误！");
                    return false;
                }else if(data== 2){
                    layer.msg("价格不能低于成本价格！");
                    return false;
                }else if(data== 5){
                    layer.msg("你没有权限自定义版本！");
                    return false;
                }else if(data== 25){
                    layer.msg("价格不能超过25元！");
                    return false;
                }else if(data== 50){
                    layer.msg("价格不能超过50元！");
                    return false;
                }else if(data== 99){
                    layer.msg("价格不能超过70元！");
                    return false;
                }else if(data== 18){
                    layer.msg("价格不能低于18.8元！");
                    return false;
                }else if(data== 28){
                    layer.msg("价格不能低于28.8元！");
                    return false;
                }
            }
        });
    }
</script>

</body>
</html>