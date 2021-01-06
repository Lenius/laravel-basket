<?php

/**
 * This file is part of Lenius Basket for Laravel 7-8, a PHP
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

namespace Lenius\LaravelBasket;

use Illuminate\Support\ServiceProvider;
use Lenius\Basket\Basket;
use Lenius\LaravelBasket\Console\EcommerceCommand;
use Lenius\LaravelBasket\Identifier\LaravelCookie;
use Lenius\LaravelBasket\Storage\LaravelSession;

class BasketServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton('basket', function () {
            return new Basket(new LaravelSession(), new LaravelCookie());
        });
    }

    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                EcommerceCommand::class,
            ]);
        }
    }
}
