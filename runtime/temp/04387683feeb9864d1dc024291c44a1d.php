<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:30:"./themes/default/pay/hpay.html";i:1572332835;}*/ ?>
<html>
<head>
    <meta http-equiv="content-type" content="text/html;charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1"/> 
    <title>订单支付</title>
	<script src="__PUBLIC__/js/jquery.min.js"></script>
	<link href="__PUBLIC__/css/mui.min.css" rel="stylesheet" />

</head>
<body>
<div class="mui-content">
			<div class="mui-card" style="position: relative;top:0px;">
				<div class="mui-card-content">
					<form name="payform" action="<?php echo url('index/zfbpay/pay'); ?>" method="post" target="_blank" style="display:none;" id="czpay">
						<input type="hidden" name="price" value="<?php echo $_GET['price']; ?>">
						<input type="hidden" name="pid" value="<?php echo $_GET['pid']; ?>">
						<input type="hidden" name="uid" value="<?php echo $_GET['uid']; ?>">
					</form>
					
					<div class="mui-card-content-inner">
						<div style="font-size: 20px;padding-bottom: 16px;padding-left: 0px;">
								<p>大数据分析优化服务费<?php echo $_GET['price']+$_GET['price']; ?>元</p>
								<p style="width:100%;font-size: 14px;color: red; line-height: 30px; border-bottom: 1px solid #ebebeb;"><font color="red" style="font-size: 16px;text-align: center;"><b>限时特价优惠<span style="font-size: 24px;"><?php echo $price; ?></span>元</b></font></p>
						</div>
						<div style="font-size: 20px;padding-bottom: 16px;color: #333333;padding-left: 0px;">
							
								<p style="width:100%;font-size: 14px;color: #333333; line-height: 30px;">请选择支付方式</p>
								<p style="line-height: 40px;">
								</p>
								<p style="line-height: 40px;clear: both;">
									<img src="__PUBLIC__/img/zfb.jpg"  style="width: 40px;float: left;"/><span style="padding-left: 15px;color: #000;;">支付宝</span><input   type="radio"   value="zfb"    name="zhifu" checked="checked" style="float: right;margin-top: 10px;"/>
								</p>
						</div>
						<div align="center">
                          
                     
					   <button id="ljzf" style="width:210px; height:40px; border-radius: 15px;background-color:#FE6714; border:0px #FE6714 solid; cursor: pointer;  color:white;  font-size:16px;margin-top: 30px;" >立即支付</button>
                       
						</div>
						
						<script>
							$('#ljzf').click(function(){
								var val = $('input[name="zhifu"]:checked').val(); 
                              	var browser = navigator.userAgent.toLowerCase();
								if(val == 'wx' && browser.match(/Alipay/i)=="alipay"){
									alert('当前为支付宝环境，请选择支付宝支付。');
								}else if(val == 'wx'){
                               			alert('当前为支付宝环境，请选择支付宝支付。');
                                }else{
                                  document.getElementsByTagName("title")[0].innerText = '支付宝支付';
								  document.getElementById("czpay").submit();
								}
							})
						</script>
						 <div style="padding: 15px 0px;margin-top: 20px;border-radius: 10px;color: #ccc;border: 1px solid #ebebeb;height: 270px;">
						 	<p style="color: #2e94da;font-size: 16px;text-align: center;padding: 5px 15px;font-family:courier;"> <b>分析优化服务内容</b></p>

						 	<div style="padding-left: 20px;line-height: 40px;width: 50%;float: left;text-align: center;">
										<p style="background: #2e94da;color: #fff;border-radius: 10px;font-size: 14px;"><b>综合评分指数</b></p>
										<p style="background: #2e94da;color: #fff;border-radius: 10px;font-size: 14px;"><b>信用卡预估额度</b></p>
										<p style="background: #2e94da;color: #fff;border-radius: 10px;font-size: 14px;"><b>网贷预估授信额度</b></p>
										<p style="background: #2e94da;color: #fff;border-radius: 10px;font-size: 14px;"><b>消除大数据污点</b></p>
							</div>
							<div style="padding-left: 20px;line-height: 40px;width: 50%;float: left;text-align: center;">
										<p style="background: #2e94da;color: #fff;border-radius: 10px;font-size: 14px;"><b>司法风险监测</b></p>
										<p style="background: #2e94da;color: #fff;border-radius: 10px;font-size: 14px;"><b>联系人风险</b></p>
										<p style="background: #2e94da;color: #fff;border-radius: 10px;font-size: 14px;"><b>多头申请</b></p>
										<p style="background: #2e94da;color: #fff;border-radius: 10px;font-size: 14px;"><b>申请技巧学习</b></p>
							</div>
						 </div>
					</div>
				</div>
			</div>
		</div>
   <br/>
        
          
</body>
</html>