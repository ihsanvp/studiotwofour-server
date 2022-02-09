<?php

namespace Studiotwofour\Server\Handlers;

abstract class Handler
{
    abstract public function handle();

    abstract public static function register();

    protected static function createHandler(Handler $handler)
    {
        return fn () => $handler->handle();
    }
}
