# Panini for FilamentPHP: Craft Your Own CMS idk If It can be called a CMS.

[![Latest Version on Packagist](https://img.shields.io/packagist/v/pratikkuikel/panini.svg?style=flat-square)](https://packagist.org/packages/pratikkuikel/panini)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/pratikkuikel/panini/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/pratikkuikel/panini/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/actions/workflow/status/pratikkuikel/panini/fix-php-code-style-issues.yml?branch=main&label=code%20style&style=flat-square)](https://github.com/pratikkuikel/panini/actions?query=workflow%3A"Fix+PHP+code+style+issues"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/pratikkuikel/panini.svg?style=flat-square)](https://packagist.org/packages/pratikkuikel/panini)

![panini.png](https://i.postimg.cc/NLx7qLGw/panini.png)

<sup> Not an AI generated Logo which has been upscaled and compressed again using AI.</sup>

Panini is a FilamentPHP package designed for developers who crave the freedom to build their own CMS without the constraints of pre-defined structures. It's not a CMS; it's a toolkit that generates Filament resources—Controllers, Factories, Migrations, Seeders, and Models. The star of the show is the Page Manager, allowing you to dynamically generate pages with customizable form fields. Embrace frontend independence and create your unique content management experience, all crafted by you for your project's specific needs. Because sometimes, the best CMS is the one you build yourself.

![wtf](https://media.giphy.com/media/rhUsOoYbRuSw1YmNUI/giphy.gif)

> I honestly don't know what I have built but It does solve my problem and I will be damned if it solves yours too ! 😈

#### why is this called panini ?

Maybe because it's a sandwich and you can build it any way you like.

## Enough with this monologue ! Let's get it up and running

### Before you begin, Make sure you have Filamentphp installed with default AdminPanelProvider.

👉 [Filamentphp Installation](https://filamentphp.com/docs/3.x/panels/installation)

This package assumes that AdminPanelProvider is the default one.

Now you can install the package via composer:

Make sure you have minimum stability set as dev in composer.json

```json
    "minimum-stability": "dev"
```

```bash
composer require pratikkuikel/panini
```

Publish and run the migrations with:

```bash
php artisan vendor:publish --tag="panini-migrations"
php artisan migrate
```

Add Panini Plugin to AdminPanelProvider.

```php
use Pratikkuikel\Panini\PaniniPlugin;

        return $panel
            ...
            ->plugin(new PaniniPlugin())
            ...

```

To enable page auto-discovery change :

```php
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\\Filament\\Pages')
```

TO

```php
            ->discoverPages(in: app_path('Filament/Admin/Pages'), for: 'App\\Filament\\Admin\\Pages')
```

Login to your Admin Panel.

There you have it, your raw panini.

Bake it, chef 👨‍🍳

## Usage

⭐Generate Resources with Resource Generator

![resource_generator.png](https://i.postimg.cc/XqwHWJm7/resource-generator.png)

⭐Page Manager

![page_manager.png](https://i.postimg.cc/LXZvkTtb/page-manager.png)

## Using Page Manager

Page Manager currently supports two Fields right now, Select and TextInput. Feel Free to add More.

Attributes are the methods you chain to the Selected InputField. Multiple attributes is supported.

Multiple fields can be added to the page, All it needs is a click to `Add field to the page` button.

After you have created the page manager, click on `Generate` button to generate the page.

You can customize the generated page, Find the page in `app\Filament\Admin\Pages` directory and the view file in
`resources\views\filament\admin\pages` directory.

The generated fields can be downloaded, reused or shared. <br>
Here is the sample Json Field

```json
[
    {
        "type": "Pratikkuikel\\Panini\\Filament\\Fields\\PaniniTextInput",
        "name": "name",
        "label": "name",
        "attributes": { "required": "true" }
    },
    {
        "type": "Pratikkuikel\\Panini\\Filament\\Fields\\PaniniSelect",
        "name": "option",
        "label": "Option",
        "attributes": { "required": "true" }
    }
]
```

## Fetching the page data

You can fetch the data using

```php
$data = PageManager::where('name','leslie-winkle')->first();
```

Here, [wasabi](https://github.com/pratikkuikel/wasabi) converts your page's data fields into attributes. And those can be accessed using ✅

```php
$data->name
```

Instead of ❌

```php
$data->data['name'];
```

If there's a need to query page's data use [Json Where Clauses](https://laravel.com/docs/10.x/queries#json-where-clauses)

```php
$data = PageManager::where('data->name','robot')->get();
```

## Testing

I beg my pardon, TDD Army !
There are no tests, at least not at the moment.
Will get it done, will I ?

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](.github/CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

-   [Laravel](https://laravel.com)
-   [FilamentPhp](https://filamentphp.com)
-   [Spatie](https://spatie.be)
-   [Touhidurabir](https://github.com/touhidurabir/laravel-stub-generator)
-   [pratikkuikel](https://github.com/pratikkuikel)
-   [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
