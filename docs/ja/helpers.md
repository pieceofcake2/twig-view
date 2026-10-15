# CakePHP のヘルパーの使い方

CakePHP のヘルパーを Twig テンプレートで使うには、コントローラーでヘルパーを有効にする必要があります。

<a id="enabling-helpers"></a>

## ヘルパーを有効にする

ヘルパーは **自動的には使えません**。コントローラーで有効にする必要があります。

```php
class PostsController extends AppController
{
    // Enable specific helpers
    public $helpers = ['Html', 'Form', 'Time', 'Number', 'Text', 'Session'];
}
```

または、すべてのコントローラーで使えるように `AppController` で有効にします。

```php
class AppController extends Controller
{
    public $helpers = ['Html', 'Form', 'Time', 'Number', 'Text', 'Session'];
}
```

<a id="how-helpers-work-in-twig"></a>

## Twig でのヘルパーの仕組み

有効にすると、ヘルパークラスには Twig テンプレートから小文字の変数としてアクセスできます。

**命名規約**: "Helper" という接尾辞を取り除き、小文字に変換します。

| ヘルパークラス | Twig の変数 |
|--------------|---------------|
| `HtmlHelper` | `{{ html }}` |
| `FormHelper` | `{{ form }}` |
| `TimeHelper` | `{{ time }}` |
| `NumberHelper` | `{{ number }}` |
| `TextHelper` | `{{ text }}` |
| `SessionHelper` | `{{ session }}` |
| `PaginatorHelper` | `{{ paginator }}` |
| `MyCustomHelper` | `{{ mycustom }}` |

**基本的な使い方:**

```twig
{# Call helper methods #}
{{ html.link('Home', '/') }}
{{ form.input('email') }}
{{ time.timeAgoInWords(date) }}
{{ number.currency(99.99) }}
```

<a id="htmlhelper"></a>

## HtmlHelper

マークアップを作成するための、HTML を生成するヘルパーです。

**有効にする:** `public $helpers = ['Html'];`

<a id="methods"></a>

### メソッド

#### `charset(charset = null)`
ドキュメントの文字エンコーディングを指定する meta タグを作成します。

```twig
{{ html.charset() }}
{{ html.charset('utf-8') }}
```

#### `css(path, options = {})`
CSS スタイルシートへのリンクを作成します。

```twig
{{ html.css('style') }}
{{ html.css(['reset', 'layout']) }}
{{ html.css('print', {media: 'print'}) }}
```

#### `meta(type, url = null, options = {})`
RSS フィード、ファビコン、キーワードなどのリソースの meta タグを生成します。

```twig
{{ html.meta('description', 'My site description') }}
{{ html.meta('keywords', 'cake, php, framework') }}
{{ html.meta('icon', 'favicon.ico') }}
```

#### `docType(type = 'xhtml-strict')`
(X)HTML の doctype タグを返します。

```twig
{{ html.docType() }}
{{ html.docType('html5') }}
```

#### `style(data, oneline = true)`
配列から CSS のスタイル定義を構築します。

```twig
{{ html.style({background: '#fff', color: '#000'}) }}
```

#### `image(path, options = {})`
画像タグを作成します。

```twig
{{ html.image('logo.png') }}
{{ html.image('photo.jpg', {alt: 'Photo', width: 200}) }}
```

#### `link(title, url = null, options = {})`
HTML のリンクを生成します。

```twig
{{ html.link('Home', '/') }}
{{ html.link('View Post', {controller: 'posts', action: 'view', id: 123}) }}
{{ html.link('External', 'https://example.com', {target: '_blank'}) }}
```

#### `media(path, options)`
複数のソースをサポートする audio/video タグを作成します。

```twig
{{ html.media('video.mp4') }}
{{ html.media(['video.mp4', 'video.ogv'], {autoplay: true}) }}
```

#### `tag(tag, text, options)`
指定した HTML タグで囲んだテキストを返します。

```twig
{{ html.tag('span', 'Hello', {class: 'greeting'}) }}
```

#### `div(class, text, options)`
div で囲んだマークアップを作成します。

