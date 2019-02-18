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

Add the HasInstagramTrait trait to your model that is the owner of the Instagram Feed. For example the User model.

```php
namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use RalphMorris\LaravelInstagramFeed\Traits\HasInstagramTrait;

class User extends Authenticatable
{
    use HasInstagramTrait;
```

See the below controller to view the basic flow of sending the user to the Instagram Authorisation screen, receiving the callback and then retrieving the users Instagram acess token. 

This would require two routes to be defined also:

```php
Route::get('/instagram-connect', 'InstagramController@connect')->name('instagram.connect');
Route::get('/instagram/callback', 'InstagramController@callback')->name('instagram.callback');
```

``` php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use RalphMorris\LaravelInstagramFeed\Instagram;

class InstagramController extends Controller
{
	private $instagram;

	public function __construct(Instagram $instagram)
	{
        $this->instagram = $instagram;
	}

    /**
     * Redirect the user to the Instagram auth page
     * 
     * @return Redirect
     */
    public function connect()
    {
    	return redirect($this->instagram->getAuthUrl());
    }

    /**
     * Handles Instagram redirect callback on success/error after the user has confirmed/declined
     * the application to access their account.
     * 
     * @param  Request $request 
     * @return Redirect
     */
    public function callback(Request $request)
    {
        if ($request->error) 
        {
            // handle the error from Instagram in your application
        }

        $data = $this->instagram->retrieveAccessToken($request->code);

        auth()->user()->storeInstagramProfile($data);

        return redirect()->route('home');
    }

}
```

After you have stored your access token in your InstagramProfile model you can get the feed by calling getFeed() on the InstagramProfile instance.

For example:

```php
$feed = auth()->user()->instagram->getFeed();
```

## API Errors

Occassionally I have had exceptions where fetching the last version of the feed has thrown an error. This is usually because the access_token has become invalid, possibly as a result of the applications granted permissions being deleted on the Instagram side. When these exceptions occur they are marked in the database as having had an error and the error message stored for review if needed.

<!-- ### Testing

``` bash
composer test
``` -->

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