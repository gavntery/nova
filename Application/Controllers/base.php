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
    public $smarty;

    public function __construct()
    {
        \Smarty_Autoloader::register();
        $this->smarty = new \Smarty();
        $this->smarty->setTemplateDir(APP_DIR.'/Views/');
        $this->smarty->setCompileDir(ROOT_DIR.'/compiled/');
        $this->smarty->setConfigDir(CONFIG_DIR.'/smarty/');
        $this->smarty->setCacheDir(ROOT_DIR.'/cache/');
    }
}