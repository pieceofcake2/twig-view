<?php
/**
 * Twig_TokenParser_Trans Test Case
 */

use Twig\Environment;
use Twig\Loader\ArrayLoader;

$twigPath = CakePlugin::path('TwigView');
require_once $twigPath . 'Lib' . DS . 'Twig_TokenParser_Trans.php';
require_once $twigPath . 'Lib' . DS . 'Twig_Node_Trans.php';

class TwigTokenParserTransTest extends CakeTestCase
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

        $loader = new ArrayLoader([]);
        $this->twig = new Environment($loader);
        $this->twig->addTokenParser(new Twig_TokenParser_Trans());
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
        $parser = new Twig_TokenParser_Trans();
        $this->assertEquals('trans', $parser->getTag());
    }

    /**
     * Test trans tag with simple string
     */
    public function testTransTagSimpleString(): void
    {
        $template = $this->twig->createTemplate('{% trans "Hello World" %}');
        $result = $template->render([]);

        $this->assertEquals('Hello World', $result);
    }

    /**
     * Test trans tag with block
     */
    public function testTransTagWithBlock(): void
    {
        $template = $this->twig->createTemplate('{% trans %}Simple text{% endtrans %}');
        $result = $template->render([]);

        $this->assertEquals('Simple text', $result);
    }

    /**
     * Test trans tag with variable
     */
    public function testTransTagWithVariable(): void
    {
        $template = $this->twig->createTemplate('{% trans %}Hello {{ name }}{% endtrans %}');
        $result = $template->render(['name' => 'World']);

        $this->assertEquals('Hello World', $result);
    }

    /**
     * Test trans tag with plural
     */
    public function testTransTagWithPlural(): void
    {
        $template = $this->twig->createTemplate(
            '{% trans %}One item{% plural count %}{{ count }} items{% endtrans %}',
        );
        $result = $template->render(['count' => 5]);

        $this->assertEquals('5 items', $result);
    }
}
