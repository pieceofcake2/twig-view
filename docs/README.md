# TwigView Documentation

pieceofcake2/twig-view integrates the [Twig Templating Language](https://twig.symfony.com/)
(Twig 3.x) with CakePHP 2, providing access to helpers, elements and themes from Twig
templates.

> [!NOTE]
> For CakePHP 5.x, use the official [cakephp/twig-view](https://github.com/cakephp/twig-view) package instead.

- [Installation](#installation)
- [Quick Start](#quick-start)
- [Features](#features)
- [Further Documentation](#further-documentation)
- [Examples](#examples)
- [Fork History](#fork-history)

## Installation

Install the plugin with [Composer](https://getcomposer.org/):

```bash
composer require pieceofcake2/twig-view
```

The plugin has the `cakephp-plugin` type, so it is installed into your plugins directory
by `composer/installers`. Set `installer-paths` in your application's `composer.json` so it
is installed into the right place:

| Layout | `installer-paths` |
| --- | --- |
| Modern (`config/`, `src/`, `templates/`, `plugins/`) | `"plugins/{$name}/": ["type:cakephp-plugin"]` |
| Legacy (`app/Config/`, `app/Plugin/`) | `"app/Plugin/{$name}/": ["type:cakephp-plugin"]` |

Load the plugin in `config/bootstrap.php` (legacy layout: `app/Config/bootstrap.php`):

```php
CakePlugin::load('TwigView');
// or
CakePlugin::loadAll();
```

## Quick Start

Set the view class in `src/Controller/AppController.php` (legacy layout:
`app/Controller/AppController.php`):

```php
class AppController extends Controller
{
    public $viewClass = 'TwigView.Twig';
}
```

Create templates with the `.twig` extension, e.g. `templates/Posts/index.twig` (legacy
layout: `app/View/Posts/index.twig`):

```twig
{% for post in posts %}
    <h2>{{ post.Post.title }}</h2>
    <p>{{ post.Post.body }}</p>
{% endfor %}
```

## Features

- **CakePHP Integration**: Full access to helpers, elements, and themes
- **Custom Extensions**: Extend Twig with custom filters and functions
- **Theme Support**: Compatible with CakePHP's themed views
- **Plugin Support**: Works with both `View/` and `templates/` directories
- **Pre-compilation**: Compile templates for production performance
- **PSR-4 Namespaces**: Modern PHP architecture

## Further Documentation

- **[Function & Filter Reference](reference.md)** - Complete list of available Twig functions and filters
- **[Using Helpers](helpers.md)** - How to use CakePHP helpers in Twig templates
- **[Configuration](configuration.md)** - Advanced configuration options
- **[Extensions](extensions.md)** - Popular Twig extensions

## Examples

Example layouts in Twig:

- [`Layouts/default.twig`](examples/Layouts/default.twig)
- [`Layouts/ajax.twig`](examples/Layouts/ajax.twig)
- [`Layouts/flash.twig`](examples/Layouts/flash.twig)
- [`Layouts/js/default.twig`](examples/Layouts/js/default.twig)
- [`Layouts/rss/default.twig`](examples/Layouts/rss/default.twig)
- [`Layouts/xml/default.twig`](examples/Layouts/xml/default.twig)
- [`Layouts/email/html/default.twig`](examples/Layouts/email/html/default.twig)
- [`Layouts/email/text/default.twig`](examples/Layouts/email/text/default.twig)

## Fork History

This project is based on the following repositories:

1. [m3nt0r-legacy/cakephp-twig-view](https://github.com/m3nt0r-legacy/cakephp-twig-view) - Original implementation by Kjell Bublitz
2. [predominant/TwigView](https://github.com/predominant/TwigView) - Fork by Graham Weldon (archived in 2019) - **Direct fork source**
3. [cakephp/legacy-twig-view](https://github.com/cakephp/legacy-twig-view) - CakePHP community version (formerly WyriHaximus/TwigView, deprecated)
4. **pieceofcake2/twig-view** (this repository) - Modernized fork with Twig 3.x and PHP 8.1+ support

The original repositories supported Twig 1.x with CakePHP 2.x but are no longer maintained.
This fork updates the codebase to work with modern PHP and Twig versions while maintaining
CakePHP 2.x compatibility.

## Origin

This package is a maintained fork of [predominant/TwigView](https://github.com/predominant/TwigView)
(not published on Packagist, last upstream version v0.6), originally by Kjell Bublitz and Graham
Weldon. It is maintained for CakePHP 2 on modern PHP by
[pieceofcake2](https://github.com/pieceofcake2). Changes from the original are listed in
[CHANGELOG.md](https://github.com/pieceofcake2/twig-view/blob/2.x/CHANGELOG.md).
