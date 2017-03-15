<?php
/**
 * Created by PhpStorm.
 * User: terry
 * Date: 15/3/17
 * Time: PM2:25
 */

namespace Nova\Application\Models;
use Nova\Framework;


class base
{
    protected $db = null;

    protected function getDb() {
        $this->db = Framework\PDOMysql::connect()->db;
    }
}