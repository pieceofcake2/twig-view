# Configuration

## View Class

Set TwigView as your view class in `app/Controller/AppController.php`:

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

By default, compiled templates are cached in `app/tmp/views`. Customize the cache location:

```php
// In app/Config/bootstrap.php
Configure::write('TwigView.cache', '/custom/cache/path');
```

## Pre-compiling Templates

For production, pre-compile all Twig templates:

```bash
./Console/cake TwigView.compile all
```

This generates cached versions for faster rendering.

## Custom Twig Extensions

Add custom Twig extensions for filters, functions, and more:

```php
// In app/Config/bootstrap.php
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

Themed templates are searched in:

```
app/View/Themed/MyTheme/
```

Example:

```
app/View/Themed/MyTheme/Layouts/default.twig
app/View/Themed/MyTheme/Posts/index.twig
```

## Plugin Support

TwigView supports both modern and legacy plugin structures:

- **Modern**: `Plugin/MyPlugin/templates/`
- **Legacy**: `Plugin/MyPlugin/View/`

Templates are searched in `templates/` first, then falls back to `View/`.