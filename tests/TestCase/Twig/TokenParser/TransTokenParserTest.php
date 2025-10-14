<?php
declare(strict_types=1);

namespace TwigView\Test\TestCase\Twig\TokenParser;

use CakeTestCase;
use Twig\Environment;
use Twig\Error\SyntaxError;
use Twig\Loader\ArrayLoader;
use Twig\TemplateWrapper;
use TwigView\Twig\TokenParser\TransTokenParser;

class TransTokenParserTest extends CakeTestCase
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
            'simple.twig' => '{% trans %}Hello World{% endtrans %}',
            'with_var.twig' => '{% trans %}Hello {{ name }}{% endtrans %}',
            'plural.twig' => '{% trans %}You have {{ count }} message.{% plural count %}You have {{ count }} messages.{% endtrans %}',
        ]);

        $this->twig = new Environment($loader);
        $this->twig->addTokenParser(new TransTokenParser());
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
        $parser = new TransTokenParser();
        $this->assertEquals('trans', $parser->getTag());
    }

    /**
     * Test parsing simple trans tag
     */
    public function testParsingSimpleTransTag(): void
    {
        $template = $this->twig->load('simple.twig');
        $this->assertInstanceOf(TemplateWrapper::class, $template);
    }

    /**
     * Test parsing trans tag with variable
     */
    public function testParsingTransTagWithVariable(): void
    {
        $template = $this->twig->load('with_var.twig');
        $this->assertInstanceOf(TemplateWrapper::class, $template);
    }

    /**
     * Test parsing trans tag with plural
     */
    public function testParsingTransTagWithPlural(): void
    {
        $template = $this->twig->load('plural.twig');
        $this->assertInstanceOf(TemplateWrapper::class, $template);
    }

    /**
     * Test compilation includes translation call
     */
    public function testCompilationIncludesTranslationCall(): void
    {
        $source = $this->twig->compileSource($this->twig->getLoader()->getSourceContext('simple.twig'));
        $this->assertStringContainsString('echo __("Hello World")', $source);
    }

    /**
     * Test compilation with plural includes __n call
     */
    public function testCompilationWithPluralIncludesPluralizationCall(): void
    {
        $source = $this->twig->compileSource($this->twig->getLoader()->getSourceContext('plural.twig'));
        $this->assertStringContainsString('__n("You have %count% message.", "You have %count% messages."', $source);
    }

    /**
     * Test invalid trans content throws exception
     */
    public function testInvalidTransContentThrowsException(): void
    {
        $loader = new ArrayLoader([
            'invalid.twig' => '{% trans %}Hello {{ name|upper }}{% endtrans %}',
        ]);

        $twig = new Environment($loader);
        $twig->addTokenParser(new TransTokenParser());

        $this->expectException(SyntaxError::class);
        $this->expectExceptionMessage('can only contain references to simple variables');

        $twig->load('invalid.twig');
    }
}
