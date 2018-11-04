<?php
/**
 * Created by PhpStorm.
 * User: Majid
 * Date: 11/3/2018
 * Time: 3:52 PM
 */

namespace App\Controllers;

use App\Router;
use React\EventLoop\LoopInterface;
use Psr\Http\Message\ServerRequestInterface;

class Download
{
    private $childProcess;

    public function __construct($childProcess)
    {
        $this->childProcess = $childProcess;
    }

    public function __invoke(ServerRequestInterface $request, LoopInterface $loop)
    {
        $fileName = trim($request->getUri()->getPath(), 'download/');

        $readFile = $this->childProcess->create("cat $fileName");
        $readFile->start($loop);

        return Router::ok($readFile->stdout, ['Content-Disposition' => 'attachment']);
    }
}