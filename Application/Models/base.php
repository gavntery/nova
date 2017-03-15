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
    protected function getDb() {
        return Framework\PDOMysql::connect()->db;
    }
}