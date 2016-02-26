# thememanager
Laravel 5 Theme Manager
[![Latest Stable Version](https://poser.pugx.org/mailgun/mailgun-php/v/stable.png)](https://packagist.org/packages/brysalazar12/thememanager)
[![Downloads](https://poser.pugx.org/pugx/badge-poser/d/total.svg)](https://packagist.org/packages/brysalazar12/thememanager)

Via Composer
```
composer require brysalazar12/thememanager
composer update
```

Add Service Provider to `config/app.php` in `providers` section
```php
'providers' => [
    // ...
    Mirage\ThemeManager\ThemeManagerServiceProvider::class,
    // ...
]
```

Add Facade to `config/app.php` in `aliases` section
```php
'aliases' => [
    // ...
    'Theme'		=> Mirage\ThemeManager\Facades\ThemeFacade::class,
    // ...
]
```

If you want static configuration you can run
```php
artisan vendor:publish
```
Check the **config/theme.php** for configuration

If you want dynamic you can use
```php
Theme::set('theme_name','group_name')->override();
```

Dynamic approach can override the static approach

By default the theme path is located in resources/themes


