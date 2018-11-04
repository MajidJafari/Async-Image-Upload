<?php
/**
 * Created by PhpStorm.
 * User: Majid
 * Date: 11/3/2018
 * Time: 3:33 PM
 */

namespace App\Controllers;

use React\EventLoop\LoopInterface;
use Psr\Http\Message\ServerRequestInterface;

class Preview
{
    private $childProcess;

    public function __construct($childProcess)
    {
        $this->childProcess = $childProcess;
    }

    public function __invoke(ServerRequestInterface $request, LoopInterface $loop) {
        $fileName = trim($request->getUri()->getPath(), '/');
        $ext = pathinfo($fileName, PATHINFO_EXTENSION);

        $readFile = $this->childProcess->create("cat $fileName");
        $readFile->start($loop);

        return new \React\Http\Response(
            200, ['Content-Type' => "image/$ext"], $readFile->stdout
        );
    }
}