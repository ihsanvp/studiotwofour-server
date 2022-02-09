<?php

namespace Studiotwofour\Server\Handlers;

use Studiotwofour\Server\Handlers\Handler;

class IndexRouteHandler extends Handler
{
    public function handle()
    {
        return response()->json([
            'name' => 'studiotwofour-server',
            'api' => '2.0.0'
        ]);
    }

    public static function register()
    {
        return Handler::createHandler(new IndexRouteHandler());
    }
}
