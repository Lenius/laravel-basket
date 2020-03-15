<?php

/**
 * This file is part of Lenius Basket for Laravel 5, a PHP
 * package to provide a Service Provider and Facade for
 * the Lenius\Basket package.
 *
 * Copyright (c) 2017 Lenius.
 * http://github.com/lenius/laravel-basket
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author Carsten <carsten@lenius.dk>
 * @copyright 2017 Lenius.
 *
 * @version production
 *
 * @see http://github.com/lenius/laravel-basket
 */

namespace Lenius\LaravelBasket\Facades;

class Basket extends \Illuminate\Support\Facades\Facade
{
    protected static function getFacadeAccessor()
    {
        return 'basket';
    }
}
