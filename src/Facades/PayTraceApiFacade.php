<?php

namespace TechGenies\MM\Facades;

use Illuminate\Support\Facades\Facade;

class PayTraceApiFacade extends Facade
{
    public static function getFacadeAccessor(): string
    {
        return 'payTraceApi';
    }
}
