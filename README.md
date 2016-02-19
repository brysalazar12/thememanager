# thememanager
Laravel 5 Theme Manager

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


