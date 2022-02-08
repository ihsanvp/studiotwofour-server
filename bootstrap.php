<?php

app()->set404(function () {
    return response()->json([
        'message' => 'url not found',
    ], 404);
});

app()->setErrorHandler(function () {
    return response()->json([
        'message' => 'an unexpected error occured'
    ], 500);
});
