# TwigView plugin for CakePHP 2

[![GitHub License](https://img.shields.io/github/license/pieceofcake2/twig-view?label=License)](LICENSE)
[![Packagist Version](https://img.shields.io/packagist/v/pieceofcake2/twig-view?label=Packagist)](https://packagist.org/packages/pieceofcake2/twig-view)
![PHP](https://img.shields.io/packagist/dependency-v/pieceofcake2/twig-view/php?logo=php&logoColor=%23FFFFFF&label=PHP&labelColor=%23777BB4&color=%23FFFFFF)
![CakePHP](https://img.shields.io/packagist/dependency-v/pieceofcake2/twig-view/pieceofcake2/cakephp?logo=cakephp&logoColor=%23FFFFFF&label=CakePHP&labelColor=%23D33C43&color=%23FFFFFF)
[![CI](https://img.shields.io/github/actions/workflow/status/pieceofcake2/twig-view/CI.yml?label=CI)](https://github.com/pieceofcake2/twig-view/actions/workflows/CI.yml)
[![Codecov](https://img.shields.io/codecov/c/gh/pieceofcake2/twig-view?label=Coverage)](https://codecov.io/gh/pieceofcake2/twig-view)

**This is forked for CakePHP 2 with Twig 3 support.**

This plugin for the [CakePHP Framework](http://cakephp.org) allows you to use the [Twig Templating Language](https://twig.symfony.com/) for your views.

In addition to enabling the use of most of Twig's features, the plugin is tightly integrated with the CakePHP view renderer giving you full access to helpers, objects and elements.

## Requirements

- PHP 8.0+
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

## Configuration

### Using the View Class

To make CakePHP aware of TwigView, edit your `app/Controller/AppController.php`:

```php
class AppController extends Controller
{
    public $viewClass = 'TwigView.Twig';
}
```

Now start creating view files using the `.twig` extension.

### Custom File Extensions

TwigView supports custom file extensions. By default, it uses `.twig`, but you can set a custom extension:

```php
class AppController extends Controller
{
    public $viewClass = 'TwigView.Twig';
    public $ext = '.html';  // Use .html extension for Twig templates
}
```

**Note**: `.twig` files will work regardless of the `$ext` setting, and `.ctp` files will always use the CakePHP renderer.

### Cache Configuration

By default, Twig caches compiled templates in `app/tmp/views`. You can customize the cache location using Configure:

```php
// In app/Config/bootstrap.php
Configure::write('TwigView.cache', '/custom/cache/path');
```

If not configured, it defaults to `TMP . 'views'`.

### Pre-compiling Templates

For production environments, you can pre-compile all Twig templates to improve performance:

```bash
./Console/cake TwigView.compile all
```

This will compile all `.twig` files in all loaded plugins, generating cached versions for faster rendering.

### Custom Twig Extensions

You can add custom Twig extensions to extend Twig's functionality with your own filters, functions, and more.

```php
// In app/Config/bootstrap.php
Configure::write('TwigView.extensions', [
    'MyCustomTwigExtension',        // Class name as string
    new AnotherTwigExtension(),     // Or instantiated object
]);
```

Example custom extension:

```php
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class MyCustomTwigExtension extends AbstractExtension
{
    public function getFilters(): array
    {
        return [
            new TwigFilter('custom_upper', function ($string) {
                return strtoupper($string);
            }),
        ];
    }
}
```

Then use it in your templates:

```twig
{{ 'hello'|custom_upper }}  {# Outputs: HELLO #}
```

## Default Layouts ##

This plugin comes with all default layouts converted to Twig. Examples can be found in:

```
APP/Plugin/TwigView/examples
```

## Themes ##

The plugin has support for themes and works just like the `Theme` view. Simply add the `$theme` property to your controller and you're set.

```php
class AppController extends Controller
{
    public $viewClass = 'TwigView.Twig';
    public $theme = 'Rockstar';
}
```

This will cause the view to also look in the `Themed` folder for templates. In the above example templates in the following directory are favored over their non-themed version.

```
APP/View/Themed/Rockstar/
```

If you, for example, want to overwrite the `Layouts/default.twig` file in the `Rockstar` theme, then create this file:

```
APP/View/Themed/Rockstar/Layouts/default.twig
```

## Using Helpers inside Templates ##

All helper objects are available inside a view and can be used like any other variable inside Twig.

```twig
{{ time.nice(user.created) }}
```

... where ...

```twig
{{ time.nice(user.created) }}
    ^    ^    ^    ^____key
    |    |    |____array (from $this->set() or loop)
    |    |_____ method
    |______ helper
```

Which is the equivalent of writing:

```php
<?php echo $this->Time->nice($user['created']); ?>
```

A more complex example, FormHelper inputs:

```twig
{{
  form.input('message', {
    'label': 'Your message',
    'error': {
      'notempty': 'Please enter a message'
    }
  })
}}
```

## Referencing View Elements ##

Elements must be `.twig` files and are parsed as Twig templates. Using `.ctp` is not possible.

In exchange for this limitation you can import elements as easy as this:

```twig
{% element 'sidebar/about' %}
```

## Translating Strings ##

The `trans` filter can be used on any string and simply takes the preceding string and passes it through the `__()` function.

```twig
{{
  form.input('email', {
    'label': 'Your E-Mail Address'|trans
  })
}}
```

This is the equivalent of writing:

```php
<?php echo $this->Form->input('email', array(
   'label' => __("Your E-Mail Address")
)); ?>
```

## Translating multiple lines ##

The trans-block element will help you with that. This is especially useful when writing email templates using Twig.

```twig
{% trans %}
Hello!

This is my mail body and i can translate it in X languages now.
We love it!
{% endtrans %}
```

## TwigView Custom Filters ##

This plugin comes with a couple of handy filters, just like 'trans', piping some core CakePHP functions into Twig templates.

### `ago` ###

Shortcut to TimeHelper::timeAgoInWords

```twig
{{ user.created|ago }}
```

### `low` ###

Convert a string to lower case

```twig
{{ 'FOO'|low }}
```

### `up` ###

Convert a string to upper case

```twig
{{ 'foo'|up }}
```

### `debug` ###

Display the debug (pre+print_r) output

```twig
{{ user|debug }}
```

### `pr` ###

Display just the print_r output

```twig
{{ user|pr }}
```

### `env` ###

Display the value from a environment variable

```twig
{{ 'HTTP_HOST'|env }}
```

### `size` ###

Convert byte integer to a human readable size

```twig
{{ '3535839525'|size }}    //=> 3.29 GB
```

### `p` ###

Formats a number with a level of precision.

```twig
{{ '0.555'|p(2) }}    //=> 0.56
```

### `curr` ###

Display floating point value as currency value. USD, GBP and EUR only

```twig
{{ '5999'|curr }}         // default, $5,999.00
{{ '5999'|curr('GBP') }}  // £5,999.00
{{ '5999'|curr('EUR') }}  // €5.999,00
```

### `pct` ###

Formats a number into a percentage string.

```twig
{{ '2.3'|pct }}    //=> 2.30%
```

## Twig Built-In Filters ##

For a list of available filters please refer to the [Twig Manual](https://twig.symfony.com/doc/templates.html#list-of-built-in-filters)

## Accessing View Instance ##

In some cases it is useful to access `$this`, for example to build a DOM id from the current controller and action name.

The object is accessible through `_view`.

```twig
<div class="default" id="{{ _view.name|lower ~ '_' ~ _view.action|lower }}">
```

## Fork History

This project is based on the following repositories:

1. [m3nt0r-legacy/cakephp-twig-view](https://github.com/m3nt0r-legacy/cakephp-twig-view) - Original implementation by Kjell Bublitz
2. [predominant/TwigView](https://github.com/predominant/TwigView) - Fork by Graham Weldon (archived in 2019) - **Direct fork source**
3. [cakephp/legacy-twig-view](https://github.com/cakephp/legacy-twig-view) - CakePHP community version (formerly WyriHaximus/TwigView, deprecated)
4. **pieceofcake2/twig-view** (this repository) - Modernized fork with Twig 3.x and PHP 8.0+ support

The original repositories supported Twig 1.x with CakePHP 2.x but are no longer maintained. This fork updates the codebase to work with modern PHP and Twig versions while maintaining CakePHP 2.x compatibility.
