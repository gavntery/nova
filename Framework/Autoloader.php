<?php
/**
 * Created by PhpStorm.
 * User: terry
 * Date: 14/3/17
 * Time: PM8:51
 */

namespace Nova\Framework;


class Autoloader
{
    public static $loader;

    /**
     * Autoloader 构造函数
     */
    private function __construct()
    {
        //将$this->import()注册到sql_autoload，作为本项目中类的自动加载方法
        spl_autoload_register(array(
            $this,
            'import'
        ));
    }

    /**
     * Autoloader的入口函数
     * 用于创建Autoloader的唯一实例化对象
     *
     * @return Autoloader
     */
    public static function init()
    {
        if (self::$loader == NULL)
            self::$loader = new self();

        return self::$loader;
    }

    /**
     * 类的自动加载方法
     * 根据传入参数$className，自动引入相应类的源文件
     *
     * @param string $className
     */
    public function import($className)
    {
        $path = explode('\\', substr($className, strlen('Nova')));
        $filePath = ROOT_DIR . DIRECTORY_SEPARATOR . implode(DIRECTORY_SEPARATOR, $path) . '.php';
        if (is_file($filePath)) {
            require $filePath;
        }
    }
}