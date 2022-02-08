<?php

require __DIR__ . "/vendor/autoload.php";

// bootstrap
require __DIR__ . '/bootstrap.php';

// handlers
require __DIR__ . "/handlers/IndexRouteHandler.php";
require __DIR__ . "/handlers/UploadRouteHandler.php";



app()->get("/", 'IndexRouteHandler@handle');

app()->post('/upload', 'UploadRouteHandler@handle');

app()->run();
