# TwigView plugin for CakePHP 2

[![GitHub License](https://img.shields.io/github/license/pieceofcake2/twig-view?label=License)](LICENSE)
[![Packagist Version](https://img.shields.io/packagist/v/pieceofcake2/twig-view?label=Packagist)](https://packagist.org/packages/pieceofcake2/twig-view)
![PHP](https://img.shields.io/packagist/dependency-v/pieceofcake2/twig-view/php?logo=php&logoColor=%23FFFFFF&label=PHP&labelColor=%23777bb4&color=%23ffffff)
![CakePHP](https://img.shields.io/packagist/dependency-v/pieceofcake2/twig-view/pieceofcake2/cakephp?logo=cakephp&logoColor=%23ffffff&label=CakePHP&labelColor=%23D33C43&color=%23ffffff)
![Twig](https://img.shields.io/packagist/dependency-v/pieceofcake2/twig-view/twig%2Ftwig?logo=data%3Aimage%2Fsvg%2Bxml%3Bbase64%2CPHN2ZyB3aWR0aD0iMTIiIGhlaWdodD0iMTIiIHZpZXdCb3g9IjAgMCAxMiAxMiIgZmlsbD0ibm9uZSIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj48ZyBjbGlwLXBhdGg9InVybCgjY2xpcDBfMV8xMCkiPjxwYXRoIGQ9Ik0zLjI3MjcxIDAuNzcxNDg0QzQuNzUyMjkgMC41MzM3OCA2LjA5MDU5IDIuNDIxMDcgNi40NzY4MSAyLjk2Mjg5QzcuMTg1NTkgMy45NzY0NyA3LjYyMTQzIDUuMTU1NjQgNy43NDA0OCA2LjM4NjcyQzcuNzI4MDYgNi40MDQwOSA3LjcxNTU0IDYuNDIxOTIgNy43MDMzNyA2LjQzOTQ1QzguMzc2NTIgNS41NTkxNCA5LjQyMzIyIDQuODcwNzcgMTAuMjAzNCA1LjE4OTQ1QzExLjAxNjIgNS41MjE3OCAxMS4yMTggNi44MTE4MyAxMS4xNTM2IDYuODUwNTlDMTEuMDk3NyA2Ljg3OTQ2IDEwLjgxNzQgNi4wMjI5MSAxMC4yNjc4IDUuOTc0NjFDOS43ODM3MSA1LjkzMjY0IDkuMzcyOTEgNi41NjE0OCA5LjMwMDA1IDYuNjcyODVDOS4wMDAwNSA3LjEyODQ4IDguOTI2OTEgNy42MjAwMyA4Ljk2MjE2IDguODMyMDNDOC45ODY4MiA5LjY0MDUgOS4wNDk0MSAxMC40NDc0IDkuMTQ5NjYgMTEuMjVMNi42OTA2NyAxMS4yNTFWMTEuMjVIMy44OTQ3OEMzLjkzMzc4IDEwLjY3MTkgMy45MTE5OSAxMC4wOTExIDMuODI5MzUgOS41MTc1OEMzLjc1ODA5IDguNTU4NDkgMy40Mzk3MSA3LjYzNDM3IDIuOTA2NDkgNi44MzM5OEMyLjAzOTg3IDUuNjg1MzYgMC43NzA0ODYgNS40Mzc0NiAwLjgzOTExMSA1LjIyNTU5QzAuODk0NTEzIDUuMDU4NDEgMS43NjQ4NyA1LjEyOTE1IDIuNTQxMjYgNS4zMzU5NEMzLjE2NDU5IDUuNTAxOTkgNC4xMTg3OCA1LjgzNzExIDUuMjAxNDIgNi43MzI0MkM0Ljg4NzgxIDMuMDA1NzQgNC4xNTY2MiAxLjc4OTk5IDMuMzg1MDEgMS42MTMyOEMyLjY1MjU3IDEuNDQ2MSAxLjgxMzcxIDIuMTk4MjQgMS43MTUwOSAyLjA0ODgzQzEuNjEyMzQgMS44OTU0NSAyLjMxODcxIDAuOTI0NDg0IDMuMjcyNzEgMC43NzE0ODRaIiBmaWxsPSJ3aGl0ZSIvPjwvZz48L3N2Zz4%3D&label=Twig&labelColor=%237fa020&color=%23ffffff)
[![CI](https://img.shields.io/github/actions/workflow/status/pieceofcake2/twig-view/CI.yml?label=CI)](https://github.com/pieceofcake2/twig-view/actions/workflows/CI.yml)
[![Codecov](https://img.shields.io/codecov/c/gh/pieceofcake2/twig-view?label=Coverage)](https://codecov.io/gh/pieceofcake2/twig-view)

Modern Twig 3.x support for CakePHP 2.x with PSR-4 namespaces and PHP 8.1+.

This plugin integrates the [Twig Templating Language](https://twig.symfony.com/) with [CakePHP 2](https://book.cakephp.org/2.0/en/), providing access to helpers, elements, and themes.

> [!NOTE]
> For CakePHP 5.x, use the official [cakephp/twig-view](https://github.com/cakephp/twig-view) package instead.

## Requirements

- PHP 8.1+
- CakePHP 2.12+
- Twig 3.x

## Installation

Install via Composer:

```bash
composer require pieceofcake2/twig-view
```

Load the plugin in your `app/Config/bootstrap.php`:

```php
CakePlugin::load('TwigView');
// or
CakePlugin::loadAll();
```

## Quick Start

Set the view class in your `app/Controller/AppController.php`:

```php
class AppController extends Controller
{
    public $viewClass = 'TwigView.Twig';
}
```

Create templates with `.twig` extension:

```twig
{# app/View/Posts/index.twig #}
{% for post in posts %}
    <h2>{{ post.Post.title }}</h2>
    <p>{{ post.Post.body }}</p>
{% endfor %}
```

## Documentation

- **[Function & Filter Reference](docs/reference.md)** - Complete list of available Twig functions and filters
- **[Using Helpers](docs/helpers.md)** - How to use CakePHP helpers in Twig templates
- **[Configuration](docs/configuration.md)** - Advanced configuration options
- **[Extensions](docs/extensions.md)** - Popular Twig extensions
- **[Examples](examples/)** - Example layouts and templates

## Features

- **CakePHP Integration**: Full access to helpers, elements, and themes
- **Custom Extensions**: Extend Twig with custom filters and functions
- **Theme Support**: Compatible with CakePHP's themed views
- **Plugin Support**: Works with both `View/` and `templates/` directories
- **Pre-compilation**: Compile templates for production performance
- **PSR-4 Namespaces**: Modern PHP architecture

## Fork History

This project is based on the following repositories:

1. [m3nt0r-legacy/cakephp-twig-view](https://github.com/m3nt0r-legacy/cakephp-twig-view) - Original implementation by Kjell Bublitz
2. [predominant/TwigView](https://github.com/predominant/TwigView) - Fork by Graham Weldon (archived in 2019) - **Direct fork source**
3. [cakephp/legacy-twig-view](https://github.com/cakephp/legacy-twig-view) - CakePHP community version (formerly WyriHaximus/TwigView, deprecated)
4. **pieceofcake2/twig-view** (this repository) - Modernized fork with Twig 3.x and PHP 8.1+ support

The original repositories supported Twig 1.x with CakePHP 2.x but are no longer maintained. This fork updates the codebase to work with modern PHP and Twig versions while maintaining CakePHP 2.x compatibility.
