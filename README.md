# Integration with Kupongsupport API

[![Latest Version on Packagist](https://img.shields.io/packagist/v/smlnordic/kupongsupport-api.svg?style=flat-square)](https://packagist.org/packages/smlnordic/kupongsupport-api)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/SMLNordic/laravel-kupongsupport-api/run-test.yml?branch=master)](https://github.com/SMLNordic/laravel-kupongsupport-api/actions?query=workflow%3ATests+branch%3Amaster)
[![GitHub Code Style Action Status](https://img.shields.io/github/actions/workflow/status/SMLNordic/laravel-kupongsupport-api/fix-php-code-style-issues.yml?label=code%20style)](https://github.com/SMLNordic/laravel-kupongsupport-api/actions?query=workflow%3A"Fix+PHP+code+style+issues"+branch%3Amaster)
[![Total Downloads](https://img.shields.io/packagist/dt/smlnordic/kupongsupport-api.svg?style=flat-square)](https://packagist.org/packages/smlnordic/kupongsupport-api)
![Website](https://img.shields.io/website?url=https%3A%2F%2Fkupongsupport.se%2Fapi&label=KSAPI%20Status)
## Installation

You can install the package via composer:

```bash
composer require smlnordic/kupongsupport-api
```

Init .env variables:

```bash
php artisan ks-api-init
```

You can publish the config file with:
```bash
php artisan vendor:publish --provider="SMLNordic\KSApi\KSApiServiceProvider" --tag="kupongsupport-api-config"
```

This is the contents of the published config file:

```php
return [
    'token' => env('KS_API_TOKEN'),
    'base_url' => env('KS_BASE_URL', 'https://kupongsupport.se'),

    'templates' => [
        'print' => env('KS_PRINT_TEMPLATE_ID'),
        'mobile' => env('KS_MOBILE_TEMPLATE_ID'),
    ],
];
```

## Usage

Create and send a coupon via SMS:

```php
$options = [
    'template' => XXXX, // Template ID in Kupongsupport
    'type' => 'mobile', // "print" or "mobile
    'delivery_type' => 'sms', // "sms", "email" or "api"
    'amount' => 10,
    'valid_days' => 90,
];
$kupongsupport = new SMLNordic\KSApi();
$coupon = $kupongsupport->createCoupon($options);
```



## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [SocialMediaLab](https://github.com/SMLNordic)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
