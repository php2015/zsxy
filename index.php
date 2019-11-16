<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

// [ 应用入口文件 ]

//echo '<meta http-equiv="Content-Type" content="text/html; charset=utf-8" /><p style="font-size:100px;text-align: center;margin-top:500px;">尊敬的用户您好，国庆节期间，系统升级维护，我们将尽快恢复运行，敬请期待！</p>';die; 
// 定义应用目录


define('APP_PATH', __DIR__ . '/application/');
// 加载框架引导文件
require __DIR__ . '/thinkphp/start.php';
