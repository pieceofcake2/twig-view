# Using CakePHP Helpers

CakePHP Helpers must be enabled in your controller to be available in Twig templates.

## Enabling Helpers

Helpers are **not automatically available**. You must enable them in your controller:

```php
class PostsController extends AppController
{
    // Enable specific helpers
    public $helpers = ['Html', 'Form', 'Time', 'Number', 'Text', 'Session'];
}
```

Or in `AppController` to make them available to all controllers:

```php
class AppController extends Controller
{
    public $helpers = ['Html', 'Form', 'Time', 'Number', 'Text', 'Session'];
}
```

## How Helpers Work in Twig

Once enabled, Helper classes are accessible in Twig templates as lowercase variables.

**Naming Convention**: Remove the "Helper" suffix and convert to lowercase.

| Helper Class | Twig Variable |
|--------------|---------------|
| `HtmlHelper` | `{{ html }}` |
| `FormHelper` | `{{ form }}` |
| `TimeHelper` | `{{ time }}` |
| `NumberHelper` | `{{ number }}` |
| `TextHelper` | `{{ text }}` |
| `SessionHelper` | `{{ session }}` |
| `PaginatorHelper` | `{{ paginator }}` |
| `MyCustomHelper` | `{{ mycustom }}` |

**Basic Usage:**

```twig
{# Call helper methods #}
{{ html.link('Home', '/') }}
{{ form.input('email') }}
{{ time.timeAgoInWords(date) }}
{{ number.currency(99.99) }}
```

## HtmlHelper

HTML generation helper for creating markup.

**Enable:** `public $helpers = ['Html'];`

### Methods

#### `charset(charset = null)`
Creates a meta tag specifying the document's character encoding.

```twig
{{ html.charset() }}
{{ html.charset('utf-8') }}
```

#### `css(path, options = {})`
Creates link(s) to CSS stylesheet(s).

```twig
{{ html.css('style') }}
{{ html.css(['reset', 'layout']) }}
{{ html.css('print', {media: 'print'}) }}
```

#### `meta(type, url = null, options = {})`
Generates meta tags for resources like RSS feeds, favicons, keywords.

```twig
{{ html.meta('description', 'My site description') }}
{{ html.meta('keywords', 'cake, php, framework') }}
{{ html.meta('icon', 'favicon.ico') }}
```

#### `docType(type = 'xhtml-strict')`
Returns a (X)HTML doctype tag.

```twig
{{ html.docType() }}
{{ html.docType('html5') }}
```

#### `style(data, oneline = true)`
Builds CSS style definitions from an array.

```twig
{{ html.style({background: '#fff', color: '#000'}) }}
```

#### `image(path, options = {})`
Creates an image tag.

```twig
{{ html.image('logo.png') }}
{{ html.image('photo.jpg', {alt: 'Photo', width: 200}) }}
```

#### `link(title, url = null, options = {})`
Generates HTML links.

```twig
{{ html.link('Home', '/') }}
{{ html.link('View Post', {controller: 'posts', action: 'view', id: 123}) }}
{{ html.link('External', 'https://example.com', {target: '_blank'}) }}
```

#### `media(path, options)`
Creates audio/video tags with support for multiple sources.

```twig
{{ html.media('video.mp4') }}
{{ html.media(['video.mp4', 'video.ogv'], {autoplay: true}) }}
```

#### `tag(tag, text, options)`
Returns text wrapped in a specified HTML tag.

```twig
{{ html.tag('span', 'Hello', {class: 'greeting'}) }}
```

#### `div(class, text, options)`
Creates a div-wrapped section of markup.

```twig
{{ html.div('container', content) }}
```

#### `para(class, text, options)`
Returns text wrapped in a paragraph tag.

```twig
{{ html.para('intro', 'Welcome text') }}
```

#### `script(url, options)`
Includes JavaScript file(s).

```twig
{{ html.script('app') }}
{{ html.script(['jquery', 'app']) }}
```

#### `scriptBlock(code, options = {})`
Generates a script block with JavaScript code.

```twig
{{ html.scriptBlock('alert("Hello");') }}
```

#### `scriptStart(options = {})`
Begins buffering a script code block.

```twig
{{ html.scriptStart() }}
```

#### `scriptEnd()`
Ends and returns a buffered script block.

```twig
{{ html.scriptEnd() }}
```

#### `nestedList(list, options = {}, itemOptions = {}, tag = 'ul')`
Builds a nested list from an associative array.

```twig
{{ html.nestedList(items) }}
{{ html.nestedList(items, {}, {}, 'ol') }}
```

#### `tableHeaders(names, trOptions = null, thOptions = null)`
Creates table header cells.

```twig
{{ html.tableHeaders(['Name', 'Email', 'Actions']) }}
```

#### `tableCells(data, oddTrOptions = null, evenTrOptions = null, useCount = false, continueOddEven = true)`
Creates table cells from data array.

```twig
{{ html.tableCells(rows) }}
```

#### `url(url = null, full = false)`
Generates a URL for the provided options.

```twig
{{ html.url('/posts/view/1') }}
{{ html.url({controller: 'posts', action: 'index'}) }}
{{ html.url({controller: 'posts', action: 'index'}, true) }}
```

### FormHelper

The FormHelper provides methods for creating forms and form inputs.

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

### TimeHelper

The TimeHelper provides methods for formatting dates and times.

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

### NumberHelper

The NumberHelper provides methods for formatting numbers.

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

### TextHelper

The TextHelper provides methods for text manipulation.

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

### SessionHelper

The SessionHelper provides methods for reading session data.

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

### PaginatorHelper

The PaginatorHelper provides methods for pagination.

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

### JsHelper

The JsHelper provides methods for working with JavaScript.

```twig
{# Link with JavaScript #}
{{ js.link('Click me', {url: '/posts/delete/1', confirm: 'Are you sure?'}) }}

{# Submit form with AJAX #}
{{ js.submit('Save', {url: '/posts/save', update: '#content'}) }}
```

## Custom Helpers

You can use your own custom helpers in the same way:

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

## Helper Configuration

You can configure helpers with options:

```php
// Controller
class PostsController extends AppController
{
    public $helpers = [
        'Html' => ['className' => 'MyHtml'],
        'Form' => ['templates' => 'my_templates']
    ];
}
```

The configured helper will be available in Twig templates automatically.

## See Also

- [Complete Feature Reference](reference.md) - Full list of filters, functions, tests, and tags
- [CakePHP 2.x Helper Documentation](https://book.cakephp.org/2.0/en/core-libraries/helpers.html) - Official CakePHP documentation
