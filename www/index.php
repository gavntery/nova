<?php
/**
 * Created by PhpStorm.
 * User: terry
 * Date: 14/3/17
 * Time: PM2:24
 */

//给目录定义一些常量
define('ROOT_DIR', __DIR__.'/..');
define('APP_DIR', ROOT_DIR.'/Application');
define('CONFIG_DIR', ROOT_DIR.'/config');
define('FRAMEWORK_DIR', ROOT_DIR.'/Framework');
define('LOG_DIR', ROOT_DIR.'/logs');
define('WWW_DIR', __DIR__.'/');

//设置整站的默认时区
define('TIMEZONE', 'Asia/Shanghai');
ini_set('data.timezone', TIMEZONE);

//引入初始化程序
require FRAMEWORK_DIR.'/init.php';