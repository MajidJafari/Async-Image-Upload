<?php
/**
 * Created by PhpStorm.
 * User: Majid
 * Date: 11/3/2018
 * Time: 3:30 PM
 */

namespace App\Controllers;

use App\Router;
use React\EventLoop\LoopInterface;
use Psr\Http\Message\ServerRequestInterface;
use React\Promise\Deferred;
use React\Promise\Promise;

class Upload
{
    private $childProcess;

    public function __construct($childProcess)
    {
        $this->childProcess = $childProcess;
    }

    /**
     * @param ServerRequestInterface $request
     * @param LoopInterface $loop
     * @return Promise
     */
    public function __invoke(ServerRequestInterface $request, LoopInterface $loop)
    {
        /** @var \Psr\Http\Message\UploadedFileInterface $file */
        $file = $request->getUploadedFiles()['file'];
        $fileName = $file->getClientFilename();

        $saveUpload = $this->childProcess->create("cat > uploads/$fileName");
        $saveUpload->start($loop);
        $saveUpload->stdin->end($file->getStream()->getContents());

        $deferred = new Deferred();
        $saveUpload->stdin->on('close', function () use ($fileName, $loop, $deferred){
            $this->createPreview($fileName, $loop, $deferred);
        });

        return $deferred->promise();
    }

    private function createPreview($fileName, LoopInterface $loop, $deferred)
    {
        $createPreview = $this->childProcess->create(
            "convert uploads/$fileName -resize 128x128 previews/$fileName"
        );
        $createPreview->start($loop);

        $createPreview->on('exit', function () use ($deferred) {
           $deferred->resolve(
                new \React\Http\Response(302, ['Location' => '/'])
           );
        });
    }
}