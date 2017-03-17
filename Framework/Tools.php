<?php
/**
 * Created by PhpStorm.
 * User: terry
 * Date: 15/3/17
 * Time: PM4:33
 */

namespace Nova\Framework;


class Tools
{
    public static function date_with_microtime()
    {
        list($usec, $sec) = explode(' ', microtime());
        return date('Y-m-d H:i:s') . ltrim($usec, '0');
    }

    /**
     * 获得用户的真实IP地址
     *
     * @return string
     */
    public static function real_ip()
    {
        static $realip = null;

        if($realip !== null) {
            return $realip;
        }

        if(isset($_SERVER)) {
            if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
                $arr = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);

                // 取HTTP_X_FORWARDED_FOR中第一个非unknown的有效IP字符串
                foreach ($arr as $ip) {
                    $ip = trim($ip);
                    if ($ip != 'unknown') {
                        $realip = $ip;
                        break;
                    }
                }
            } elseif (isset($_SERVER['HTTP_CLIENT_IP'])) {
                $realip = $_SERVER['HTTP_CLIENT_IP'];
            } elseif (isset($_SERVER['ROMOTE_ADDR'])) {
                $realip = $_SERVER['REMOTE_ADDR'];
            } else {
                $realip = '0.0.0.0';
            }
        } else {
            if(getenv('HTTP_X_FORWARDED_FOR')) {
                $realip = getenv('HTTP_X_FORWARDED_FOR');
            } elseif (getenv('HTTP_CLIENT_IP')) {
                $realip = getenv('HTTP_CLIENT_IP');
            } else {
                $realip = getenv('REMOTE_ADDR');
            }
        }

        preg_match("/[\d\.]{7,15}/", $realip, $onlineip);
        $realip = !empty($onlineip[0]) ? $onlineip[0] : '0.0.0.0';

        return $realip;
    }
}