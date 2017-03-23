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
        //注册Session的各种处理函数
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

    /**
     * session_start时会调用该函数
     *
     * @return bool
     */
    public static function open()
    {
        //生成或获取一个session id
        self::get_sid();
        //获取用于存储Session的Redis对象实例
        self::$redisCache = Redis::get_instance();
        return true;
    }

    /**
     * 使用SessionId作为key，从Redis中读取相应数据，并将数据写入Session变量
     *
     * @return bool
     */
    public static function read()
    {
        $sessionValue = self::$redisCache->get(self::$sessionId, SESSION_TABLE_NAME);
        if ($sessionValue) {
            $_SESSION = $sessionValue;
        }
        return true;
    }

    /**
     * 将Session变量的内容写入Redis中
     *
     * @return bool
     */
    public static function write()
    {
        if (!empty($_SESSION)) {
            self::$redisCache->set(self::$sessionId, $_SESSION, SESSION_TABLE_NAME, SESSION_TIMEOUT);
        }
        return true;
    }

    /**
     * 通过删除Redis中SessionId对应的数据来注销Session
     * session_destory()是自动调用
     *
     * @return bool
     */
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

    /**
     * 返回一个SessionId
     * 若Cookie中已存在SessionId，则直接返回该SessionId
     * 若不存在，则按照规则新生成一个SessionId
     *
     * @return string Session Id
     */
    public static function get_sid()
    {
        self::$userIp = Tools::real_ip();
        $arr = $_COOKIE;
        //判断Cookie中是否已经存在SessionId
        if (is_null(self::$sessionId) && empty($arr[SESSION_NAME])) {
            //使用MD5对用户IP+随机字符串加密后作为新的SessionId
            self::$sessionId = function_exists('com_create_guid') ?
                md5(self::$userIp . com_create_guid()) : md5(self::$userIp . uniqid(mt_rand(), true));
            //对新的SessionId再做一次crc32运算，作为最终的SessionId
            self::$sessionId .= sprintf('%08x', crc32(self::$sessionId));
            //将SessionId写入Cookie中
            setcookie(SESSION_NAME, self::$sessionId, time() + SESSION_TIMEOUT, COOKIE_PATH, COOKIE_DOMAIN, FALSE);
            $_COOKIE[SESSION_NAME] = self::$sessionId;
        } else {
            self::$sessionId = $arr[SESSION_NAME];
        }
        //返回SessionId
        return self::$sessionId;
    }

}