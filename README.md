# Hadron - An e-commerce package for Laravel

Hadron is a e-commerce package for Quarx. It is an elegant solution for adding an e-commerce platform to your Quarx instance. This means it can be added to existing apps, or fresh installs and setups of the Quarx CMS.
You can control, products, subscriptions, transaction history, orders, and some year by year analytics. Utilizing the power of Stripe, you can spin up a store, where you can offer subscriptions, ditial products for download, or even physical products for order shipments. Integrate any external services to handle shipping rates, and tracking number updates. Take control of the many things you make, and build the store you've always wanted.

## Requirements
1. PHP 5.6+
2. MySQL 5.6+
3. OpenSSL
4. Laravel 5.3

## Recommended
1. PHP 7+
1. MySQL 5.7+

## Installation

Run the following command:

```bash
composer require yab/hadron
composer require laravel/cashier
```

Add this to your Quarx app's `composer.json`

```json
{
    "extra": {
        "installer-paths": {
            "quarx/modules/{$name}/": ["yab/hadron"]
        }
    }
}
```

Add the following to your Providers:

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
php artisan module:publish Hadron
php artisan migrate
```

Add the following to the Http Kernel

```php
'isAjax' => \Quarx\Modules\Hadron\Middleware\isAjax::class,
```

## Customizing

Hadron is intented to be heavily customized per use. The general structure can support stores that sell digital and physical products, and integrate shipping management. But it can also be used to handle subscriptions. This means you can set up an instance of Hadron to handle subscriptions which produce orders which are shipped and tracked for your customers.

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

There are a few controllers added to your app in the Hadron directory. These are general controllers which you may wish to customize based on your app's setup. Ideally you would leave the Services/ Repositories, but technically you can change whatever you want.

### Views

There are Hadron view files that are published your app which you can modify, however, if you wish to edit the package views then you will need to update them in the `quarx/modules/Hadron/Views` directory.

## Updates

When running updates for Hadron, in particular if you run `php artisan module:publish Hadron` after the update, please make a special note. The way the package is provided it should be commited in full to your `repository`. So when you run the update it may overwrite your customizations. This means you should ensure that all your commits are set prior to running the updater. Then once you run it, if you do run the `module:publish` command double check your code base to ensure that nothing is broken or lost.

## License

Quarx is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT)

### Bug Reporting and Feature Requests

Please add as many details as possible regarding submission of issues and feature requests

### Disclaimer

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
