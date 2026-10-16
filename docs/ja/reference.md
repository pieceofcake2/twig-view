# 機能リファレンス

pieceofcake2/twig-view で使えるすべての Twig のフィルター、関数、テスト、タグです。

<a id="quick-navigation"></a>

## クイックナビゲーション

- [フィルター](#filters) - 値を変換します: `{{ value|filter }}`
- [関数](#functions) - 値を生成します: `{{ function() }}`
- [テスト](#tests) - 条件をチェックします: `{% if value is test %}`
- [タグ](#tags) - 制御構造です: `{% tag %}`
- [CakePHP のヘルパー](#cakephp-helpers) - ヘルパーにアクセスします: `{{ helper.method() }}`


<a id="filters"></a>

## フィルター

<a id="twig-3x-built-in-filters"></a>

### Twig 3.x の組み込みフィルター

**リファレンス**: https://twig.symfony.com/doc/3.x/filters/index.html

- [`abs`](https://twig.symfony.com/doc/3.x/filters/abs.html)
- [`batch`](https://twig.symfony.com/doc/3.x/filters/batch.html)
- [`capitalize`](https://twig.symfony.com/doc/3.x/filters/capitalize.html)
- [`column`](https://twig.symfony.com/doc/3.x/filters/column.html)
- [`convert_encoding`](https://twig.symfony.com/doc/3.x/filters/convert_encoding.html)
- [`country_name`](https://twig.symfony.com/doc/3.x/filters/country_name.html)
- [`currency_name`](https://twig.symfony.com/doc/3.x/filters/currency_name.html)
- [`currency_symbol`](https://twig.symfony.com/doc/3.x/filters/currency_symbol.html)
- [`data_uri`](https://twig.symfony.com/doc/3.x/filters/data_uri.html)
- [`date`](https://twig.symfony.com/doc/3.x/filters/date.html)
- [`date_modify`](https://twig.symfony.com/doc/3.x/filters/date_modify.html)
- [`default`](https://twig.symfony.com/doc/3.x/filters/default.html)
- [`escape`](https://twig.symfony.com/doc/3.x/filters/escape.html) (エイリアス: `e`)
- [`filter`](https://twig.symfony.com/doc/3.x/filters/filter.html)
- [`find`](https://twig.symfony.com/doc/3.x/filters/find.html)
- [`first`](https://twig.symfony.com/doc/3.x/filters/first.html)
- [`format`](https://twig.symfony.com/doc/3.x/filters/format.html)
- [`format_currency`](https://twig.symfony.com/doc/3.x/filters/format_currency.html)
- [`format_date`](https://twig.symfony.com/doc/3.x/filters/format_date.html)
- [`format_datetime`](https://twig.symfony.com/doc/3.x/filters/format_datetime.html)
- [`format_number`](https://twig.symfony.com/doc/3.x/filters/format_number.html)
- [`format_time`](https://twig.symfony.com/doc/3.x/filters/format_time.html)
- [`html_to_markdown`](https://twig.symfony.com/doc/3.x/filters/html_to_markdown.html)
- [`inline_css`](https://twig.symfony.com/doc/3.x/filters/inline_css.html)
- [`inky_to_html`](https://twig.symfony.com/doc/3.x/filters/inky_to_html.html)
- [`join`](https://twig.symfony.com/doc/3.x/filters/join.html)
- [`json_encode`](https://twig.symfony.com/doc/3.x/filters/json_encode.html)
- [`keys`](https://twig.symfony.com/doc/3.x/filters/keys.html)
- [`language_name`](https://twig.symfony.com/doc/3.x/filters/language_name.html)
- [`last`](https://twig.symfony.com/doc/3.x/filters/last.html)
- [`length`](https://twig.symfony.com/doc/3.x/filters/length.html)
- [`locale_name`](https://twig.symfony.com/doc/3.x/filters/locale_name.html)
- [`lower`](https://twig.symfony.com/doc/3.x/filters/lower.html)
- [`map`](https://twig.symfony.com/doc/3.x/filters/map.html)
- [`markdown_to_html`](https://twig.symfony.com/doc/3.x/filters/markdown_to_html.html)
- [`merge`](https://twig.symfony.com/doc/3.x/filters/merge.html)
- [`nl2br`](https://twig.symfony.com/doc/3.x/filters/nl2br.html)
- [`number_format`](https://twig.symfony.com/doc/3.x/filters/number_format.html)
- [`plural`](https://twig.symfony.com/doc/3.x/filters/plural.html)
- [`raw`](https://twig.symfony.com/doc/3.x/filters/raw.html)
- [`reduce`](https://twig.symfony.com/doc/3.x/filters/reduce.html)
- [`replace`](https://twig.symfony.com/doc/3.x/filters/replace.html)
- [`reverse`](https://twig.symfony.com/doc/3.x/filters/reverse.html)
- [`round`](https://twig.symfony.com/doc/3.x/filters/round.html)
- [`shuffle`](https://twig.symfony.com/doc/3.x/filters/shuffle.html)
- [`singular`](https://twig.symfony.com/doc/3.x/filters/singular.html)
- [`slice`](https://twig.symfony.com/doc/3.x/filters/slice.html)
- [`slug`](https://twig.symfony.com/doc/3.x/filters/slug.html)
- [`sort`](https://twig.symfony.com/doc/3.x/filters/sort.html)
- [`spaceless`](https://twig.symfony.com/doc/3.x/filters/spaceless.html)
- [`split`](https://twig.symfony.com/doc/3.x/filters/split.html)
- [`striptags`](https://twig.symfony.com/doc/3.x/filters/striptags.html)
- [`timezone_name`](https://twig.symfony.com/doc/3.x/filters/timezone_name.html)
- [`title`](https://twig.symfony.com/doc/3.x/filters/title.html)
- [`trim`](https://twig.symfony.com/doc/3.x/filters/trim.html)
- [`u`](https://twig.symfony.com/doc/3.x/filters/u.html)
- [`upper`](https://twig.symfony.com/doc/3.x/filters/upper.html)
- [`url_encode`](https://twig.symfony.com/doc/3.x/filters/url_encode.html)

<a id="string-filters-from-cakephptwig-view"></a>

### 文字列フィルター (cakephp/twig-view 由来)

**実装済み:**
- `tokenize`
- `insert`
- `clean_insert` (エイリアス: `cleanInsert`)
- `wrap`
- `wrap_block` (エイリアス: `wrapBlock`)
- `word_wrap` (エイリアス: `wordWrap`)
- `highlight`
- `tail`
- `truncate`
- `excerpt`
- `to_list` (エイリアス: `toList`)
- `strip_links` (エイリアス: `stripLinks`)

**未実装:**
- `substr` - ❌ 代わりに Twig の組み込みの `slice` フィルターを使ってください

<a id="inflection-filters-from-cakephptwig-view"></a>

### 語形変化フィルター (cakephp/twig-view 由来)

**実装済み:**
- `pluralize`
- `singularize`
- `camelize`
- `underscore`
- `humanize`
- `tableize`
- `classify`
- `variable`
- `slug`

<a id="number-filters-from-cakephptwig-view"></a>

### 数値フィルター (cakephp/twig-view 由来)

**実装済み:**
- `to_readable_size`
- `to_percentage`
- `format_delta` (エイリアス: `formatDelta`)
- `currency`
- `precision`

**未実装:**
- `number_format` - ❌ 代わりに Twig の組み込みの `number_format` フィルターまたは `format_number` フィルターを使ってください

<a id="utility-filters-from-cakephptwig-view"></a>

### ユーティリティフィルター (cakephp/twig-view 由来)

**未実装:**
- `utf8` - ❌ ビューの責務ではありません。コントローラーで適切なエンコーディングのデータを用意してください
- `ascii` - ❌ ビューの責務ではありません。コントローラーで適切なエンコーディングのデータを用意してください
- `low` - ❌ Twig の組み込みの `lower` フィルターを使ってください (後方互換性のため Legacy には残っています)
- `up` - ❌ Twig の組み込みの `upper` フィルターを使ってください (後方互換性のため Legacy には残っています)
- `env` - ❌ ビューの責務ではありません (後方互換性のため Legacy には残っています)
- `serialize` - ❌ ビューの責務ではありません。コントローラーでデータを用意してください
- `unserialize` - ❌ ビューの責務ではありません。コントローラーでデータを用意してください
- `md5` - ❌ ビューの責務ではありません。コントローラーでデータを用意してください
- `base64_encode` - ❌ ビューの責務ではありません。コントローラーでデータを用意してください
- `base64_decode` - ❌ ビューの責務ではありません。コントローラーでデータを用意してください
- `string` - ❌ 不要です。Twig が `__toString()` で自動的に変換します
- `is_multibyte` - ❌ 代わりに `multibyte` テストを使ってください: `{% if text is multibyte %}`

<a id="i18n-filters-pieceofcake2twig-view-original"></a>

### I18n フィルター (pieceofcake2/twig-view 独自)

- `trans`

**CakePHP ベースで、Symfony 風のインターフェイスです**

<a id="legacy-filters-cakephplegacy-twig-view2---️-deprecated"></a>

### レガシーフィルター (cakephp/legacy-twig-view:<2 - ⚠️ 非推奨)

**未実装:**
- `ago` - ❌ `{{ time.timeAgoInWords(date) }}` を使ってください
- `size` - ❌ `to_readable_size` を使ってください
- `p` - ❌ `precision` を使ってください
- `curr` - ❌ `currency` を使ってください
- `pct` - ❌ `to_percentage` を使ってください
- `low` - ❌ Twig の `lower` を使ってください
- `up` - ❌ Twig の `upper` を使ってください
- `debug` - ❌ Twig の `dump()` を使ってください
- `pr` - ❌ Twig の `dump()` を使ってください
- `env` - ❌ コントローラーから渡してください

<a id="functions"></a>

## 関数

<a id="twig-3x-built-in-functions"></a>

### Twig 3.x の組み込み関数

**リファレンス**: https://twig.symfony.com/doc/3.x/functions/index.html

- [`attribute`](https://twig.symfony.com/doc/3.x/functions/attribute.html)
- [`block`](https://twig.symfony.com/doc/3.x/functions/block.html)
- [`constant`](https://twig.symfony.com/doc/3.x/functions/constant.html)
- [`country_names`](https://twig.symfony.com/doc/3.x/functions/country_names.html)
- [`country_timezones`](https://twig.symfony.com/doc/3.x/functions/country_timezones.html)
- [`currency_names`](https://twig.symfony.com/doc/3.x/functions/currency_names.html)
- [`cycle`](https://twig.symfony.com/doc/3.x/functions/cycle.html)
- [`date`](https://twig.symfony.com/doc/3.x/functions/date.html)
- [`dump`](https://twig.symfony.com/doc/3.x/functions/dump.html)
- [`enum`](https://twig.symfony.com/doc/3.x/functions/enum.html)
- [`enum_cases`](https://twig.symfony.com/doc/3.x/functions/enum_cases.html)
- [`html_classes`](https://twig.symfony.com/doc/3.x/functions/html_classes.html)
- [`html_cva`](https://twig.symfony.com/doc/3.x/functions/html_cva.html)
- [`include`](https://twig.symfony.com/doc/3.x/functions/include.html)
- [`language_names`](https://twig.symfony.com/doc/3.x/functions/language_names.html)
- [`locale_names`](https://twig.symfony.com/doc/3.x/functions/locale_names.html)
- [`max`](https://twig.symfony.com/doc/3.x/functions/max.html)
- [`min`](https://twig.symfony.com/doc/3.x/functions/min.html)
- [`parent`](https://twig.symfony.com/doc/3.x/functions/parent.html)
- [`random`](https://twig.symfony.com/doc/3.x/functions/random.html)
- [`range`](https://twig.symfony.com/doc/3.x/functions/range.html)
- [`script_names`](https://twig.symfony.com/doc/3.x/functions/script_names.html)
- [`source`](https://twig.symfony.com/doc/3.x/functions/source.html)
- [`template_from_string`](https://twig.symfony.com/doc/3.x/functions/template_from_string.html)
- [`timezone_names`](https://twig.symfony.com/doc/3.x/functions/timezone_names.html)

<a id="i18n-functions-pieceofcake2twig-view-original"></a>

### I18n 関数 (pieceofcake2/twig-view 独自)

**実装済み:**
- `__`
- `__d`
- `__n`
- `__x`

<a id="number-functions-from-cakephptwig-view"></a>

### 数値関数 (cakephp/twig-view 由来)

**未実装:**
- `default_currency` - ❌ 代わりに `{{ number.defaultCurrency() }}` を使ってください

<a id="view-functions-from-cakephptwig-view"></a>

### ビュー関数 (cakephp/twig-view 由来)

**実装済み:**
- `element`
- `fetch`

**未実装 (cakephp/twig-view の ArraysExtension 由来):**
- `in_array` - ❌ Twig の `in` 演算子を使ってください: `{% if 'foo' in array %}`
- `explode` - ❌ Twig の `split` フィルターを使ってください: `{{ "a,b"|split(',') }}`
- `array` - ❌ ビューの責務ではありません。コントローラーでデータを用意してください
- `array_push` - ❌ Twig の `merge` フィルターを使ってください: `{{ array|merge(['new']) }}`
- `array_prev` - ❌ ビューの責務ではありません。テンプレートでは `loop` 変数を使ってください
- `array_next` - ❌ ビューの責務ではありません。テンプレートでは `loop` 変数を使ってください
- `array_current` - ❌ ビューの責務ではありません。テンプレートでは `loop` 変数を使ってください

**未実装 (cakephp/twig-view の TimeExtension 由来):**
- `time` - ❌ Twig の組み込みの `date` 関数を使ってください
- `timezones` - ❌ ビューの責務ではありません。コントローラーでデータを用意してください

**未実装 (cakephp/twig-view の UtilsExtension 由来):**
- `uuid` - ❌ ビューの責務ではありません。コントローラーまたはモデルで生成してください

<a id="routing-functions-pieceofcake2twig-view-original"></a>

### ルーティング関数 (pieceofcake2/twig-view 独自)

- `url`
- `path`


<a id="tests"></a>

## テスト

<a id="twig-3x-built-in-tests"></a>

### Twig 3.x の組み込みテスト

**リファレンス**: https://twig.symfony.com/doc/3.x/tests/index.html

- [`constant`](https://twig.symfony.com/doc/3.x/tests/constant.html)
- [`defined`](https://twig.symfony.com/doc/3.x/tests/defined.html)
- [`divisible by`](https://twig.symfony.com/doc/3.x/tests/divisibleby.html)
- [`empty`](https://twig.symfony.com/doc/3.x/tests/empty.html)
- [`even`](https://twig.symfony.com/doc/3.x/tests/even.html)
- [`iterable`](https://twig.symfony.com/doc/3.x/tests/iterable.html)
- [`null`](https://twig.symfony.com/doc/3.x/tests/null.html)
- [`odd`](https://twig.symfony.com/doc/3.x/tests/odd.html)
- [`same as`](https://twig.symfony.com/doc/3.x/tests/sameas.html)

<a id="custom-tests-from-cakephptwig-view"></a>

### カスタムテスト (cakephp/twig-view 由来)

**実装済み:**
- `multibyte`


<a id="tags"></a>

## タグ

<a id="twig-3x-built-in-tags"></a>

### Twig 3.x の組み込みタグ

**リファレンス**: https://twig.symfony.com/doc/3.x/tags/index.html

- [`apply`](https://twig.symfony.com/doc/3.x/tags/apply.html)
- [`autoescape`](https://twig.symfony.com/doc/3.x/tags/autoescape.html)
- [`block`](https://twig.symfony.com/doc/3.x/tags/block.html)
- [`cache`](https://twig.symfony.com/doc/3.x/tags/cache.html)
- [`deprecated`](https://twig.symfony.com/doc/3.x/tags/deprecated.html)
- [`do`](https://twig.symfony.com/doc/3.x/tags/do.html)
- [`embed`](https://twig.symfony.com/doc/3.x/tags/embed.html)
- [`extends`](https://twig.symfony.com/doc/3.x/tags/extends.html)
- [`flush`](https://twig.symfony.com/doc/3.x/tags/flush.html)
- [`for`](https://twig.symfony.com/doc/3.x/tags/for.html)
- [`from`](https://twig.symfony.com/doc/3.x/tags/from.html)
- [`guard`](https://twig.symfony.com/doc/3.x/tags/guard.html)
- [`if`](https://twig.symfony.com/doc/3.x/tags/if.html)
- [`import`](https://twig.symfony.com/doc/3.x/tags/import.html)
- [`include`](https://twig.symfony.com/doc/3.x/tags/include.html)
- [`macro`](https://twig.symfony.com/doc/3.x/tags/macro.html)
- [`sandbox`](https://twig.symfony.com/doc/3.x/tags/sandbox.html)
- [`set`](https://twig.symfony.com/doc/3.x/tags/set.html)
- [`types`](https://twig.symfony.com/doc/3.x/tags/types.html)
- [`use`](https://twig.symfony.com/doc/3.x/tags/use.html)
- [`verbatim`](https://twig.symfony.com/doc/3.x/tags/verbatim.html)
- [`with`](https://twig.symfony.com/doc/3.x/tags/with.html)

<a id="custom-tags-from-cakephptwig-view"></a>

### カスタムタグ (cakephp/twig-view 由来)

**実装済み:**
- `{% layout 'name' %}` - レイアウトを設定します

<a id="custom-tags-pieceofcake2twig-view-original"></a>

### カスタムタグ (pieceofcake2/twig-view 独自)

**実装済み:**
- `{% trans %}...{% endtrans %}` - 翻訳ブロック (CakePHP ベースで、Symfony 風)

<a id="legacy-cakephplegacy-twig-view2"></a>

### レガシー (cakephp/legacy-twig-view:<2)

**未実装:**
- `{% element 'name' %}` - ❌ 代わりに `element()` 関数を使ってください

<a id="cakephp-helpers"></a>

## CakePHP のヘルパー

CakePHP のヘルパーを Twig テンプレートで使うには、コントローラーでヘルパーを有効にする必要があります。

**コントローラーで有効にします:** `public $helpers = ['Html', 'Form', 'Time', 'Number', 'Text', 'Session', 'Paginator'];`

**命名:** ヘルパーのクラス名は先頭が小文字の camelBack 形式の変数に変換されます (例: `HtmlHelper::link()` → `{{ html.link() }}`、`MyCustomHelper::method()` → `{{ myCustom.method() }}`)

<a id="flashhelper"></a>

### FlashHelper

フラッシュメッセージを描画します。

- `flash.render(key = 'flash', options = {})` - フラッシュメッセージを描画します

<a id="formhelper"></a>

### FormHelper

フォームを作成し、入力要素を生成します。

- `form.create(model = null, options = {})` - 開始フォームタグを作成します
- `form.end(options = null, secureAttributes = {})` - フォームを閉じます
- `form.input(fieldName, options = {})` - 入力フィールドを生成します
- `form.inputs(fields = null, blacklist = null, options = {})` - 複数の入力要素を生成します
- `form.label(fieldName, text = null, options = {})` - label 要素を作成します
- `form.text(name, options = {})` - テキスト入力を作成します
- `form.password(fieldName, options = {})` - パスワード入力を作成します
- `form.hidden(fieldName, options = {})` - hidden 入力を作成します
- `form.textarea(fieldName, options = {})` - textarea を作成します
- `form.checkbox(fieldName, options = {})` - チェックボックスを作成します
- `form.radio(fieldName, options, attributes = {})` - ラジオボタンを作成します
- `form.select(fieldName, options, attributes = {})` - セレクトボックス (ドロップダウン) を作成します
- `form.file(fieldName, options = {})` - ファイルアップロードの入力を作成します
- `form.submit(caption = null, options = {})` - 送信ボタンを作成します
- `form.button(title, options = {})` - button 要素を作成します
- `form.postButton(title, url, options = {})` - POST ボタンを作成します
- `form.postLink(title, url = null, options = {})` - POST リンクを作成します
- `form.dateTime(fieldName, dateFormat = 'DMY', timeFormat = '12', attributes = {})` - 日付と時刻のセレクトを作成します
- `form.year(fieldName, minYear, maxYear, attributes)` - 年のセレクトを作成します
- `form.month(fieldName, attributes = {})` - 月のセレクトを作成します
- `form.day(fieldName, attributes = {})` - 日のセレクトを作成します
- `form.hour(fieldName, format24 = false, attributes = {})` - 時のセレクトを作成します
- `form.minute(fieldName, attributes = {})` - 分のセレクトを作成します
- `form.meridian(fieldName, attributes = {})` - AM/PM のセレクトを作成します

<a id="htmlhelper"></a>

### HtmlHelper

HTML を生成し、マークアップを作成します。

- `html.charset(charset = null)` - 文字エンコーディングの meta タグ
- `html.css(path, options = {})` - CSS スタイルシートへのリンク
- `html.meta(type, url = null, options = {})` - meta タグを生成します
- `html.docType(type = 'xhtml-strict')` - doctype タグを返します
- `html.style(data, oneline = true)` - 配列から CSS を構築します
- `html.image(path, options = {})` - 画像タグを作成します
- `html.link(title, url = null, options = {})` - HTML のリンクを生成します
- `html.media(path, options)` - audio/video タグを作成します
- `html.tag(tag, text, options)` - テキストを HTML タグで囲みます
- `html.div(class, text, options)` - div 要素を作成します
- `html.para(class, text, options)` - 段落要素を作成します
- `html.script(url, options)` - JavaScript ファイルを読み込みます
- `html.scriptBlock(code, options = {})` - script ブロックを生成します
- `html.scriptStart(options = {})` - スクリプトのバッファリングを開始します
- `html.scriptEnd()` - スクリプトのバッファリングを終了します
- `html.nestedList(list, options = {}, itemOptions = {}, tag = 'ul')` - 入れ子のリストを構築します
- `html.tableHeaders(names, trOptions = null, thOptions = null)` - テーブルのヘッダーを作成します
- `html.tableCells(data, oddTrOptions = null, evenTrOptions = null, useCount = false, continueOddEven = true)` - テーブルのセルを作成します
- `html.url(url = null, full = false)` - URL を生成します

<a id="numberhelper"></a>

### NumberHelper

数値を整形し、変換します。

- `number.currency(number, currency = 'USD', options = {})` - 通貨として整形します
- `number.defaultCurrency(currency)` - デフォルトの通貨を取得または設定します
- `number.addFormat(formatName, options)` - カスタムの通貨フォーマットを追加します
- `number.precision(number, precision = 3)` - 小数点以下の精度を指定して整形します
- `number.toPercentage(number, precision = 2, options = {})` - パーセンテージに変換します
- `number.fromReadableSize(size, default)` - "1 KB" をバイト数に変換します
- `number.toReadableSize(dataSize)` - "1 KB"、"1 MB" などの形式に整形します
- `number.format(number, options = false)` - オプションを指定して数値を整形します
- `number.formatDelta(number, options = {})` - 符号付きの数値の差を整形します

<a id="paginatorhelper"></a>

### PaginatorHelper

ページネーションをサポートします。

- `paginator.options(options = {})` - ページネーションのオプションを設定します
- `paginator.params(model = null)` - ページネーションのパラメータを取得します
- `paginator.param(key, model = null)` - ページネーションのパラメータを 1 つ取得します
- `paginator.url(options = {}, asArray = false, model = null)` - ページネーションの URL を生成します
- `paginator.defaultModel()` - デフォルトのモデルを取得または設定します
- `paginator.link(title, url = {}, options = {})` - ページネーションのリンクを生成します
- `paginator.prev(title = '<< Previous', options = {}, disabledTitle = null, disabledOptions = {})` - 前へのリンク
- `paginator.next(title = 'Next >>', options = {}, disabledTitle = null, disabledOptions = {})` - 次へのリンク
- `paginator.sort(key, title = null, options = {})` - ソートのリンクを生成します
- `paginator.sortDir(model = null, options = {})` - ソートの方向を取得します
- `paginator.sortKey(model = null, options = {})` - ソートのキーを取得します
- `paginator.numbers(options = {})` - ページ番号を生成します
- `paginator.first(first = '<< first', options = {})` - 最初のページへのリンク
- `paginator.last(last = 'last >>', options = {})` - 最後のページへのリンク
- `paginator.counter(options = {})` - ページカウンター (例: "1-20 of 100")
- `paginator.hasNext(model = null)` - 次のページがあるかどうかをチェックします
- `paginator.hasPrev(model = null)` - 前のページがあるかどうかをチェックします
- `paginator.hasPage(model = null, page = 1)` - ページが存在するかどうかをチェックします

詳しい使い方は [CakePHP のヘルパーの使い方](helpers.md) をご覧ください。

<a id="see-also"></a>

## 参照

- [インストール](README.md#installation) - セットアップガイド
- [クイックスタート](README.md#quick-start) - はじめに
- [ヘルパーの使い方](helpers.md) - CakePHP のヘルパーとの統合
- [設定](configuration.md) - 高度な設定オプション
- [エクステンション](extensions.md) - よく使われる Twig エクステンション
