<?php

/**
 * This file is part of Lenius Basket, a PHP package to handle
 * your shopping basket.
 *
 * Copyright (c) 2017 Lenius.
 * https://github.com/lenius/basket
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author Carsten Jonstrup<info@lenius.dk>
 * @copyright 2017 Lenius.
 *
 * @version production
 *
 * @see https://github.com/lenius/basket
 */

namespace Lenius\LaravelBasket\Identifier;

use Lenius\Basket\IdentifierInterface;

/**
 * Class LaravelCookie.
 */
class LaravelCookie implements IdentifierInterface
{
    /**
     * Get the current or new unique identifier.
     *
     * @return string The identifier
     */
    public function get(): string
    {
        if (request()->hasCookie('cart_identifier')) {
            return request()->cookie('cart_identifier');
        }

        return $this->regenerate();
    }

    /**
     * Regenerate the identifier.
     *
     * @return string The identifier
     */
    public function regenerate(): string
    {
        $identifier = (string) \Str::uuid();

        \Cookie::queue(cookie('cart_identifier', $identifier, 0, '/'));

        return $identifier;
    }

    /**
     * Forget the identifier.
     *
     * @return void
     */
    public function forget(): void
    {
        \Cookie::queue(\Cookie::forget('cart_identifier'));
    }
}
