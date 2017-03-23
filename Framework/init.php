<?php
/**
 * Created by PhpStorm.
 * User: terry
 * Date: 14/3/17
 * Time: PM4:52
 */
namespace Nova\Framework;

//引入配置文件
require CONFIG_DIR . '/config.php';
//引入自动加载类
require 'Autoloader.php';

//初始化自动加载
Autoloader::init();
//启用Session
Session::start();

//启动核心处理程序
$core = new Core;
$core->run();