<?php
/**
 * Created by PhpStorm.
 * User: terry
 * Date: 14/3/17
 * Time: PM4:52
 */

require 'dbconfig.php';

define('DEBUG_MODE', true);

define('HOST_URL', 'http://localhost/nova');

define('REDIS_ROOT', 'nova:');

define('SESSION_TIMEOUT', 86400);

define('SESSION_TABLE_NAME', 'SESSION:');

define('SESSION_NAME', 'NOVASID');

define('COOKIE_PATH', '/');

define('COOKIE_DOMAIN', '');