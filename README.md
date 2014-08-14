Laravel Shopping Basket Package
[![Total Downloads](https://poser.pugx.org/lenius/laravel-basket/downloads.svg)](https://packagist.org/packages/lenius/laravel-basket)
============

Laravel Facade and Service Provider for Lenius\Basket

Installation
---

To use, simply install the package via Composer and then add the following to your app/config/app.php to the service providers array:

```php
'Lenius\Basket\BasketServiceProvider',
```

You should then be good to go and be able to access the basket using the following static interface:

```php
//Format array of required info for item to be added to basket...
$items = array(
	'id' => 1,
	'name' => 'Dog',
	'price' => 120.00,
	'quantity' => 1,
    'weight' => 200
);

//Make the insert...
Basket::insert($items);

//Let's see what we have got in their...
dd(Basket::totalItems());
```

### Setting the tax rate for an item
Another key you can pass to your insert method is 'tax'. This is a percentage which you would like to be added onto
the price of the item.

In the below example we will use 25% for the tax rate.

```php
Basket::insert(array(
    'id'       => 'mouseid',
    'name'     => 'Mouse',
    'price'    => 100,
    'quantity' => 1,
    'tax'      => 25,
    'weight' => 200
));
```

### Updating items in the Basket
You can update items in your Basket by updating any property on a Basket item. For example, if you were within a
Basket loop then you can update a specific item using the below example.
```php
foreach (Basket::contents() as $item) {
    $item->name = 'Foo';
    $item->quantity = 1;
}
```

### Removing Basket items
You can remove any items in your Basket by using the ```remove()``` method on any Basket item.
```php
foreach (Basket::contents() as $item) {
    $item->remove();
}
```

### Destroying/emptying the Basket
You can completely empty/destroy the Basket by using the ```destroy()``` method.
```php
Basket::destroy()
```

### Retrieve the Basket contents
You can loop the Basket contents by using the following method
```php
Basket::contents();
```

You can also return the Basket items as an array by passing true as the first argument
```php
Basket::contents(true);
```

### Retrieving the total items in the Basket
```php
Basket::totalItems();
```

By default this method will return all items in the Basket as well as their quantities. You can pass ```true```
as the first argument to get all unique items.
```php
Basket::totalItems(true);
```

### Retrieving the Basket total
```php
$Basket->total();
```

By default the ```total()``` method will return the total value of the Basket as a ```float```, this will include
any item taxes. If you want to retrieve the Basket total without tax then you can do so by passing false to the
```total()``` method
```php
Basket::total(false);
```

### Check if the Basket has an item
```php
Basket::has($itemIdentifier);
```

### Retreive an item object by identifier
```php
Basket::item($itemIdentifier);
```

## Basket items
There are several features of the Basket items that may also help when integrating your Basket.

### Retrieving the total value of an item
You can retrieve the total value of a specific Basket item (including quantities) using the following method.
```php
Basket::total();
```

By default, this method will return the total value of the item plus tax. So if you had a product which costs 100,
with a quantity of 2 and a tax rate of 20% then the total returned by this method would be 240.

You can also get the total minus tax by passing false to the ```total()``` method.
```php
Basket::total(false);
```

This would return 200.

### Check if an item has options
You can check if a Basket item has options by using the ```hasOptions()``` method.

```php
if ($item->hasOptions()) {
    // We have options
}
```

### Remove an item from the Basket
```php
$item->remove();
```

### You can also get the total weight for a single item
```php
$item->weight();
```

### Output the item data as an array
```php
$item->toArray();
```
