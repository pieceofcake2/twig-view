# 設定

<a id="view-class"></a>

## ビュークラス

`src/Controller/AppController.php` (レガシーレイアウトでは `app/Controller/AppController.php`) で、
TwigView をビュークラスとして設定します:

```php
class AppController extends Controller
{
    public $viewClass = 'TwigView.Twig';
}
```

<a id="custom-file-extensions"></a>

## カスタムのファイル拡張子

デフォルトでは、TwigView は `.twig` 拡張子を使います。カスタムの拡張子を設定することもできます:

```php
class AppController extends Controller
{
    public $viewClass = 'TwigView.Twig';
    public $ext = '.html';
}
```

**注意**: `$ext` の設定にかかわらず `.twig` ファイルは常に動作し、`.ctp` ファイルは常に CakePHP のレンダラーを使います。

<a id="cache-configuration"></a>

## キャッシュの設定

デフォルトでは、コンパイルされたテンプレートは `TMP . 'views'` (`tmp/views`、レガシーレイアウトでは
`app/tmp/views`) にキャッシュされます。キャッシュの場所を変更するには次のようにします:

```php
// In config/bootstrap.php (legacy layout: app/Config/bootstrap.php)
Configure::write('TwigView.cache', '/custom/cache/path');
```

<a id="pre-compiling-templates"></a>

## テンプレートのプリコンパイル

本番環境では、すべての Twig テンプレートをプリコンパイルします:

```bash
bin/cake TwigView.compile all

# legacy layout
app/Console/cake TwigView.compile all
```

これにより、レンダリングを速くするためのキャッシュが生成されます。

<a id="custom-twig-extensions"></a>

## カスタム Twig エクステンション

フィルター、関数などのためのカスタム Twig エクステンションを追加します:

```php
// In config/bootstrap.php (legacy layout: app/Config/bootstrap.php)
Configure::write('TwigView.extensions', [
    'MyCustomTwigExtension',
    new AnotherTwigExtension(),
]);
```

エクステンションの例:

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

使い方:

```twig
{{ 'hello'|custom_upper }}  {# Outputs: HELLO #}
```

<a id="theme-support"></a>

## テーマのサポート

コントローラーでテーマを有効にします:

```php
class AppController extends Controller
{
    public $viewClass = 'TwigView.Twig';
    public $theme = 'MyTheme';
}
```

テーマ付きのテンプレートは、まずビューパスの `Themed/MyTheme/` ディレクトリから探されます:

```
templates/Themed/MyTheme/
```

(レガシーレイアウトでは `app/View/Themed/MyTheme/`)。例:

```
templates/Themed/MyTheme/Layouts/default.twig
templates/Themed/MyTheme/Posts/index.twig
```

<a id="plugin-support"></a>

## プラグインのサポート

TwigView は、モダンとレガシーの両方のプラグイン構成をサポートしています:

- **モダン**: プラグインの `templates/`。例: `plugins/MyPlugin/templates/`
- **レガシー**: プラグインの `View/`。例: `app/Plugin/MyPlugin/View/`

テンプレートはまず `templates/` から探され、見つからなければ `View/` から探されます。
