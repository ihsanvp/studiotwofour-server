<?php

class IndexRouteHandler
{
    public function handle()
    {
        return response()->json([
            'name' => 'studiotwofour-server',
            'api' => '2.0.0'
        ]);
    }
}
