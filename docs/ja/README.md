# TwigView ドキュメント

pieceofcake2/twig-view は、[Twig テンプレート言語](https://twig.symfony.com/) (Twig 3.x) を CakePHP 2 に統合し、
Twig テンプレートからヘルパー、エレメント、テーマを使えるようにします。

> [!NOTE]
> CakePHP 5.x では、代わりに公式の [cakephp/twig-view](https://github.com/cakephp/twig-view) パッケージを使ってください。

- [インストール](#installation)
- [クイックスタート](#quick-start)
- [機能](#features)
- [その他のドキュメント](#further-documentation)
- [例](#examples)
- [フォークの経緯](#fork-history)

<a id="installation"></a>

## インストール

[Composer](https://getcomposer.org/) でプラグインをインストールします:

```bash
composer require pieceofcake2/twig-view
```

このプラグインは `cakephp-plugin` タイプなので、`composer/installers` によってプラグインディレクトリにインストールされます。
正しい場所にインストールされるよう、アプリケーションの `composer.json` で `installer-paths` を設定してください:

| レイアウト | `installer-paths` |
| --- | --- |
| モダン (`config/`、`src/`、`templates/`、`plugins/`) | `"plugins/{$name}/": ["type:cakephp-plugin"]` |
| レガシー (`app/Config/`、`app/Plugin/`) | `"app/Plugin/{$name}/": ["type:cakephp-plugin"]` |

`config/bootstrap.php` (レガシーレイアウトでは `app/Config/bootstrap.php`) でプラグインを読み込みます:

```php
CakePlugin::load('TwigView');
// or
CakePlugin::loadAll();
```

<a id="quick-start"></a>

## クイックスタート

`src/Controller/AppController.php` (レガシーレイアウトでは `app/Controller/AppController.php`) で
ビュークラスを設定します:

```php
class AppController extends Controller
{
    public $viewClass = 'TwigView.Twig';
}
```

`.twig` 拡張子でテンプレートを作成します。たとえば `templates/Posts/index.twig`
(レガシーレイアウトでは `app/View/Posts/index.twig`) です:

```twig
{% for post in posts %}
    <h2>{{ post.Post.title }}</h2>
    <p>{{ post.Post.body }}</p>
{% endfor %}
```

<a id="features"></a>

## 機能

- **CakePHP との統合**: ヘルパー、エレメント、テーマをすべて使えます
- **カスタムエクステンション**: カスタムのフィルターや関数で Twig を拡張できます
- **テーマのサポート**: CakePHP のテーマ付きビューと互換性があります
- **プラグインのサポート**: `View/` ディレクトリと `templates/` ディレクトリの両方で動作します
- **プリコンパイル**: 本番環境のパフォーマンスのためにテンプレートをコンパイルできます
- **PSR-4 名前空間**: モダンな PHP のアーキテクチャです

<a id="further-documentation"></a>

## その他のドキュメント

- **[関数とフィルターのリファレンス](reference.md)** - 使用できる Twig の関数とフィルターの完全な一覧
- **[ヘルパーの使い方](helpers.md)** - Twig テンプレートで CakePHP のヘルパーを使う方法
- **[設定](configuration.md)** - 高度な設定オプション
- **[エクステンション](extensions.md)** - よく使われる Twig エクステンション

<a id="examples"></a>

## 例

Twig で書いたレイアウトの例:

- [`Layouts/default.twig`](../examples/Layouts/default.twig)
- [`Layouts/ajax.twig`](../examples/Layouts/ajax.twig)
- [`Layouts/flash.twig`](../examples/Layouts/flash.twig)
- [`Layouts/js/default.twig`](../examples/Layouts/js/default.twig)
- [`Layouts/rss/default.twig`](../examples/Layouts/rss/default.twig)
- [`Layouts/xml/default.twig`](../examples/Layouts/xml/default.twig)
- [`Layouts/email/html/default.twig`](../examples/Layouts/email/html/default.twig)
- [`Layouts/email/text/default.twig`](../examples/Layouts/email/text/default.twig)

<a id="fork-history"></a>

## フォークの経緯

このプロジェクトは次のリポジトリをもとにしています:

1. [m3nt0r-legacy/cakephp-twig-view](https://github.com/m3nt0r-legacy/cakephp-twig-view) - Kjell Bublitz によるオリジナルの実装
2. [predominant/TwigView](https://github.com/predominant/TwigView) - Graham Weldon によるフォーク (2019 年にアーカイブ) - **直接のフォーク元**
3. [cakephp/legacy-twig-view](https://github.com/cakephp/legacy-twig-view) - CakePHP コミュニティ版 (旧 WyriHaximus/TwigView、非推奨)
4. **pieceofcake2/twig-view** (このリポジトリ) - Twig 3.x と PHP 8.1+ をサポートする、モダン化したフォーク

オリジナルのリポジトリは CakePHP 2.x で Twig 1.x をサポートしていましたが、もうメンテナンスされていません。
このフォークは、CakePHP 2.x との互換性を保ちながら、モダンな PHP と Twig のバージョンで動作するようにコードベースを更新しています。

<a id="origin"></a>

## 由来

このパッケージは、Kjell Bublitz と Graham Weldon による [predominant/TwigView](https://github.com/predominant/TwigView)
(Packagist では公開されておらず、上流の最後のバージョンは v0.6) をメンテナンスしているフォークです。
[pieceofcake2](https://github.com/pieceofcake2) が、モダンな PHP 上の CakePHP 2 向けにメンテナンスしています。
オリジナルからの変更点は [CHANGELOG.md](https://github.com/pieceofcake2/twig-view/blob/2.x/CHANGELOG.md) に記載されています。
