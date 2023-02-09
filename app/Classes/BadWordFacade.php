<?php

namespace App\Classes;

use Illuminate\Support\Facades\Facade;

/**
 *
 *  @method static validateBy(...$data)
 * */
class BadWordFacade extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'BadWordFacade';
    }
}
