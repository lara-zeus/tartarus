<?php

namespace LaraZeus\Tartarus\Facades;

use Illuminate\Support\Facades\Facade;

class Tartarus extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'tartarus';
    }
}
