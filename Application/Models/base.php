<?php
/**
 * Created by PhpStorm.
 * User: terry
 * Date: 15/3/17
 * Time: PM2:25
 */

namespace Nova\Application\Models;
use Nova\Application\Helper\PDOMysql;


class base
{
    protected function getDb() {
        return PDOMysql::connect()->db;
    }
}