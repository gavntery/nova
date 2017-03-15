<?php
/**
 * Created by PhpStorm.
 * User: terry
 * Date: 14/3/17
 * Time: PM9:50
 */
namespace Nova\Application\Controllers;
use Nova\Application\Models;
use Nova\Application\Helper;

class index
{
    public function main()
    {
        $mIndex = new Models\index();

        $user = $mIndex->getAllUser();

        Helper\SysLog::log($user, __METHOD__, 'log', 'main');

        print_r($user);
    }
}