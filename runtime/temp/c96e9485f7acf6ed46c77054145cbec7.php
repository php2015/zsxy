<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:35:"./themes/default/index/onenote.html";i:1571815557;}*/ ?>
<!doctype html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>操作说明</title>
        <meta name="viewport" content="width=device-width, initial-scale=1,maximum-scale=1,user-scalable=no">
        <meta name="apple-mobile-web-app-capable" content="yes">
        <meta name="apple-mobile-web-app-status-bar-style" content="black">
        <link href="__PUBLIC__/css/mui.min.css" rel="stylesheet" />
		<style>
			.cont_img img{
				width:100%;
				float:left;
			}
		</style>
    </head>
    <body>
      	<header class="mui-bar mui-bar-nav"  style="background-color:#ac5cff;">
            <a class="mui-icon mui-icon-left-nav mui-pull-left" href="<?php echo url('index/index/index'); ?>" style="color: #fff;"></a>
            <h1 class="mui-title" style="color: #fff;">操作说明</h1>
    </header>
      

        <div class="mui-content" style="background:#fff;">
        <div style="text-align: center;padding-top:20px;">
            <h class="detail-title" style="box-sizing: border-box; font-size: 24px; text-align: center;white-space: normal;"><?php echo $note['title']; ?></h>
        </div>
        <div class="cont_img"><?php echo $note['content']; ?></div>
      </div>
        
    <body>
        
    </body>

</html>