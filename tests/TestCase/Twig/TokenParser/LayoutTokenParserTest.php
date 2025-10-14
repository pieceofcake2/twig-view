<?php
declare(strict_types=1);

namespace TwigView\Test\TestCase\Twig\TokenParser;

use CakeTestCase;
use Twig\Environment;
use Twig\Loader\ArrayLoader;
use Twig\TemplateWrapper;
use TwigView\Twig\TokenParser\LayoutTokenParser;

class LayoutTokenParserTest extends CakeTestCase
{
    /**
     * Twig environment
     *
     * @var Environment
     */
    protected $twig;

    /**
     * Set up
     */
    public function setUp(): void
    {
        parent::setUp();

        $loader = new ArrayLoader([
            'test.twig' => '{% layout "custom" %}Hello',
            'test_false.twig' => '{% layout false %}Hello',
        ]);

        $this->twig = new Environment($loader);
        $this->twig->addTokenParser(new LayoutTokenParser());
    }

    /**
     * Tear down
     */
    public function tearDown(): void
    {
        unset($this->twig);
        parent::tearDown();
    }

    /**
     * Test getTag
     */
    public function testGetTag(): void
    {
        $parser = new LayoutTokenParser();
        $this->assertEquals('layout', $parser->getTag());
    }

    /**
     * Test parsing layout tag with string
     */
    public function testParsingLayoutTagWithString(): void
    {
        $template = $this->twig->load('test.twig');
        $this->assertInstanceOf(TemplateWrapper::class, $template);
    }

    /**
     * Test parsing layout tag with false
     */
    public function testParsingLayoutTagWithFalse(): void
    {
        $template = $this->twig->load('test_false.twig');
        $this->assertInstanceOf(TemplateWrapper::class, $template);
    }

    /**
     * Test compilation includes layout call
     */
    public function testCompilationIncludesLayoutCall(): void
    {
        $source = $this->twig->compileSource($this->twig->getLoader()->getSourceContext('test.twig'));
        $this->assertStringContainsString('$this->env->getGlobals()[\'_view\']->layout("custom")', $source);
    }
}
