# thememanager
Laravel 5 Theme Manager

[![Supported Laravel Version](https://img.shields.io/badge/Laravel-5.1.*|5.2.*-blue.svg)](#)
[![Latest Stable Version](https://poser.pugx.org/brysalazar12/thememanager/v/stable)](https://packagist.org/packages/brysalazar12/thememanager) [![Total Downloads](https://poser.pugx.org/brysalazar12/thememanager/downloads)](https://packagist.org/packages/brysalazar12/thememanager) [![Latest Unstable Version](https://poser.pugx.org/brysalazar12/thememanager/v/unstable)](https://packagist.org/packages/brysalazar12/thememanager) [![License](https://poser.pugx.org/brysalazar12/thememanager/license)](https://packagist.org/packages/brysalazar12/thememanager)
[![SensioLabsInsight](https://insight.sensiolabs.com/projects/fb9facad-f326-4101-9b18-27ddce03c115/small.png)](https://insight.sensiolabs.com/projects/fb9facad-f326-4101-9b18-27ddce03c115)

[![GitHub issues](https://img.shields.io/github/issues/brysalazar12/thememanager.svg)](https://github.com/brysalazar12/thememanager/issues)
[![Percentage of issues still open](http://isitmaintained.com/badge/open/brysalazar12/thememanager.svg)](http://isitmaintained.com/project/brysalazar12/thememanager "Percentage of issues still open")
[![StyleCI](https://styleci.io/repos/51733841/shield)](https://styleci.io/repos/51733841)

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

By default the theme path is located in **resources/themes**

Folder structure
```
resources
	└── themes
		└── [backend] -> group_name
			└── [bootstrap] -> theme_name
					└── views
					└── assets
		└── [frontend]
			└── [foundation]
					└── views
					└── assets
			
public
	└──themes
		└── [backend]
			└── [bootstrap]
					└── assets
```			

Add this to composer.json to automatically install your theme in **resources/themes/{$name}**
```json
    "extra": {
		"installer-types": ["laravel-theme"],
		"installer-paths": {
		  "resources/themes/{$name}/": ["type:laravel-theme"]
		}
    },
```

If you are theme author use this template in you composer
```json
    {
    	"name": "your composer/theme name",
    	"type": "laravel-theme",
    	"extra": {
    		"installer-name": "admin"
    	}
    }
```
    
It will be installed in **resources/themes/admin**
