<?php
declare(strict_types=1);

namespace TwigView\Test\TestCase\Twig\Extension;

use CakeTestCase;
use Twig\Environment;
use Twig\Loader\ArrayLoader;
use TwigView\Twig\Extension\StringsExtension;

/**
 * StringsExtension Test
 */
class StringsExtensionTest extends CakeTestCase
{
    /**
     * @var \Twig\Environment
     */
    protected $twig;

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();

        $loader = new ArrayLoader([]);
        $this->twig = new Environment($loader);
        $this->twig->addExtension(new StringsExtension());
    }

    /**
     * Test tokenize filter
     *
     * @return void
     */
    public function testTokenize(): void
    {
        $template = $this->twig->createTemplate('{{ text|tokenize(" ")|length }}');
        $result = $template->render(['text' => 'Hello World Test']);
        $this->assertEquals('3', $result);
    }

    /**
     * Test insert filter
     *
     * @return void
     */
    public function testInsert(): void
    {
        $template = $this->twig->createTemplate('{{ text|insert({"name": "John"}) }}');
        $result = $template->render(['text' => 'Hello :name']);
        $this->assertEquals('Hello John', $result);
    }

    /**
     * Test truncate filter
     *
     * @return void
     */
    public function testTruncate(): void
    {
        $template = $this->twig->createTemplate('{{ text|truncate(10) }}');
        $result = $template->render(['text' => 'This is a long text']);
        $this->assertStringContainsString('...', $result);
        $this->assertLessThan(20, strlen($result));
    }

    /**
     * Test highlight filter
     *
     * @return void
     */
    public function testHighlight(): void
    {
        $template = $this->twig->createTemplate('{{ text|highlight("world")|raw }}');
        $result = $template->render(['text' => 'Hello world']);
        $this->assertStringContainsString('<span', $result);
        $this->assertStringContainsString('world', $result);
    }

    /**
     * Test tail filter
     *
     * @return void
     */
    public function testTail(): void
    {
        $template = $this->twig->createTemplate('{{ text|tail(5) }}');
        $result = $template->render(['text' => 'Hello World']);
        // CakeText::tail adds '...' prefix by default
        $this->assertEquals('...ld', $result);
    }

    /**
     * Test excerpt filter
     *
     * @return void
     */
    public function testExcerpt(): void
    {
        $template = $this->twig->createTemplate('{{ text|excerpt("important", 20) }}');
        $result = $template->render(['text' => 'This is important information for testing']);
        $this->assertStringContainsString('important', $result);
        $this->assertStringContainsString('...', $result);
    }

    /**
     * Test to_list filter
     *
     * @return void
     */
    public function testToList(): void
    {
        $template = $this->twig->createTemplate('{{ items|to_list }}');
        $result = $template->render(['items' => ['apple', 'banana', 'orange']]);
        $this->assertStringContainsString('apple', $result);
        $this->assertStringContainsString('and', $result);
        $this->assertStringContainsString('orange', $result);
    }

    /**
     * Test toList alias
     *
     * @return void
     */
    public function testToListAlias(): void
    {
        $template = $this->twig->createTemplate('{{ items|toList }}');
        $result = $template->render(['items' => ['one', 'two']]);
        $this->assertStringContainsString('one', $result);
        $this->assertStringContainsString('and', $result);
    }

    /**
     * Test strip_links filter
     *
     * @return void
     */
    public function testStripLinks(): void
    {
        $template = $this->twig->createTemplate('{{ text|strip_links }}');
        $result = $template->render(['text' => 'Hello <a href="#">link</a> world']);
        $this->assertEquals('Hello link world', $result);
        $this->assertStringNotContainsString('<a', $result);
    }

    /**
     * Test stripLinks alias
     *
     * @return void
     */
    public function testStripLinksAlias(): void
    {
        $template = $this->twig->createTemplate('{{ text|stripLinks }}');
        $result = $template->render(['text' => '<a href="#">test</a>']);
        $this->assertEquals('test', $result);
    }

    /**
     * Test word_wrap filter
     *
     * @return void
     */
    public function testWordWrap(): void
    {
        $template = $this->twig->createTemplate('{{ text|word_wrap(10) }}');
        $result = $template->render(['text' => 'This is a long text that needs wrapping']);
        $this->assertStringContainsString("\n", $result);
    }

    /**
     * Test wordWrap alias
     *
     * @return void
     */
    public function testWordWrapAlias(): void
    {
        $template = $this->twig->createTemplate('{{ text|wordWrap(15) }}');
        $result = $template->render(['text' => 'This is another long text']);
        $this->assertStringContainsString("\n", $result);
    }

    /**
     * Test extension name
     *
     * @return void
     */
    public function testGetName(): void
    {
        $extension = new StringsExtension();
        $this->assertEquals('strings', $extension->getName());
    }
}
