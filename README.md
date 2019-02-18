# Laravel Instagram Feed

<!-- [![Latest Version on Packagist](https://img.shields.io/packagist/v/ralphmorris/laravel-instagram.svg?style=flat-square)](https://packagist.org/packages/ralphmorris/laravel-instagram) -->
<!-- [![Build Status](https://img.shields.io/travis/ralphmorris/laravel-instagram/master.svg?style=flat-square)](https://travis-ci.org/ralphmorris/laravel-instagram) -->
<!-- [![Quality Score](https://img.shields.io/scrutinizer/g/ralphmorris/laravel-instagram.svg?style=flat-square)](https://scrutinizer-ci.com/g/ralphmorris/laravel-instagram) -->
<!-- [![Total Downloads](https://img.shields.io/packagist/dt/ralphmorris/laravel-instagram.svg?style=flat-square)](https://packagist.org/packages/ralphmorris/laravel-instagram) -->

Adds an OAuth integration with the Instagram API. Allow users to connect their Instagram account to a Laravel App and display their feed.

## Installation

You can install the package via composer:

```bash
composer require ralphmorris/laravel-instagram-feed
```

After installation publish the migration and config file with:

```bash
php artisan vendor:publish --provider="RalphMorris\LaravelInstagramFeed\LaravelInstagramFeedServiceProvider"
```

Then run:

```bash
php artisan migrate
```

### Config

Enter your environment variables for your Instagram Client API in your .env file. You can get your API keys by going to https://www.instagram.com/developer/clients/manage/ and following the steps to register a new client.

```bash
instagram_client_id=your-client-id
instagram_client_secret=your-client-secret
```

#### Caching

By default the package caches the Instagram profiles feed for a period of time. This can be controlled in the published config file.

#### Overriding Used Model

You can also create your own Model, extending the default RalphMorris\LaravelInstagramFeed\Models\InstagramProfile model if you woud like to add your own mthods to this class. You can then update the config file with your own models namespace to tell the package to use that instead.

## Usage

``` php
// Usage description here
```

### Testing

``` bash
composer test
```

### Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

### Security

If you discover any security related issues, please email ralph@bubblehubsolutions.co.uk instead of using the issue tracker.

## Credits

- [Ralph Morris](https://github.com/ralphmorris)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

## Laravel Package Boilerplate

This package was generated using the [Laravel Package Boilerplate](https://laravelpackageboilerplate.com).