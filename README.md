# Edit website text/translations inline

[![Latest Version on Packagist](https://img.shields.io/packagist/v/:vendor/:package_slug.svg?style=flat-square)](https://packagist.org/packages/:vendor/:package_slug)
[![Total Downloads](https://img.shields.io/packagist/dt/:vendor/:package_slug.svg?style=flat-square)](https://packagist.org/packages/:vendor/:package_slug)
![GitHub Actions](https://github.com/:vendor/:package_slug/actions/workflows/main.yml/badge.svg)

![img.png](img.png)

This package enables you to edit your websites text and translations inline.

## Installation

You can install the package via composer:

```bash
composer require esign/inline-edit
```

The package will automatically register a service provider.

Next up, you can publish the configuration file:
```bash
php artisan vendor:publish --provider="Esign\InlineEdit\InlineEditServiceProvider" --tag=config --tag=public
```

Publish the InlineEdit file to use it in your frontend.

```bash
php artisan inline-editing:install
```

The file will be copied to ```resources/assets/js/utils/InlineEdit.js```

Add the following to your ``app.js``

```javascript
import InlineEdit from './utils/inlineEdit';

InlineEdit();
```

To use the rich text editor, include de ckeditor cdn before including your ``app.js`` file by adding the following line to your  `app.blade.php` file:

```php
<script src="https://cdn.ckeditor.com/ckeditor5/34.0.0/balloon/ckeditor.js"></script>
```

Make the base url public by adding following line to your ``app.blade.php`` file. 

```php
<script>var base_url = '{{ config('app.url') }}';</script>
```

Make sure you have an accessible csrf token by adding

```php
<meta name="csrf-token" content="{{ csrf_token() }}">
```

Include the inline edit css by adding

```php
<link rel="stylesheet" href="{{ asset('assets/css/inline-edit.css') }}">
```


## Usage

This package assumes you have a translations table in your database with these required columns ``term, type, value``.
The default table is ``dictionary`` but can be changed any other table by changing the specified table in the config file.

You can use the inline editor by calling following function in your blade files

```php
{!! esign_inline('term') !!}
```

Depending on the type of the term the richtext editor will be loaded.
Supported types are `text, richtext`

> **!! IMPORTANT !!**  
> It is important to protect the inline edit routes so only admins can use the functionality.
> **This package does not handle authentication**

You can add a middleware to the config file that handles the authentication.

### Testing

```bash
composer test
```

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
