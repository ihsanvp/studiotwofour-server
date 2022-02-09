<?php

namespace Studiotwofour\Server\Handlers;

use Eloquent\Pathogen\Path;
use Studiotwofour\Server\Handlers\Handler;

class StorageInfoHandler extends Handler
{
    private string $storageDirectory = 'storage';

    public function handle()
    {
        $data = $this->getData();

        return response()->json([
            'message' => 'success',
            'data' => $data
        ]);
    }

    private function getData()
    {
        $data = [];

        foreach (new \DirectoryIterator($this->storageDirectory) as $content) {
            if ($content->isDot()) continue;

            if ($content->isDir()) {
                $name = $content->getFilename();
                $path = Path::fromString($this->storageDirectory)->joinAtoms($name);
                $size = $this->getDirectorySize($path->string());

                $data[$name] = $size;
            }
        }

        return $data;
    }

    private function getDirectorySize($path)
    {
        $bytestotal = 0;
        $path = realpath($path);
        if ($path !== false && $path != '' && file_exists($path)) {
            foreach (new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($path, \FilesystemIterator::SKIP_DOTS)) as $object) {
                $bytestotal += $object->getSize();
            }
        }
        return $bytestotal;
    }

    public static function register()
    {
        return Handler::createHandler(new StorageInfoHandler());
    }
}
