<?php

class UploadRouteHandler
{
    public function handle()
    {
        return response()->json([
            'message' => 'success'
        ]);
    }
}
