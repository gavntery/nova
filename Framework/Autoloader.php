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

    private function __construct()
    {
        spl_autoload_register(array(
            $this,
            'import'
        ));
    }

    public static function init()
    {
        if (self::$loader == NULL)
            self::$loader = new self();

        return self::$loader;
    }

    public function import($className)
    {
        $path = explode('\\', substr($className, strlen('Nova')));
        $filePath = ROOT_DIR . DIRECTORY_SEPARATOR . implode(DIRECTORY_SEPARATOR, $path) . '.php';
        if (is_file($filePath)) {
            require $filePath;
        }
    }
}