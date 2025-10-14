# Popular Twig Extensions

This document introduces popular third-party Twig extensions that can enhance your templates.

## Installation

Install extensions via Composer, then register them in `app/Config/bootstrap.php`:

```php
Configure::write('TwigView.extensions', [
    'ExtensionClassName',
]);
```

## Twig Extensions

### [twig/intl-extra](https://github.com/twigphp/intl-extra)

Internationalization filters and functions using PHP's intl extension.

```bash
composer require twig/intl-extra
```

```php
Configure::write('TwigView.extensions', [
    new \Twig\Extra\Intl\IntlExtension(),
]);
```

**Features:**

```twig
{# Format currency #}
{{ '1000.50'|format_currency('USD') }}  {# $1,000.50 #}

{# Format numbers #}
{{ '1234.56'|format_number }}  {# 1,234.56 #}

{# Format dates #}
{{ user.created|format_date('long') }}

{# Format datetime #}
{{ user.created|format_datetime('medium', 'short') }}
```

### [twig/string-extra](https://github.com/twigphp/string-extra)

Additional string manipulation filters.

```bash
composer require twig/string-extra
```

```php
Configure::write('TwigView.extensions', [
    new \Twig\Extra\String\StringExtension(),
]);
```

**Features:**

```twig
{# Truncate string #}
{{ 'Lorem ipsum dolor'|u.truncate(10, '...') }}  {# Lorem ipsu... #}

{# Word wrap #}
{{ long_text|u.wordwrap(80) }}

{# Camelcase #}
{{ 'hello world'|u.camel }}  {# helloWorld #}

{# Snake case #}
{{ 'HelloWorld'|u.snake }}  {# hello_world #}

{# ASCII transliteration #}
{{ 'Tëst'|u.ascii }}  {# Test #}
```

### [twig/html-extra](https://github.com/twigphp/html-extra)

HTML manipulation and generation.

```bash
composer require twig/html-extra
```

```php
Configure::write('TwigView.extensions', [
    new \Twig\Extra\Html\HtmlExtension(),
]);
```

**Features:**

```twig
{# Add CSS classes #}
<div class="{{ 'foo'|classes('bar', 'baz') }}">

{# Generate HTML attributes #}
<input {{ html_attributes({type: 'text', name: 'email'}) }}>
```

### [twig/markdown-extra](https://github.com/twigphp/markdown-extra)

Markdown rendering in templates.

```bash
composer require twig/markdown-extra
composer require league/commonmark  # or michelf/php-markdown
```

```php
use Twig\Extra\Markdown\MarkdownExtension;
use Twig\Extra\Markdown\DefaultMarkdown;
use Twig\Extra\Markdown\LeagueMarkdown;

Configure::write('TwigView.extensions', [
    new MarkdownExtension(),
]);
```

**Features:**

```twig
{# Render markdown #}
{{ '**bold** text'|markdown_to_html }}

{# Markdown block #}
{% apply markdown_to_html %}
# Heading
This is **markdown** content.
{% endapply %}
```

### [twig/cssinliner-extra](https://github.com/twigphp/cssinliner-extra)

Inline CSS styles for email templates.

```bash
composer require twig/cssinliner-extra
composer require tijsverkoyen/css-to-inline-styles
```

```php
Configure::write('TwigView.extensions', [
    new \Twig\Extra\CssInliner\CssInlinerExtension(),
]);
```

**Features:**

```twig
{% apply inline_css %}
<html>
<head>
    <style>
        h1 { color: red; }
    </style>
</head>
<body>
    <h1>Hello</h1>
</body>
</html>
{% endapply %}

{# Output: <h1 style="color: red;">Hello</h1> #}
```

### [twig/inky-extra](https://github.com/twigphp/inky-extra)

Foundation for Emails framework integration.

```bash
composer require twig/inky-extra
composer require hampe/inky
```

```php
Configure::write('TwigView.extensions', [
    new \Twig\Extra\Inky\InkyExtension(),
]);
```

**Features:**

```twig
{% apply inky_to_html %}
<row>
    <columns large="6"></columns>
    <columns large="6"></columns>
</row>
{% endapply %}
```

## Third-Party Extensions

### [aptoma/twig-markdown](https://github.com/aptoma/twig-markdown)

Another markdown extension with multiple parser support.

```bash
composer require aptoma/twig-markdown
```

### [jasny/twig-extensions](https://github.com/jasny/twig-extensions)

Collection of useful extensions including date, PCRE, text, and array filters.

> [!NOTE]
> While this extension is used in [cakephp/twig-view](https://github.com/cakephp/twig-view) for CakePHP 5.x, it's recommended to use Twig's built-in features or official Twig Extra extensions when possible for better maintainability and compatibility.

```bash
composer require jasny/twig-extensions
```

**Features:**
- Date manipulation
- PCRE regex functions
- Text formatting
- Array operations

## Creating Custom Extensions

See [Configuration](configuration.md#custom-twig-extensions) for how to create your own extensions.

Example structure:

```php
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;

class MyExtension extends AbstractExtension
{
    public function getFilters(): array
    {
        return [
            new TwigFilter('my_filter', [$this, 'myFilter']),
        ];
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('my_function', [$this, 'myFunction']),
        ];
    }

    public function myFilter($value)
    {
        return strtoupper($value);
    }

    public function myFunction($arg)
    {
        return "Result: " . $arg;
    }
}
```

## Resources

- [Official Twig Extensions](https://github.com/twigphp) - Maintained by Twig team
- [Twig Documentation](https://twig.symfony.com/doc/3.x/) - Complete Twig reference
- [Creating Extensions](https://twig.symfony.com/doc/3.x/advanced.html#creating-an-extension) - Official guide