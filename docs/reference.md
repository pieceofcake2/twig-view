# Complete Feature Reference

All available Twig filters, functions, tests, and tags in pieceofcake2/twig-view.

## Quick Navigation

- [Filters](#filters) - Transform values: `{{ value|filter }}`
- [Functions](#functions) - Generate values: `{{ function() }}`
- [Tests](#tests) - Check conditions: `{% if value is test %}`
- [Tags](#tags) - Control structures: `{% tag %}`
- [CakePHP Helpers](#cakephp-helpers) - Access helpers: `{{ helper.method() }}`


## Filters

### Twig 3.x Built-in Filters

**Reference**: https://twig.symfony.com/doc/3.x/filters/index.html

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
- [`escape`](https://twig.symfony.com/doc/3.x/filters/escape.html) (alias: `e`)
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

### String Filters (from cakephp/twig-view)

**Implemented:**
- `tokenize`
- `insert`
- `clean_insert` (alias: `cleanInsert`)
- `wrap`
- `wrap_block` (alias: `wrapBlock`)
- `word_wrap` (alias: `wordWrap`)
- `highlight`
- `tail`
- `truncate`
- `excerpt`
- `to_list` (alias: `toList`)
- `strip_links` (alias: `stripLinks`)

**Not Implemented:**
- `substr` - ❌ Use Twig's built-in `slice` filter instead

### Inflection Filters (from cakephp/twig-view)

**Implemented:**
- `pluralize`
- `singularize`
- `camelize`
- `underscore`
- `humanize`
- `tableize`
- `classify`
- `variable`
- `slug`

### Number Filters (from cakephp/twig-view)

**Implemented:**
- `to_readable_size`
- `to_percentage`
- `format_delta` (alias: `formatDelta`)
- `currency`
- `precision`

**Not Implemented:**
- `number_format` - ❌ Use Twig's built-in `number_format` or `format_number` filter instead

### Utility Filters (from cakephp/twig-view)

**Not Implemented:**
- `utf8` - ❌ Not a view concern, prepare data in controller with proper encoding
- `ascii` - ❌ Not a view concern, prepare data in controller with proper encoding
- `low` - ❌ Use Twig's built-in `lower` filter (kept in Legacy for backward compatibility)
- `up` - ❌ Use Twig's built-in `upper` filter (kept in Legacy for backward compatibility)
- `env` - ❌ Not a view concern (kept in Legacy for backward compatibility)
- `serialize` - ❌ Not a view concern, prepare data in controller
- `unserialize` - ❌ Not a view concern, prepare data in controller
- `md5` - ❌ Not a view concern, prepare data in controller
- `base64_encode` - ❌ Not a view concern, prepare data in controller
- `base64_decode` - ❌ Not a view concern, prepare data in controller
- `string` - ❌ Not needed, Twig auto-converts with `__toString()`
- `is_multibyte` - ❌ Use `multibyte` test instead: `{% if text is multibyte %}`

### I18n Filters (pieceofcake2/twig-view original)

- `trans`

**CakePHP-based, Symfony-like interface**

### Legacy Filters (cakephp/legacy-twig-view:<2 - ⚠️ DEPRECATED)

**Not Implemented:**
- `ago` - ❌ Use `{{ time.timeAgoInWords(date) }}`
- `size` - ❌ Use `to_readable_size`
- `p` - ❌ Use `precision`
- `curr` - ❌ Use `currency`
- `pct` - ❌ Use `to_percentage`
- `low` - ❌ Use Twig's `lower`
- `up` - ❌ Use Twig's `upper`
- `debug` - ❌ Use Twig's `dump()`
- `pr` - ❌ Use Twig's `dump()`
- `env` - ❌ Pass from controller

See [Legacy Features](legacy.md) for migration guide.

## Functions

### Twig 3.x Built-in Functions

**Reference**: https://twig.symfony.com/doc/3.x/functions/index.html

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

### I18n Functions (pieceofcake2/twig-view original)

**Implemented:**
- `__`
- `__d`
- `__n`
- `__x`

### Number Functions (from cakephp/twig-view)

**Not Implemented:**
- `default_currency` - ❌ Use `{{ number.defaultCurrency() }}` instead

### View Functions (from cakephp/twig-view)

**Implemented:**
- `element`
- `fetch`

**Not Implemented (from cakephp/twig-view ArraysExtension):**
- `in_array` - ❌ Use Twig's `in` operator: `{% if 'foo' in array %}`
- `explode` - ❌ Use Twig's `split` filter: `{{ "a,b"|split(',') }}`
- `array` - ❌ Not a view concern, prepare data in controller
- `array_push` - ❌ Use Twig's `merge` filter: `{{ array|merge(['new']) }}`
- `array_prev` - ❌ Not a view concern, use `loop` variable in templates
- `array_next` - ❌ Not a view concern, use `loop` variable in templates
- `array_current` - ❌ Not a view concern, use `loop` variable in templates

**Not Implemented (from cakephp/twig-view TimeExtension):**
- `time` - ❌ Use Twig's built-in `date` function
- `timezones` - ❌ Not a view concern, prepare data in controller

**Not Implemented (from cakephp/twig-view UtilsExtension):**
- `uuid` - ❌ Not a view concern, generate in controller/model

### Routing Functions (pieceofcake2/twig-view original)

- `url`
- `path`


## Tests

### Twig 3.x Built-in Tests

**Reference**: https://twig.symfony.com/doc/3.x/tests/index.html

- [`constant`](https://twig.symfony.com/doc/3.x/tests/constant.html)
- [`defined`](https://twig.symfony.com/doc/3.x/tests/defined.html)
- [`divisible by`](https://twig.symfony.com/doc/3.x/tests/divisibleby.html)
- [`empty`](https://twig.symfony.com/doc/3.x/tests/empty.html)
- [`even`](https://twig.symfony.com/doc/3.x/tests/even.html)
- [`iterable`](https://twig.symfony.com/doc/3.x/tests/iterable.html)
- [`null`](https://twig.symfony.com/doc/3.x/tests/null.html)
- [`odd`](https://twig.symfony.com/doc/3.x/tests/odd.html)
- [`same as`](https://twig.symfony.com/doc/3.x/tests/sameas.html)

### Custom Tests (from cakephp/twig-view)

**Implemented:**
- `multibyte`


## Tags

### Twig 3.x Built-in Tags

**Reference**: https://twig.symfony.com/doc/3.x/tags/index.html

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

### Custom Tags (from cakephp/twig-view)

**Implemented:**
- `{% layout 'name' %}` - Set layout

### Custom Tags (pieceofcake2/twig-view original)

**Implemented:**
- `{% trans %}...{% endtrans %}` - Translation block (CakePHP-based, Symfony-like)

### Legacy (cakephp/legacy-twig-view:<2)

**Not Implemented:**
- `{% element 'name' %}` - ❌ Use `element()` function instead

## CakePHP Helpers

CakePHP Helpers must be enabled in your controller to be available in Twig templates.

**Enable in controller:** `public $helpers = ['Html', 'Form', 'Time', 'Number', 'Text', 'Session', 'Paginator'];`

**Naming:** Helper class names are converted to lowercase (e.g., `HtmlHelper::link()` → `{{ html.link() }}`, `MyCustomHelper::method()` → `{{ mycustom.method() }}`)

### FlashHelper

Flash message rendering.

- `flash.render(key = 'flash', options = {})` - Render flash message

### FormHelper

Form creation and input generation.

- `form.create(model = null, options = {})` - Create opening form tag
- `form.end(options = null, secureAttributes = {})` - Close form
- `form.input(fieldName, options = {})` - Generate input field
- `form.inputs(fields = null, blacklist = null, options = {})` - Generate multiple inputs
- `form.label(fieldName, text = null, options = {})` - Create label element
- `form.text(name, options = {})` - Create text input
- `form.password(fieldName, options = {})` - Create password input
- `form.hidden(fieldName, options = {})` - Create hidden input
- `form.textarea(fieldName, options = {})` - Create textarea
- `form.checkbox(fieldName, options = {})` - Create checkbox
- `form.radio(fieldName, options, attributes = {})` - Create radio buttons
- `form.select(fieldName, options, attributes = {})` - Create select dropdown
- `form.file(fieldName, options = {})` - Create file upload input
- `form.submit(caption = null, options = {})` - Create submit button
- `form.button(title, options = {})` - Create button element
- `form.postButton(title, url, options = {})` - Create POST button
- `form.postLink(title, url = null, options = {})` - Create POST link
- `form.dateTime(fieldName, dateFormat = 'DMY', timeFormat = '12', attributes = {})` - Create date/time selects
- `form.year(fieldName, minYear, maxYear, attributes)` - Create year select
- `form.month(fieldName, attributes = {})` - Create month select
- `form.day(fieldName, attributes = {})` - Create day select
- `form.hour(fieldName, format24 = false, attributes = {})` - Create hour select
- `form.minute(fieldName, attributes = {})` - Create minute select
- `form.meridian(fieldName, attributes = {})` - Create AM/PM select

### HtmlHelper

HTML generation and markup creation.

- `html.charset(charset = null)` - Meta tag for character encoding
- `html.css(path, options = {})` - Link to CSS stylesheet(s)
- `html.meta(type, url = null, options = {})` - Generate meta tags
- `html.docType(type = 'xhtml-strict')` - Return doctype tag
- `html.style(data, oneline = true)` - Build CSS from array
- `html.image(path, options = {})` - Create image tag
- `html.link(title, url = null, options = {})` - Generate HTML link
- `html.media(path, options)` - Create audio/video tag
- `html.tag(tag, text, options)` - Wrap text in HTML tag
- `html.div(class, text, options)` - Create div element
- `html.para(class, text, options)` - Create paragraph element
- `html.script(url, options)` - Include JavaScript file(s)
- `html.scriptBlock(code, options = {})` - Generate script block
- `html.scriptStart(options = {})` - Begin script buffering
- `html.scriptEnd()` - End script buffering
- `html.nestedList(list, options = {}, itemOptions = {}, tag = 'ul')` - Build nested list
- `html.tableHeaders(names, trOptions = null, thOptions = null)` - Create table headers
- `html.tableCells(data, oddTrOptions = null, evenTrOptions = null, useCount = false, continueOddEven = true)` - Create table cells
- `html.url(url = null, full = false)` - Generate URL

### NumberHelper

Number formatting and conversion.

- `number.currency(number, currency = 'USD', options = {})` - Format as currency
- `number.defaultCurrency(currency)` - Get/set default currency
- `number.addFormat(formatName, options)` - Add custom currency format
- `number.precision(number, precision = 3)` - Format with decimal precision
- `number.toPercentage(number, precision = 2, options = {})` - Convert to percentage
- `number.fromReadableSize(size, default)` - Convert "1 KB" to bytes
- `number.toReadableSize(dataSize)` - Format as "1 KB", "1 MB", etc.
- `number.format(number, options = false)` - Format number with options
- `number.formatDelta(number, options = {})` - Format signed number difference

### PaginatorHelper

Pagination support.

- `paginator.options(options = {})` - Set pagination options
- `paginator.params(model = null)` - Get pagination params
- `paginator.param(key, model = null)` - Get single pagination param
- `paginator.url(options = {}, asArray = false, model = null)` - Generate pagination URL
- `paginator.defaultModel()` - Get/set default model
- `paginator.link(title, url = {}, options = {})` - Generate pagination link
- `paginator.prev(title = '<< Previous', options = {}, disabledTitle = null, disabledOptions = {})` - Previous link
- `paginator.next(title = 'Next >>', options = {}, disabledTitle = null, disabledOptions = {})` - Next link
- `paginator.sort(key, title = null, options = {})` - Generate sort link
- `paginator.sortDir(model = null, options = {})` - Get sort direction
- `paginator.sortKey(model = null, options = {})` - Get sort key
- `paginator.numbers(options = {})` - Generate page numbers
- `paginator.first(first = '<< first', options = {})` - First page link
- `paginator.last(last = 'last >>', options = {})` - Last page link
- `paginator.counter(options = {})` - Page counter (e.g., "1-20 of 100")
- `paginator.hasNext(model = null)` - Check if next page exists
- `paginator.hasPrev(model = null)` - Check if previous page exists
- `paginator.hasPage(model = null, page = 1)` - Check if page exists

See [Using CakePHP Helpers](helpers.md) for detailed usage guide.

## See Also

- [Installation](installation.md) - Setup guide
- [Basic Usage](basic-usage.md) - Getting started
- [Using Helpers](helpers.md) - CakePHP Helper integration
- [Legacy Features](legacy.md) - Deprecated features
- [Migration Guide](migration-from-cakephp-twig-view.md) - From cakephp/twig-view
