# Hadron - An e-commerce package for Laravel

Hadron is a e-commerce package for Quarx

## Installation

Run the following command:

```bash
composer require mlantz/hadron
```

Add the following to your Providers:

```php

```

Then publish the vendor assets:

```php

```

* Then add the following code to your User Model:

```php
use Quarx\Modules\Hadron\Models\CustomerProfile;

/**
 * Customer Profile
 *
 * @return Relationship
 */
public function customerProfile()
{
    return $this->hasOne(CustomerProfile::class);
}
```

### Kernal

```php
'isAjax' => \Quarx\Modules\Hadron\Middleware\isAjax::class,
```

## Customizing

### LogisticService



