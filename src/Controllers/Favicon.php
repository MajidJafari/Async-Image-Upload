<?php
/**
 * Created by PhpStorm.
 * User: Majid
 * Date: 11/3/2018
 * Time: 4:24 PM
 */

namespace App\Controllers;


use App\Router;

class Favicon
{
    public function __invoke()
    {
        return Router::ok('', ['Content-Type' => 'image/x-icon']);
    }
}