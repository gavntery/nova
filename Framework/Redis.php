<?php
/**
 * Created by PhpStorm.
 * User: terry
 * Date: 16/3/17
 * Time: PM6:58
 */

namespace Nova\Framework;


class Redis extends \Redis
{
    private static $_instanceObj;
    public $groupName = REDIS_ROOT;
    private $tempName = "temp:";
    private $_redis;
    private $groupPath = REDIS_ROOT;

    public function __construct()
    {
        $this->_redis = new \Redis();
        $this->_redis->connect(REDIS_HOST, REDIS_PORT);
    }

    public static function get_instance($redisKey = REDIS_ROOT)
    {
        if (!(self::$_instanceObj[$redisKey] instanceof self)) {
            self::$_instanceObj[$redisKey] = new self;
        }

        self::$_instanceObj[$redisKey]->redisKey = $redisKey;
        return self::$_instanceObj[$redisKey];
    }

    public function set_group($groupName = "")
    {
        if (empty($groupName)) {
            return FLASE;
        }
        $this->groupName = $groupName;
        $this->groupPath = implode(":", explode("/", $groupName)) . ":";

        return TRUE;
    }

    public function set($key, $data, $groupName = "", $timeout = SESSION_TIMEOUT)
    {
        if (empty($groupName)) {
            $groupName = $this->groupName . $this->tempName;
        } else {
            $groupName = $this->groupName . $groupName;
        }

        if (is_array($data)) {
            $data = json_encode($data);
        }
        $redisKey = $groupName . $key;

        return $this->_redis->setex($redisKey, $timeout, $data);

    }

    public function get($key, $groupName = "")
    {
        if (empty($groupName)) {
            $groupName = $this->groupName . $this->tempName;
        } else {
            $groupName = $this->groupName . $groupName;
        }
        $redisKey = $groupName . $key;
        $return = "";
        $temp = $this->_redis->get($redisKey);
        $return = json_decode($temp, 1);
        return empty($return) ? $temp : $return;
    }

    public function delete($key, $groupName = "")
    {
        if (empty($groupName)) {
            $groupName = $this->groupName . $this->tempName;
        } else {
            $groupName = $this->groupName . $groupName;
        }
        $redisKey = $groupName . $key;
        return $this->_redis->delete($redisKey);
    }

    public function exists($key, $groupName = "")
    {
        if (empty($groupName)) {
            $groupName = $this->groupName . $this->tempName;
        } else {
            $groupName = $this->groupName . $groupName;
        }
        $redisKey = $groupName . $key;
        return $this->_redis->exists($redisKey);
    }
}