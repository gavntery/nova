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

    /**
     * 设定整站的错误报告等级
     */
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

    /**
     * 路由规则
     *
     * 使用$_REQUEST['act']来定位控制器的类
     * 使用$_REQUEST['st']来定位具体的方法
     */
    public function route()
    {
        //如果$_REQUEST中没有'act'，则设定默认act为index
        if (!isset($_REQUEST['act'])) {
            $_REQUEST['act'] = 'index';
        }

        //如果$_REQUEST中没有'st'，则设定默认act为main
        if (!isset($_REQUEST['st'])) {
            $_REQUEST['st'] = 'main';
        }
        //根据act定位控制器类
        $className = 'Nova\\Application\\Controllers\\' . $_REQUEST['act'];
        //判断控制器类是否存在，不存在则报404
        if (!class_exists($className)) {
            header('HTTP/1.1 404 Not Found');
            die($className);
        }

        //生成目标控制器类对象
        $obj = new $className();

        //判断方法是否存在，不存在则报404
        if (!method_exists($obj, $_REQUEST['st'])) {
            header('HTTP/1.1 404 Not Found');
            exit;
        }
        //执行目标方法
        $obj->$_REQUEST['st']();
    }
}