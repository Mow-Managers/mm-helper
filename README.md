# Mow Managers - Helper

## Requirements

* php >= 8.0.0
* laravel >= 8.12.0
* composer >= 2.0.7

## Installation
```bash
composer require codepso/techgenies-mm
php artisan vendor:publish --tag=mm-config (optional)
composer update codepso/techgenies-mm (optional)
````

### Installation (Docker)
```bash
docker run --rm -it -v $(pwd):/var/www codepso/php:8.0-cli-pgsql composer require codepso/techgenies-mm
docker run --rm -it -v $(pwd):/var/www codepso/php:8.0-cli-pgsql composer update codepso/techgenies-mm
```

## Configuration

.env
```bash
PAY_TRACE_API_URL==https://api.paytrace.com
PAY_TRACE_USERNAME=abc@abc.com
PAY_TRACE_PASSWORD=abc123
````

app/Exceptions/Handler.php
```php
use TechGenies\MM\Exceptions\PayTraceException;

public function register()
{
    //
    
    $this->renderable(function (PayTraceException $e, $request) {
        return $e->getError();
    });
}
```

## Use
```php
use TechGenies\MM\Api\PayTraceApi;

try {
    $payTraceApi = new PayTraceApi();
    return $payTraceApi->customers->create($data);
} catch (PayTraceException $e) {
    return $e->getError();
}
```

```php
use TechGenies\MM\Api\PayTraceApi;

$payTraceApi = new PayTraceApi();
return $payTraceApi->customers->create($data);
```

## Docs

### credentials: `getCredentials($params)`
```php
$credentials = $payTraceApi->getCredentials();
```

### customers: `customers->export($params)`
* **$params**: `array | required`
    - **customer_id**: `string | required`

```php
// Get customer
$params = [
    'customer_id' => 'customerTest1'
];
$customer = $payTraceApi->customers->export($params);
```

### customers: `customers->create($params)`
* **$params**: `array | required`
    - **customer_id**: `string | required`

```php
$params = [
    'customer_id' => $validated['customer_id'],
    'credit_card' => [
        'number' => $validated['credit_card_number'],
        'expiration_month' => $validated['credit_card_expiration_month'],
        'expiration_year' => $validated['credit_card_expiration_year'],
    ],
    'billing_address' => [
        'name' => 'Juan Minaya',
        'street_address' => '8320 E. West St.',
        'city' => 'Spokane',
        'state' => 'WA',
        'zip' => '85284',
    ],
    'check' => [
        'account_number' => '123456',
        'routing_number' => '325070760'
    ]
];
$customer = $payTraceApi->customers->create($params);
```

### ACH: `ach->vaultSale($params)`
* **$params**: `array | required`
    - **customer_id**: `string | required`
```php
$params = [
    'customer_id' => 'customerTest1',
    'amount' => 2.00
];
$payTraceApi->ach->vaultSale($params);
```

## Testing
```bash
laravel new testing
composer remove codepso/techgenies-mm
php artisan serve
```

```bash
"repositories": [
    {
        "type": "path",
        "url": "./packages/techgenies/techgenies-mm"
    }
]
```
```bash
composer update
composer require codepso/techgenies-mm
composer remove codepso/techgenies-mm (remove)
```

# References
- https://cerwyn.medium.com/creating-laravel-package-from-scratch-4582607639cf
- https://www.twilio.com/blog/build-laravel-php-package-seeds-database-fake-data
- https://dev.to/devingray/how-to-create-a-highly-configurable-laravel-package-4pj0
