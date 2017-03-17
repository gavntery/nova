<?php
/**
 * Created by PhpStorm.
 * User: terry
 * Date: 14/3/17
 * Time: PM4:52
 */
namespace Nova\Framework;

require CONFIG_DIR . '/config.php';

require 'Autoloader.php';

Autoloader::init();

Session::start();

$core = new Core;

$core->run();