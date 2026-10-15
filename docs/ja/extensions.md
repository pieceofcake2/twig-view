# よく使われる Twig エクステンション

このドキュメントでは、テンプレートを強化できる、よく使われるサードパーティーの Twig エクステンションを紹介します。

<a id="installation"></a>

## インストール

Composer でエクステンションをインストールし、`config/bootstrap.php` (レガシーレイアウトでは
`app/Config/bootstrap.php`) で登録します:

```php
Configure::write('TwigView.extensions', [
    'ExtensionClassName',
]);
```

<a id="twig-extensions"></a>

## Twig エクステンション

<a id="twigintl-extra"></a>

### [twig/intl-extra](https://github.com/twigphp/intl-extra)

PHP の intl 拡張モジュールを使った国際化のフィルターと関数です。

```bash
composer require twig/intl-extra
```

```php
use Twig\Extra\Intl\IntlExtension;

Configure::write('TwigView.extensions', [
    new IntlExtension(),
]);
```

**機能:**

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

<a id="twigstring-extra"></a>

### [twig/string-extra](https://github.com/twigphp/string-extra)

文字列を操作する追加のフィルターです。

```bash
composer require twig/string-extra
```

```php
use Twig\Extra\String\StringExtension;

Configure::write('TwigView.extensions', [
    new StringExtension(),
]);
```

**機能:**

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

<a id="twightml-extra"></a>

### [twig/html-extra](https://github.com/twigphp/html-extra)

HTML の操作と生成です。

```bash
composer require twig/html-extra
```

```php
use Twig\Extra\Html\HtmlExtension;

Configure::write('TwigView.extensions', [
    new HtmlExtension(),
]);
```

**機能:**

```twig
{# Add CSS classes #}
<div class="{{ 'foo'|classes('bar', 'baz') }}">

{# Generate HTML attributes #}
<input {{ html_attributes({type: 'text', name: 'email'}) }}>
```

<a id="twigmarkdown-extra"></a>

### [twig/markdown-extra](https://github.com/twigphp/markdown-extra)

テンプレートでの Markdown のレンダリングです。

```bash
composer require twig/markdown-extra
composer require league/commonmark  # or michelf/php-markdown
```

```php
use Twig\Extra\Markdown\MarkdownExtension;

Configure::write('TwigView.extensions', [
    new MarkdownExtension(),
]);
```

**機能:**

```twig
{# Render markdown #}
{{ '**bold** text'|markdown_to_html }}

{# Markdown block #}
{% apply markdown_to_html %}
# Heading
This is **markdown** content.
{% endapply %}
```

<a id="twigcssinliner-extra"></a>

### [twig/cssinliner-extra](https://github.com/twigphp/cssinliner-extra)

メールテンプレート用に CSS のスタイルをインライン化します。

```bash
composer require twig/cssinliner-extra
composer require tijsverkoyen/css-to-inline-styles
```

```php
use Twig\Extra\CssInliner\CssInlinerExtension;

Configure::write('TwigView.extensions', [
    new CssInlinerExtension(),
]);
```

**機能:**

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

<a id="twiginky-extra"></a>

### [twig/inky-extra](https://github.com/twigphp/inky-extra)

Foundation for Emails フレームワークとの統合です。

```bash
composer require twig/inky-extra
composer require hampe/inky
```

```php
use Twig\Extra\Inky\InkyExtension;

Configure::write('TwigView.extensions', [
    new InkyExtension(),
]);
```

**機能:**

```twig
{% apply inky_to_html %}
<row>
    <columns large="6"></columns>
    <columns large="6"></columns>
</row>
{% endapply %}
```

<a id="third-party-extensions"></a>

## サードパーティーのエクステンション

<a id="aptomatwig-markdown"></a>

### [aptoma/twig-markdown](https://github.com/aptoma/twig-markdown)

複数のパーサーをサポートする、もう 1 つの Markdown エクステンションです。

```bash
composer require aptoma/twig-markdown
```

<a id="jasnytwig-extensions"></a>

### [jasny/twig-extensions](https://github.com/jasny/twig-extensions)

日付、PCRE、テキスト、配列のフィルターなど、便利なエクステンションを集めたものです。

> [!NOTE]
> このエクステンションは CakePHP 5.x 向けの [cakephp/twig-view](https://github.com/cakephp/twig-view) で使われていますが、保守性と互換性のため、できるだけ Twig の組み込み機能や公式の Twig Extra エクステンションを使うことをお勧めします。

```bash
composer require jasny/twig-extensions
```

**機能:**
- 日付の操作
- PCRE の正規表現関数
- テキストの整形
- 配列の操作

<a id="creating-custom-extensions"></a>

## カスタムエクステンションの作成

独自のエクステンションを作成する方法は [設定](configuration.md#custom-twig-extensions) を参照してください。

構成の例:

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
        return 'Result: ' . $arg;
    }
}
```

<a id="resources"></a>

## リソース

- [公式の Twig エクステンション](https://github.com/twigphp) - Twig チームがメンテナンスしています
- [Twig のドキュメント](https://twig.symfony.com/doc/3.x/) - Twig の完全なリファレンス
- [エクステンションの作成](https://twig.symfony.com/doc/3.x/advanced.html#creating-an-extension) - 公式ガイド
