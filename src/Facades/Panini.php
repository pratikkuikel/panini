<?php

namespace Pratikkuikel\Panini\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Pratikkuikel\Panini\Panini
 */
class Panini extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \Pratikkuikel\Panini\Panini::class;
    }
}
