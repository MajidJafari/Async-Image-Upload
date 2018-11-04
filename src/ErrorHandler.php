<?php
/**
 * Created by PhpStorm.
 * User: Majid
 * Date: 11/3/2018
 * Time: 9:07 PM
 */

namespace App;

use React\ChildProcess\Process;
use React\Http\Response;
use Throwable;

class ErrorHandler
{
    private $loop;

    public function __construct($loop)
    {
        $this->loop = $loop;
    }

    public function handle(Throwable $throwable) {
        $this->report($throwable);
        return $this->process($throwable);
    }

    private function report(Throwable $throwable) {
        echo 'Error: ' . $throwable->getMessage() . PHP_EOL;
    }

    private function process(Throwable $throwable) {
        $process = new Process('cat pages/error.html');
        $process->start($this->loop);

        return new Response(500, ['Content-Type' => 'text/html'], $process->stdout);
    }
}