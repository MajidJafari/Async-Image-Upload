<?php
/**
 * Created by PhpStorm.
 * User: Majid
 * Date: 9/28/2018
 * Time: 9:24 PM
 */
require __DIR__.'/vendor/autoload.php';
include __DIR__.'/includes/display_error.php';

use App\Router;

$loop = \React\EventLoop\Factory::create();
$router = new Router($loop);
$router->load(__DIR__.'/routes.php');

$errorHandler = new \App\ErrorHandler($loop);

$server = new \React\Http\Server(
    function (\Psr\Http\Message\ServerRequestInterface $request) use ($router, $errorHandler) {
        try {
            return  $router($request);
        }
        catch (Throwable $exception) {
            return $errorHandler->handle($exception);
        }
    });

$socket = new \React\Socket\Server(8080, $loop);
$server->listen($socket);

echo 'Listening on ' . str_replace('tcp:', 'http:', $socket->getAddress()) . "\n";

/*$server->on('error', function (Exception $exception) {
    echo 'Error: ' . $exception->getMessage() . PHP_EOL;

    if($exception->getPrevious() !== null) {
        echo 'Error: ' . $exception->getPrevious()->getMessage() . PHP_EOL;
    }
});*/

$loop->run();