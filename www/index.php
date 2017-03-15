<?php
/**
 * Created by PhpStorm.
 * User: terry
 * Date: 14/3/17
 * Time: PM2:24
 */

define('ROOT_DIR', __DIR__.'/..');

define('APP_DIR', ROOT_DIR.'/Application');

define('CONFIG_DIR', ROOT_DIR.'/config');

define('FRAMEWORK_DIR', ROOT_DIR.'/Framework');

define('LOG_DIR', ROOT_DIR.'/logs');

define('WWW_DIR', __DIR__.'/');

define('DEBUG_MODE', true);

define('HOST_URL', 'http://localhost/nova');

require FRAMEWORK_DIR.'/init.php';