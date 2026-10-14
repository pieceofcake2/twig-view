# Configuration

## View Class

Set TwigView as your view class in `src/Controller/AppController.php` (legacy layout:
`app/Controller/AppController.php`):

```php
class AppController extends Controller
{
    public $viewClass = 'TwigView.Twig';
}
```

## Custom File Extensions

By default, TwigView uses `.twig` extension. You can set a custom extension:

```php
class AppController extends Controller
{
    public $viewClass = 'TwigView.Twig';
    public $ext = '.html';
}
```

**Note**: `.twig` files will always work regardless of `$ext` setting, and `.ctp` files always use the CakePHP renderer.

## Cache Configuration

By default, compiled templates are cached in `TMP . 'views'` (`tmp/views`, legacy layout:
`app/tmp/views`). Customize the cache location:

```php
// In config/bootstrap.php (legacy layout: app/Config/bootstrap.php)
Configure::write('TwigView.cache', '/custom/cache/path');
```

## Pre-compiling Templates

For production, pre-compile all Twig templates:

```bash
bin/cake TwigView.compile all

# legacy layout
app/Console/cake TwigView.compile all
```

This generates cached versions for faster rendering.

## Custom Twig Extensions

Add custom Twig extensions for filters, functions, and more:

```php
// In config/bootstrap.php (legacy layout: app/Config/bootstrap.php)
Configure::write('TwigView.extensions', [
    'MyCustomTwigExtension',
    new AnotherTwigExtension(),
]);
```

Example extension:

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

Usage:

```twig
{{ 'hello'|custom_upper }}  {# Outputs: HELLO #}
```

## Theme Support

Enable themes in your controller:

```php
class AppController extends Controller
{
    public $viewClass = 'TwigView.Twig';
    public $theme = 'MyTheme';
}
```

Themed templates are searched in the `Themed/MyTheme/` directory of your view paths first:

```
templates/Themed/MyTheme/
```

(legacy layout: `app/View/Themed/MyTheme/`). Example:

```
templates/Themed/MyTheme/Layouts/default.twig
templates/Themed/MyTheme/Posts/index.twig
```

## Plugin Support

TwigView supports both modern and legacy plugin structures:

- **Modern**: `templates/` of the plugin, e.g. `plugins/MyPlugin/templates/`
- **Legacy**: `View/` of the plugin, e.g. `app/Plugin/MyPlugin/View/`

Templates are searched in `templates/` first, then fall back to `View/`.