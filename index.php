<?php

namespace Studiotwofour\Server;

require __DIR__ . "/vendor/autoload.php";

use Studiotwofour\Server\App\Bootstrap;
use Studiotwofour\Server\Handlers\IndexRouteHandler;
use Studiotwofour\Server\Handlers\UploadRouteHandler;

Bootstrap::run();

app()->get("/", IndexRouteHandler::register());

app()->post('/upload', UploadRouteHandler::register());

app()->run();
