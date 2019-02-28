# PHP SDK for Planet Express API

## Basics

- Every available resource is represented by a class in namespace `Planetexpress\Resources`.

### Creating resources
- Every resource that implements `PlanetExpress\Interfaces\ICreatable` can be created

```php
$order = [
    'note' => 'Very important order',
    'insurance' => true,
    // etc...
];

\PlanetExpress\Resources\Order::create($values); // Create resource 'order' with given values
```

```php
$order = new \PlanetExpress\Resources\Order(1);
$order->note = 'Very important order';
$order->insurance = true;
// etc...

// Create resource 'order' with values from this object
// Also fetches the resource from API
$order->insert();
```

### Obtaining resources
- Every resource that implements `PlanetExpress\Interfaces\IReadable` (and/or `PlanetExpress\Interfaces\IReadableCollection`) can be obtained
is readable.
- Most, if not all resources are readable

```php
\PlanetExpress\Resources\Item::get(1); // Obtain resource 'item' with ID '1'
```

```php
\PlanetExpress\Resources\Item::getAll(); // Obtain all 'item' resources
```

```php
$item = new \PlanetExpress\Resources\Item(1);
$item->fetch(); // Fill in this object with resource 'item' with ID '1'
```

### Editing resources
- Every resource that implements `PlanetExpress\Interfaces\IEditable` can be edited

```php
\PlanetExpress\Resources\Order::edit(1, ['note' => 'Please hurry']); // Edit resource 'order' with ID '1'
```

```php
$order = new \PlanetExpress\Resources\Order(1);
$order->note = 'Please hurry';

// Update resource 'order' with ID '1' with values from this object
// Also fetches the resource from API
$order->update();
```

### Deleting resources
- Every resource that implements `PlanetExpress\Interfaces\IDeletable` (and/or `PlanetExpress\Interfaces\IDeletableCollection`) can be deleted
- Note that deleting the resource does not have to always mean physically removing it
  - For example, deleting a `PlanetExpress\Resources\Order` cancels it

```php
\PlanetExpress\Resources\Order::delete(1); // Delete resource 'order' with ID '1'
```

```php
$order = new \PlanetExpress\Resources\Order(1);

// Remove resource 'order' stored within this object
// Also fetches the resource from API, if it was not physically deleted
$order->remove(); // Order status is now 'canceled'
```

## Examples

### Check API status

- You can check api status by using the `Status` resource:

```php
$code = \PlanetExpress\Resources\Status::get(); // Returns HTTP code, should be 200
```

### Create fulfillment order
- Note that this is only one of the possible ways

1. Obtain your addresses and items
```php
$addresses = \PlanetExpress\Resources\Address::getAll();
$items = \PlanetExpress\Resources\Item::getAll();
```

2. Create order
```php
$order = new \PlanetExpress\Resources\Order();
$order->addressId = 1; // Pick one from your addresses
$order->insurance = true;
$order->promotionalInserts = false;
```

3. Add order item(s)
```php
$item = new \PlanetExpress\Objects\Order\OrderItem();

$item->itemId = 1; // One of your items
$item->quantity = 2;
$item->note = 'Handle with care';

$order->items[] = $item;
```

4. Rate your order to receive list of available carriers for your order (with __estimated__ rates too, if available)
```php
$rates = \PlanetExpress\Resources\OrderRate::getAll();

$order->carrierId = 1; // Pick one from your rates
```

5. Submit the order
```php
$order->insert();
```




