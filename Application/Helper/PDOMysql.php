<?php
/**
 * Created by PhpStorm.
 * User: terry
 * Date: 15/3/17
 * Time: AM10:51
 */

namespace Nova\Application\Helper;


class PDOMysql
{
    // 连接状态
    public $connectionStatus = FALSE;

    //PDO对象
    public $db;

    //连接配置
    protected $dbHost, $dbName, $dbUserName, $dbPassword, $dbConnectStr, $dbCharset;

    public static $_instance = array();

    protected function __construct($type = 0, $autoClose = 0, $dbServer = array())
    {
        $this->dbHost = empty($dbServer['host']) ? DB_HOST : $dbServer['host'];
        $this->dbName = empty($dbServer['db_name']) ? DB_NAME : $dbServer['db_name'];
        $this->dbUserName = empty($dbServer['user_name']) ? DB_USER : $dbServer['user_name'];
        $this->dbPassword = empty($dbServer['password']) ? DB_PASSWORD : $dbServer['password'];
        $this->dbCharset = empty($dbServer['charset']) ? DB_CHARSET : $dbServer['charset'];

        try {
            $this->db = new \PDO("mysql:host=$this->dbHost;dbname=$this->dbName", $this->dbUserName, $this->dbPassword, array(
                \PDO::ATTR_PERSISTENT => $type,
                \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
                \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
                \PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES " . $this->dbCharset,
                \PDO::MYSQL_ATTR_USE_BUFFERED_QUERY => TRUE,
                \PDO::ATTR_AUTOCOMMIT => TRUE
            ));
        } catch (\Exception $e) {
            printf($e->getMessage());
            exit();
        }

        if ($autoClose) {
            register_shutdown_function(array(
                &$this,
                'close_pdomysql'
            ));
        }
    }

    public static function connect($type = 0, $autoClose = 0, $dbServer = array())
    {
        $serverStr = hash('sha256', json_encode((array)($dbServer)));
        if (empty(self::$_instance) || !(self::$_instance[$serverStr] instanceof self)) {
            if ($type)
                $autoClose = 0;
            self::$_instance[$serverStr] = new self($type, $autoClose, $dbServer);
        }

        return self::$_instance[$serverStr];
    }

    public function close_pdomysql()
    {
        $this->db = null;
    }
}