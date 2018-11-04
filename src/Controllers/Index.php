<?php

namespace App\Controllers;

use App\Router;
use React\EventLoop\LoopInterface;
use Psr\Http\Message\ServerRequestInterface;

class Index {
    private $childProcess;

    public function __construct($childProcess)
    {
        $this->childProcess = $childProcess;
    }

    public function __invoke(ServerRequestInterface $request, LoopInterface $loop)
    {
        $listFiles = $this->childProcess->create('ls uploads');
        $listFiles->start($loop);

        $renderPage = $this->childProcess->create('php pages/index.php');
        $renderPage->start($loop);

        $listFiles->stdout->pipe($renderPage->stdin);

        return Router::ok($renderPage->stdout);
    }
}