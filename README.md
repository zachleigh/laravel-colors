# laravel-colors   
[![Build Status](https://travis-ci.org/zachleigh/laravel-colors.svg?branch=master)](https://travis-ci.org/zachleigh/laravel-colors)
[![Latest Stable Version](https://poser.pugx.org/zachleigh/laravel-colors/version.svg)](//packagist.org/packages/zachleigh/laravel-colors) 
[![License](https://poser.pugx.org/zachleigh/laravel-colors/license.svg)](//packagist.org/packages/zachleigh/laravel-colors)  
##### Build and manage color schemes for Laravel applications.  

![Screenshot](/screenshot.png?raw=true "Screenshot")

### About
laravel-colors allows you to view, create, and edit your project's color scheme in the browser.  It reads the sass file where your color variables are declared and displays these colors in the browser. It also allows you to create and edit color schemes and save them to your database.  
Notes:
  - This package is not able to push color schemes to your actual project. You still must manually set the colors in your css/sass files.
  - Reading your projects color scheme requires that you use sass and that you have a colors file where you declare your sass color variables ($purple: rgb(62, 62, 175); etc.)
  - Currently supports hex color values (#ffffff) and rgb color values (rgb(255, 255, 255))
  - Colors with transparency values are not yet supported so they may display incorrectly

### Installation and Setup
Install through composer:
```
composer require zachleigh/laravel-colors
```

Once installed, register the service provider in your Laravel project.  Because laravel-colors is for development use only, conditionally load the provider in your project's AppServiceProvider register method and import the namespace at the top of the file.
```php
use Illuminate\Support\ServiceProvider;
use LaravelColors\LaravelColorsServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
        //

        if ($this->app->environment('local')) {
            $this->app->register(LaravelColorsServiceProvider::class);
        }
    }
}
```

Next, publish the config file.
```
php artisan vendor:publish --provider="LaravelColors\LaravelColorsServiceProvider" --force
```
This will move the config file to App/config/laravel-colors.php. This file has two values, 'route' and 'sass_file'. 'route' is the url where your project's color scheme can be seen in the browser. The default route is '/laravel-colors/colors'. 'sass_file' is the location of your sass colors file.  This file will be read by laravel-colors. If you do not have a sass file or do not want laravel-colors to attempt to read a file, set 'sass_file' to 'none' and the default color scheme will be used.

The publish command will also put a migration in App/database/migrations/. This migration sets up the database table used to store your color schemes.  Run the migration:
```
php artisan migrate
```

Finished. Now simply visit the route defined in the config file in your browser and see your project's color scheme in all its beautiful glory.
   
### Development
Pull requests are welcome.