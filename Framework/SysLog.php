<?php
/**
 * Created by PhpStorm.
 * User: terry
 * Date: 15/3/17
 * Time: PM4:10
 */

namespace Nova\Framework;


class SysLog
{
    //进程ID
    private static $pid = null;

    public static function log($data, $method = '', $type = 'info', $fileName = 'main')
    {
        if (!DEBUG_MODE) {
            switch ($type) {
                case 'debug':
                case 'info':
                    return;
            }
        }

        if (is_array($data)) {
            $data = json_encode($data);
        }

        $logFile = LOG_DIR . '/' . date("Y/m/d") . '/' . $fileName . '.log';

        if (!file_exists(dirname($logFile))) {
            mkdir(dirname($logFile), 0775, true);
            chmod(dirname($logFile), 0775);
        }

        if (!empty($method)) {
            $method = substr($method, strlen("Nova\\Application\\"));
            $method = "[{$method}]";
        }

        $uniqid = self::get_pid();
        $sessionId = '';


        $logs = Tools::date_with_microtime() . " [{$uniqid}] [{$sessionId}] [{$type}] {$method} " . $data . "\r\n";

        error_log($logs, 3, $logFile);
    }

    public static function get_pid() {
        if(self::$pid == null)
            self::$pid = sha1(uniqid(4));

        return self::$pid;
    }
}