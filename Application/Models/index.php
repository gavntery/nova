<?php
/**
 * Created by PhpStorm.
 * User: terry
 * Date: 15/3/17
 * Time: PM3:23
 */

namespace Nova\Application\Models;


class index extends base
{
    protected $db;

    public function __construct()
    {
        $this->db = $this->getDb();
    }

    public function getAllUser()
    {
        $sql = 'select * from user';

        $stmt = $this->db->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll();
    }
}