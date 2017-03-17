<?php
/**
 * Created by PhpStorm.
 * User: terry
 * Date: 17/3/17
 * Time: PM3:06
 */

namespace Nova\Framework;

class Session
{
    private static $sessionId, $redisCache, $userIp;

    public function __construct()
    {
    }

    public static function start()
    {
        session_set_save_handler(
            array(__CLASS__, "open"),
            array(__CLASS__, "close"),
            array(__CLASS__, "read"),
            array(__CLASS__, "write"),
            array(__CLASS__, "destory"),
            array(__CLASS__, "gc")
        );
        session_start();
    }

    public static function open()
    {
        self::get_sid();
        self::$redisCache = Redis::get_instance();
        return true;
    }

    public static function read()
    {
        $sessionValue = self::$redisCache->get(self::$sessionId, SESSION_TABLE_NAME);
        if ($sessionValue) {
            $_SESSION = $sessionValue;
        }
        return true;
    }

    public static function write()
    {
        if (!empty($_SESSION)) {
            self::$redisCache->set(self::$sessionId, $_SESSION, SESSION_TABLE_NAME, SESSION_TIMEOUT);
        }
        return true;
    }

    public static function destory()
    {
        if (self::$redisCache->exists(self::$sessionId, SESSION_TABLE_NAME)) {
            self::$redisCache->delete(self::$sessionId, SESSION_TABLE_NAME);
        }
        setcookie(SESSION_NAME, self::$sessionId, 1, COOKIE_PATH, COOKIE_DOMAIN, FALSE);
        return true;
    }

    public static function close()
    {
        return true;
    }

    public static function gc()
    {
        return true;
    }

    public static function get_sid()
    {
        self::$userIp = Tools::real_ip();
        $arr = $_COOKIE;
        if (is_null(self::$sessionId) && empty($arr[SESSION_NAME])) {
            self::$sessionId = function_exists('com_create_guid') ?
                md5(self::$userIp . com_create_guid()) : md5(self::$userIp . uniqid(mt_rand(), true));
            self::$sessionId .= sprintf('%08x', crc32(self::$sessionId));
            setcookie(SESSION_NAME, self::$sessionId, time() + SESSION_TIMEOUT, COOKIE_PATH, COOKIE_DOMAIN, FALSE);
            $_COOKIE[SESSION_NAME] = self::$sessionId;
        } else {
            self::$sessionId = $arr[SESSION_NAME];
        }
        return self::$sessionId;
    }

}