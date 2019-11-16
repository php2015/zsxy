<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:32:"./themes/calculator/pay/pay.html";i:1571815575;}*/ ?>
<html>
<head>
    <meta http-equiv="content-type" content="text/html;charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1"/> 
    <title>微信支付</title>
	<script src="__PUBLIC__/js/jquery.min.js"></script>
    <script type="text/javascript">
     $().ready(function(){ 
      	callpay();
     });
	//调用微信JS api 支付
	function jsApiCall()
	{
		WeixinJSBridge.invoke(
			'getBrandWCPayRequest',
			<?php echo $result; ?>,
			function(res){
				WeixinJSBridge.log(res.err_msg);
			}
		);
	}

	function callpay()
	{
		if (typeof WeixinJSBridge == "undefined"){
		    if( document.addEventListener ){
		        document.addEventListener('WeixinJSBridgeReady', jsApiCall, false);
		    }else if (document.attachEvent){
		        document.attachEvent('WeixinJSBridgeReady', jsApiCall); 
		        document.attachEvent('onWeixinJSBridgeReady', jsApiCall);
		    }
		}else{
		    jsApiCall();
		}
	}
	function query(){
		var order_no="<?php echo $order_no; ?>";
		$.post("/calculator/pay/order_query", { order_no: order_no }, function(data) {
		  if (data!=0){
            window.location.href="<?php echo url('calculator/pay/problem'); ?>?cid="+data;
			//跳转至结果页
		  }
		});
	}
    $(document).ready(function(){
        setInterval(query, 1000);
    });
	</script>
</head>
<body>
</body>
</html>