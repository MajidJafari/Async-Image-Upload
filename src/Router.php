<?php
/**
 * Created by PhpStorm.
 * User: Majid
 * Date: 9/30/2018
 * Time: 9:12 PM
 */

namespace App;

use React\Http\Response;
use Psr\Http\Message\ServerRequestInterface;

class Router
{
    private $routes = [];
    private $loop = [];

    public function __construct(\React\EventLoop\LoopInterface $loop)
    {
        $this->loop = $loop;
    }

    public function __invoke(ServerRequestInterface $request)
    {
        $path = trim($request->getUri()->getPath());

        foreach ($this->routes as $pattern => $handler) {
            if(preg_match("~/$pattern~", $path)) {
                return $handler($request, $this->loop);
            }
        }

        return $this->notFound($path);
    }

    public function load($filename) {
        $routes = require $filename;
        foreach ($routes as $path => $handler) {
            $this->add($path, $handler);
        }
    }

    private function add($path, callable $handler) {
        $this->routes[$path] = $handler;
    }

    private function notFound($path) {
        return new Response(
            404, ['content-type' => 'text/html'], "No request handler for $path"
        );
    }

    public static function ok($body = '', $headers = ['Content-Type' => 'text/html'])
    {
        return new Response(
            200, $headers, $body
        );
    }
}