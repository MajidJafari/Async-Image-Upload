<?php
/**
 * Created by PhpStorm.
 * User: Majid
 * Date: 9/30/2018
 * Time: 9:33 PM
 */


use App\Controllers\Index;
use App\Controllers\Upload;
use App\Controllers\Favicon;
use App\Controllers\Preview;
use App\Controllers\Download;

$childProcessFactory = new \App\ChildProcessFactory(__DIR__);

return [
    'download/uploads/.*\.(jpg|png)' => new Download($childProcessFactory),

    'previews/.*\.(jpg|png)' => new Preview($childProcessFactory),

    'upload' => new Upload($childProcessFactory),

    'favicon.ico' => new Favicon(),

    '' => new Index($childProcessFactory),
];