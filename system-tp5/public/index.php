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

// 定义应用目录
define('APP_PATH', __DIR__ . '/../application/');
header('Access-Control-Allow-Origin:*');     
header('Access-Control-Allow-Methods:*');  
header('Access-Control-Allow-Headers:*');
header('Access-Control-Allow-Credentials:false');
//如果请求方式是options，就退出
if(strtoupper($_SERVER['REQUEST_METHOD'])== 'OPTIONS'){ 
    exit; 
}
// 加载框架引导文件
require __DIR__ . '/../thinkphp/start.php';
