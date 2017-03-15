<?php
/**
 * Created by PhpStorm.
 * User: terry
 * Date: 14/3/17
 * Time: PM9:50
 */
namespace Nova\Application\Controllers;
use Nova\Application\Models;

class index
{
    public function main()
    {
        $mIndex = new Models\index();

        print_r($mIndex->getAllUser());
    }
}