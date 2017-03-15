<?php
/**
 * Created by PhpStorm.
 * User: terry
 * Date: 15/3/17
 * Time: PM5:39
 */

namespace Nova\Application\Controllers;
require_once APP_DIR . '/Library/Smarty/Autoloader.php';


class base
{
    public function __construct()
    {
        Smarty_Autoloader::register();
    }
}