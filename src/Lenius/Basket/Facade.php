<?php

/**
* This file is part of Lenius Basket for Laravel 4, a PHP
* package to provide a Service Provider and Facade for
* the Lenius\Basket package.
*
* Copyright (c) 2013 Lenius.
* http://github.com/lenius/laravel-basket
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*
* @package lenius/laravel-basket
* @author Carsten <carsten@lenius.dk>
* @copyright 2013 Lenius.
* @version dev
* @link http://github.com/lenius/laravel-basket
*
*/

namespace Lenius\Basket;

class Facade extends \Illuminate\Support\Facades\Facade
{
    protected static function getFacadeAccessor()
    {
        return 'basket';
    }
}