```twig
{{ html.div('container', content) }}
```

#### `para(class, text, options)`
段落タグで囲んだテキストを返します。

```twig
{{ html.para('intro', 'Welcome text') }}
```

#### `script(url, options)`
JavaScript ファイルを読み込みます。

```twig
{{ html.script('app') }}
{{ html.script(['jquery', 'app']) }}
```

#### `scriptBlock(code, options = {})`
JavaScript のコードを含む script ブロックを生成します。

```twig
{{ html.scriptBlock('alert("Hello");') }}
```

#### `scriptStart(options = {})`
スクリプトのコードブロックのバッファリングを開始します。

```twig
{{ html.scriptStart() }}
```

#### `scriptEnd()`
バッファリングしたスクリプトブロックを終了し、それを返します。

```twig
{{ html.scriptEnd() }}
```

#### `nestedList(list, options = {}, itemOptions = {}, tag = 'ul')`
連想配列から入れ子のリストを構築します。

```twig
{{ html.nestedList(items) }}
{{ html.nestedList(items, {}, {}, 'ol') }}
```

#### `tableHeaders(names, trOptions = null, thOptions = null)`
テーブルのヘッダーセルを作成します。

```twig
{{ html.tableHeaders(['Name', 'Email', 'Actions']) }}
```

#### `tableCells(data, oddTrOptions = null, evenTrOptions = null, useCount = false, continueOddEven = true)`
データの配列からテーブルのセルを作成します。

```twig
{{ html.tableCells(rows) }}
```

#### `url(url = null, full = false)`
指定したオプションの URL を生成します。

```twig
{{ html.url('/posts/view/1') }}
{{ html.url({controller: 'posts', action: 'index'}) }}
{{ html.url({controller: 'posts', action: 'index'}, true) }}
```

<a id="formhelper"></a>

### FormHelper

FormHelper は、フォームとフォームの入力要素を作成するメソッドを提供します。

```twig
{# Create form #}
{{ form.create('User') }}
{{ form.create('Post', {url: {action: 'add'}}) }}

{# Text inputs #}
{{ form.input('username') }}
{{ form.input('email', {type: 'email'}) }}
{{ form.input('password', {type: 'password'}) }}

{# Textareas #}
{{ form.input('body', {type: 'textarea'}) }}

{# Select boxes #}
{{ form.input('category_id', {type: 'select', options: categories}) }}

{# Checkboxes #}
{{ form.input('active', {type: 'checkbox'}) }}

{# Radio buttons #}
{{ form.input('gender', {type: 'radio', options: ['Male', 'Female']}) }}

{# Hidden fields #}
{{ form.hidden('id') }}

{# Submit button #}
{{ form.submit('Save') }}
{{ form.submit('Delete', {confirm: 'Are you sure?'}) }}

{# End form #}
{{ form.end() }}
```

<a id="timehelper"></a>

### TimeHelper

TimeHelper は、日付と時刻を整形するメソッドを提供します。

```twig
{# Format date #}
{{ time.format('Y-m-d', date) }}
{{ time.format('F j, Y', date) }}

{# Nice format #}
{{ time.nice(date) }}
{# Output: Dec 26, 2014, 12:00 AM #}

{# Time ago #}
{{ time.timeAgoInWords(date) }}
{# Output: 2 hours, 10 minutes ago #}

{# Relative time #}
{{ time.fromString('+1 week') }}
{{ time.fromString('next monday') }}

{# Day of week #}
{{ time.dayAsSql(date) }}
```

<a id="numberhelper"></a>

### NumberHelper

NumberHelper は、数値を整形するメソッドを提供します。

```twig
{# Format number #}
{{ number.format(1234.56, 2) }}
{# Output: 1,234.56 #}

{# Currency #}
{{ number.currency(99.99) }}
{# Output: $99.99 #}

{{ number.currency(99.99, 'EUR') }}
{# Output: €99.99 #}

{# Readable size #}
{{ number.toReadableSize(1024) }}
{# Output: 1 KB #}

{{ number.toReadableSize(1048576) }}
{# Output: 1 MB #}

{# Percentage #}
{{ number.toPercentage(0.45) }}
{# Output: 45% #}

{# Precision #}
{{ number.precision(3.14159, 2) }}
{# Output: 3.14 #}

{# Default currency #}
{{ number.defaultCurrency() }}
{# Output: USD #}
```

