<?php

class IndexRouteHandler
{
    public function handle()
    {
        return response()->json([
            'name' => 'studiotwofour-server',
            'api' => '1.0.0'
        ]);
    }
}
