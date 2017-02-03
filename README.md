# Quazar - An e-commerce package for Quarx and Laravel

[![Build Status](https://travis-ci.org/YABhq/Quazar.svg?branch=master)](https://travis-ci.org/YABhq/Quazar)
[![Packagist](https://img.shields.io/packagist/dt/yab/quazar.svg?maxAge=2592000)](https://packagist.org/packages/yab/quazar)
[![license](https://img.shields.io/github/license/mashape/apistatus.svg?maxAge=2592000)](https://packagist.org/packages/yab/quazar)

Quazar is a e-commerce package for Quarx. It is an elegant solution for adding an e-commerce platform to your Quarx instance. This means it can be added to existing apps, or fresh installs and setups of the Quarx CMS.
You can control: products, subscriptions, transaction history, orders, and some year by year analytics. Utilizing the power of Stripe, you can spin up a store, where you can offer subscriptions, digital products for download, or even physical products for order shipments. Integrate any external services to handle shipping rates, and tracking number updates. Take control of the many things you make, and build the store you've always wanted.

## Requirements
1. PHP 5.6+
2. MySQL 5.6+
3. OpenSSL
4. Laravel 5.4+
4. Quarx 2.3+

## Recommended
1. PHP 7+
1. MySQL 5.7+

## Installation

Run the following command:

```bash
composer require yab/quazar
composer require laravel/cashier
```

Don't worry about the laravel cashier installation, the only points of interest are specified below:

Add the following to your `config/services.php`:

```php
'stripe' => [
    'model' => App\Models\UserMeta::class,
    'key' => env('STRIPE_KEY'),
    'secret' => env('STRIPE_SECRET'),
],
```

Now you need to add the Billable trait to the `App\Models\UserMeta::class`

```php
use \Laravel\Cashier\Billable;
```

Then publish the vendor assets etc:

```php
php artisan vendor:publish
php artisan module:publish Quazar
php artisan migrate
```

If you wish to maintain consistency with the store accross your login, user settings etc you can set the extends to `@extends('quazar-frontend::layouts.store')`

## Config

## Quarx & Laracogs
Quazar is intented to be used with Quarx so use outside of that context is to be done at your own risk. Similarly, though Quarx is able to be added to any existing Laravel 5.3+ application, the documentation above is in relation to using the `php artisan quarx:setup` command, which is heavily integrated with [Laracogs](https://laracogs.com).

#### CURRENCY
You can set the currency in the module `config.php` file. It is set to use an the env: CURRENCY but pending on your deployment this may not work correctly, and may need to be set manually.

## Customizing

Quazar is intented to be heavily customized per use. The general structure can support stores that sell digital and physical products, and integrate shipping management. But it can also be used to handle subscriptions. This means you can set up an instance of Quazar to handle subscriptions which produce orders which are shipped and tracked for your customers.

### LogisticService

The logistic service is published to your app specifically. The intention is for it to handle 'hooks' on the various events that occur within your store flow. The `LogisticService` handles the following events:

```php
shipping($user)
getTaxPercent($user)
afterPurchase($user, $transaction, $cart, $result)
afterSubscription($user, $plan)
afterRefundRequest($transaction)
afterRefund($transaction)
cancelSubscription($user, $plan)
afterPlaceOrder($user, $transaction, $cart)
orderCreated($order)
shipOrder($order)
cancelOrder($order)
```

### Controllers

There are a few controllers added to your app in the Quazar directory. These are general controllers which you may wish to customize based on your app's setup. Ideally you would leave the Services/ Repositories, but technically you can change whatever you want.

### Views

There are Quazar view files that are published your app which you can modify, however, if you wish to edit the package views then you will need to update them in the `resources/quazar` directory.

## License

Quazar is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT)

### Bug Reporting and Feature Requests

Please add as many details as possible regarding submission of issues and feature requests

### Disclaimer

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