<a id="texthelper"></a>

### TextHelper

TextHelper は、テキストを操作するメソッドを提供します。

```twig
{# Truncate #}
{{ text.truncate(longText, 100) }}
{{ text.truncate(longText, 100, {ellipsis: '...', exact: false}) }}

{# Auto-link URLs #}
{{ text.autoLink(text) }}
{# Converts URLs and email addresses to clickable links #}

{# Auto-link URLs only #}
{{ text.autoLinkUrls(text) }}

{# Auto-link emails only #}
{{ text.autoLinkEmails(text) }}

{# Highlight #}
{{ text.highlight(text, 'search term', {format: '<span class="highlight">\\1</span>'}) }}

{# Excerpt #}
{{ text.excerpt(text, 'phrase', 100) }}
{# Returns text around the phrase #}

{# To list #}
{{ text.toList(['apple', 'banana', 'orange']) }}
{# Output: apple, banana, and orange #}
```

<a id="sessionhelper"></a>

### SessionHelper

SessionHelper は、セッションデータを読み込むメソッドを提供します。

```twig
{# Read session data #}
{{ session.read('Auth.User.name') }}
{{ session.read('Flash.success') }}

{# Check if session key exists #}
{% if session.check('Auth.User') %}
    User is logged in
{% endif %}

{# Read with default value #}
{{ session.read('Config.theme', 'default') }}
```

<a id="paginatorhelper"></a>

### PaginatorHelper

PaginatorHelper は、ページネーションのためのメソッドを提供します。

```twig
{# Page numbers #}
{{ paginator.numbers() }}

{# Previous/Next links #}
{{ paginator.prev('← Previous') }}
{{ paginator.next('Next →') }}

{# Sort links #}
{{ paginator.sort('Title', 'title') }}
{{ paginator.sort('Created', 'created') }}

{# Counter #}
{{ paginator.counter() }}
{# Output: 1 - 20 of 100 #}

{# Check for pages #}
{% if paginator.hasNext() %}
    {{ paginator.next('Next') }}
{% endif %}

{% if paginator.hasPrev() %}
    {{ paginator.prev('Previous') }}
{% endif %}
```

<a id="jshelper"></a>

### JsHelper

JsHelper は、JavaScript を扱うためのメソッドを提供します。

```twig
{# Link with JavaScript #}
{{ js.link('Click me', {url: '/posts/delete/1', confirm: 'Are you sure?'}) }}

{# Submit form with AJAX #}
{{ js.submit('Save', {url: '/posts/save', update: '#content'}) }}
```

<a id="custom-helpers"></a>

## カスタムヘルパー

独自のカスタムヘルパーも同じように使えます。

```php
// Controller/AppController.php
class AppController extends Controller
{
    public $helpers = ['MyCustom'];
}
```

```twig
{# In Twig template #}
{{ mycustom.myMethod() }}
{{ mycustom.anotherMethod(arg1, arg2) }}
```

<a id="helper-configuration"></a>

## ヘルパーの設定

オプションを指定してヘルパーを設定できます。

```php
// Controller
class PostsController extends AppController
{
    public $helpers = [
        'Html' => ['className' => 'MyHtml'],
        'Paginator' => ['ajax' => 'Js'],
    ];
}
```

設定したヘルパーは、自動的に Twig テンプレートで使えるようになります。

<a id="see-also"></a>

## 参照

- [機能リファレンス](reference.md) - フィルター、関数、テスト、タグの完全な一覧
- [ヘルパー](https://pieceofcake2.github.io/docs/ja/views/helpers.html) ([Markdown](https://github.com/pieceofcake2/docs/blob/2.x/docs/ja/views/helpers.md)) - CakePHP 2 のクックブックのヘルパーの章
