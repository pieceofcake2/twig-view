<?php
/**
 * Twig_TokenParser_Element Test Case
 */

use Twig\Environment;
use Twig\Loader\ArrayLoader;

$twigPath = CakePlugin::path('TwigView');
require_once $twigPath . 'Lib' . DS . 'Twig_TokenParser_Element.php';
require_once $twigPath . 'Lib' . DS . 'Twig_Node_Element.php';

class TwigTokenParserElementTest extends CakeTestCase
{
    /**
     * Twig Environment
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
            'test_element.twig' => 'Element content',
            'Elements' . DS . 'test_element.twig' => 'Element content',
        ]);
        $this->twig = new Environment($loader);
        $this->twig->addTokenParser(new Twig_TokenParser_Element());
    }

    /**
     * Tear down
     */
    public function tearDown(): void
    {
        parent::tearDown();
        unset($this->twig);
    }

    /**
     * Test getTag
     */
    public function testGetTag(): void
    {
        $parser = new Twig_TokenParser_Element();
        $this->assertEquals('element', $parser->getTag());
    }

    /**
     * Test element tag parsing
     */
    public function testElementTagParsing(): void
    {
        $template = $this->twig->createTemplate('{% element "test_element" %}');
        $result = $template->render([]);

        $this->assertEquals('Element content', $result);
    }

    /**
     * Test element tag with variables
     */
    public function testElementTagWithVariables(): void
    {
        $loader = new ArrayLoader([
            'Elements' . DS . 'var_element.twig' => 'Value: {{ value }}',
        ]);
        $twig = new Environment($loader);
        $twig->addTokenParser(new Twig_TokenParser_Element());

        $template = $twig->createTemplate('{% element "var_element" with {"value": myvar} %}');
        $result = $template->render(['myvar' => 'test']);

        $this->assertEquals('Value: test', $result);
    }
}
