<?php

/**
 * This file is part of Lenius Basket, a PHP package to handle
 * your shopping basket.
 *
 * Copyright (c) 2017 Lenius.
 * http://github.com/lenius/basket
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author Carsten Jonstrup<info@lenius.dk>
 * @copyright 2017 Lenius.
 *
 * @version production
 *
 * @link http://github.com/lenius/basket
 */

namespace Lenius\Basket\Storage;

use Illuminate\Support\Facades\Session;
use Lenius\Basket\ItemInterface;
use Lenius\Basket\StorageInterface;

/**
 * @property string id
 * @property string identifier
 */
class LaravelSession implements StorageInterface
{
    protected $identifier;
    protected static $cart = [];

    public function restore()
    {
        $carts = Session::get('cart');

        if ($carts) {
            static::$cart = $carts;
        }
    }

    /**
     * Add or update an item in the cart.
     *
     * @param Item $item The item to insert or update
     *
     * @return void
     */
    public function insertUpdate(Item $item)
    {
        static::$cart[$this->id][$item->identifier] = $item;

        $this->saveCart();
    }

    /**
     * Retrieve the cart data.
     *
     * @param bool $asArray
     *
     * @return array
     */
    public function &data($asArray = false)
    {
        $cart = &static::$cart[$this->id];

        if (!$asArray) {
            return $cart;
        }

        $data = $cart;

        foreach ($data as &$item) {
            $item = $item->toArray();
        }

        return $data;
    }

    /**
     * Check if the item exists in the cart.
     *
     * @param mixed $identifier
     *
     * @return bool|ItemInterface
     *
     * @internal param mixed $id
     */
    public function has($identifier)
    {
        foreach (static::$cart[$this->id] as $item) {
            if ($item->identifier == $identifier) {
                return true;
            }
        }

        return false;
    }

    /**
     * Get a single cart item by id.
     *
     * @param mixed $identifier
     *
     * @return bool|ItemInterface
     *
     * @internal param mixed $id The item id
     */
    public function item($identifier)
    {
        foreach (static::$cart[$this->id] as $item) {
            if ($item->identifier == $identifier) {
                return $item;
            }
        }

        return false;
    }

    /**
     * Returns the first occurance of an item with a given id.
     *
     * @param string $id The item id
     *
     * @return bool|ItemInterface
     */
    public function find($id)
    {
        foreach (static::$cart[$this->id] as $item) {
            if ($item->id == $id) {
                return $item;
            }
        }

        return false;
    }

    /**
     * Remove an item from the cart.
     *
     * @param mixed $id
     *
     * @return void
     */
    public function remove($id)
    {
        unset(static::$cart[$this->id][$id]);

        $this->saveCart();
    }

    /**
     * Destroy the cart.
     *
     * @return void
     */
    public function destroy()
    {
        static::$cart[$this->id] = [];

        $this->saveCart();
    }

    /**
     * Set the cart identifier.
     *
     * @param string $id
     *
     * @internal param string $identifier
     */
    public function setIdentifier($id)
    {
        $this->id = $id;

        if (!array_key_exists($this->id, static::$cart)) {
            static::$cart[$this->id] = [];
        }

        $this->saveCart();
    }

    /**
     * Return the current cart identifier.
     *
     * @return void
     */
    public function getIdentifier()
    {
        return $this->id;
    }

    /**
     * Save Cart.
     */
    protected function saveCart()
    {
        $data = static::$cart;

        Session::put('cart', $data);
    }
}
