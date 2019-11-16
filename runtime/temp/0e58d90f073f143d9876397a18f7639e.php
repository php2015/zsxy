<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:38:"./themes/default/zfbpay/tiaozhuan.html";i:1571844436;}*/ ?>
<html>
<head>
    <meta http-equiv="content-type" content="text/html;charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1"/> 
    <title>支付宝支付</title>
	<script src="__PUBLIC__/js/jquery.min.js"></script>
	<link rel="stylesheet" href="__PUBLIC__/css/load.css"  media="all">
	<script src="__PUBLIC__/js/load-min.js" charset="utf-8"></script>
	<style>
		.mui-bar .mui-title {
			right: 0px;
			left: 0px;
			top: 0px;
			display: inline-block;
			overflow: hidden;
			width: auto;
			margin: 0;
			text-overflow: ellipsis;
			background-color: #f7572d;
		}
		.mui-title {
			font-size: 17px;
			font-weight: 500;
			line-height: 44px;
			position: absolute;
			display: block;
			width: 100%;
			margin: 0 -10px;
			padding: 0;
			text-align: center;
			white-space: nowrap;
			color: #000;
		}
		.mui-content {
			background-color: #efeff4;
		}
		#pullrefresh{
			height: 100%;
		}
	</style>
    <script type="text/javascript">
   $(document).ready(function(){
	 $.mask_element('#pullrefresh', 3000);
	 setTimeout(function(){
		window.location.href="<?php echo url('index/chaxun/view'); ?>?dingdanid=<?php echo $dingdanid; ?>";
	 },3000)
     });
	</script>
</head>
<body>
      <header class="mui-bar mui-bar-nav" style="background-color:#ac5cff;">
            <a class="mui-action-back mui-icon mui-icon-left-nav mui-pull-left" style="color: #fff;"></a>
            <h1 class="mui-title" style="color: #fff;">大数据报告</h1>
    </header>
	<div id="pullrefresh" class="mui-content mui-scroll-wrapper" style="margin-top:45px;padding-top: 0px;margin-right: -8px;margin-left: -8px;">
		
	</div>
</body>
</html>