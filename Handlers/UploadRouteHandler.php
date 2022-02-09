<?php

namespace Studiotwofour\Server\Handlers;

use Eloquent\Pathogen\Path;
use Eloquent\Pathogen\PathInterface;
use Studiotwofour\Server\Handlers\Handler;

class UploadRouteHandler extends Handler
{
    private string $storageDirectory = 'storage';
    private string $noMatchDirectory = 'others';
    private array $subDirectoryMatch = [
        'images' => ['image'],
        'videos' => ['video'],
        'documents' => ['application/pdf'],
        'archives' => ['application/zip', 'application/x-tar']
    ];

    public function handle()
    {
        if (!$this->validate()) {
            return;
        }

        $file = request()->files('file');
        $targetDir = $this->getTargetDir($file['type']);

        $this->ensureDir($targetDir->string());

        $tempfile = $file['tmp_name'];
        $filename = $this->getFileName($file['name']);
        $target = $targetDir->joinAtoms($filename);

        move_uploaded_file($tempfile, $target->string());

        return response()->json([
            'message' => 'success',
            'file' => $file,
            'target' => $target->string()
        ]);
    }

    private function validate(): bool
    {
        $file = request()->files('file');

        if (!$file | $file['error'] != 0) {
            response()->json([
                'message' => 'missing file'
            ], 400);

            return false;
        }

        return true;
    }

    private function ensureDir($path)
    {
        if (!file_exists($path)) {
            mkdir($path, 0777, true);
        }
    }

    private function getTargetDir($type): PathInterface
    {
        $targetDir = Path::fromString($this->storageDirectory);
        $subDir = $this->getSubDir($type);
        $targetDir = $targetDir->joinAtoms($subDir);

        return $targetDir;
    }

    private function getSubDir($type): string
    {
        foreach ($this->subDirectoryMatch as $dir => $matches) {
            foreach ($matches as $match) {
                if (str_contains($type, $match)) {
                    return $dir;
                }
            }
        }

        return $this->noMatchDirectory;
    }

    private function getFileName($name): string
    {
        $uniqId = md5(uniqid() . $name . rand(0, 100));
        $file = Path::fromString($name);
        $filename = $file->nameWithoutExtension();
        $extension = $file->extension();

        return $filename . "__" . $uniqId . "." . $extension;
    }

    public static function register()
    {
        return Handler::createHandler(new UploadRouteHandler());
    }
}
