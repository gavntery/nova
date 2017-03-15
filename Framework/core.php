<?php
/**
 * Created by PhpStorm.
 * User: terry
 * Date: 14/3/17
 * Time: PM4:51
 */
namespace Nova\Framework;

class Core
{
    public function run()
    {
        $this->setReporting();
        $this->route();
    }

    public function setReporting()
    {
        if (DEBUG_MODE === true) {
            error_reporting(E_ALL);
            ini_set('display_errors', 'On');
        } else {
            error_reporting(E_ALL);
            ini_set('display_errors', 'Off');
            ini_set('log_errors', 'On');
            ini_set('error_log', LOG_DIR . 'error.log');
        }
    }

    public function route()
    {
        if (!isset($_REQUEST['act'])) {
            $_REQUEST['act'] = 'index';
        }
        if (!isset($_REQUEST['st'])) {
            $_REQUEST['st'] = 'main';
        }
        $className = 'Nova\\Application\\Controllers\\' . $_REQUEST['act'];
        if (!class_exists($className)) {
            header('HTTP/1.1 404 Not Found');
            die($className);
        }

        $obj = new $className();

        if (!method_exists($obj, $_REQUEST['st'])) {
            header('HTTP/1.1 404 Not Found');
            exit;
        }
        $obj->$_REQUEST['st']();
    }
}