<?php
/**
 * Created by PhpStorm.
 * User: terry
 * Date: 15/3/17
 * Time: PM4:33
 */

namespace Nova\Application\Helper;


class Tools
{
    public static function date_with_microtime()
    {
        list($usec, $sec) = explode(' ', microtime());
        return date('Y-m-d H:i:s') . ltrim($usec, '0');
    }
}