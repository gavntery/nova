<?php
/**
 * Created by PhpStorm.
 * User: terry
 * Date: 14/3/17
 * Time: PM9:50
 */
namespace Nova\Application\Controllers;
use Nova\Application\Models;
use Nova\Framework\Syslog;

class index extends base
{
    public function main()
    {
        $mIndex = new Models\index();

        $user = $mIndex->getAllUser();

        $this->smarty->assign('users', $user);

        $this->smarty->display('index.tpl');
    }
}