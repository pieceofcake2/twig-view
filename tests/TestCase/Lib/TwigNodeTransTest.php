<?php
/**
 * Twig_Node_Trans Test Case
 */

use Twig\Compiler;
use Twig\Environment;
use Twig\Loader\ArrayLoader;
use Twig\Node\Expression\ConstantExpression;
use Twig\Node\Node;
use Twig\Node\TextNode;

$twigPath = CakePlugin::path('TwigView');
require_once $twigPath . 'Lib' . DS . 'Twig_Node_Trans.php';

class TwigNodeTransTest extends CakeTestCase
{
    /**
     * Test node construction
     */
    public function testNodeConstruction(): void
    {
        $body = new Node([new TextNode('Hello', 1)]);
        $node = new Twig_Node_Trans($body, null, null, 1, 'trans');

        $this->assertInstanceOf('Twig_Node_Trans', $node);
        $this->assertEquals(1, $node->getTemplateLine());
    }

    /**
     * Test node with plural
     */
    public function testNodeWithPlural(): void
    {
        $body = new Node([new TextNode('One item', 1)]);
        $plural = new Node([new TextNode('%count% items', 1)]);
        $count = new ConstantExpression(5, 1);
        $node = new Twig_Node_Trans($body, $plural, $count, 1, 'trans');

        $this->assertInstanceOf('Twig_Node_Trans', $node);
        $this->assertNotNull($node->getNode('plural'));
        $this->assertNotNull($node->getNode('count'));
    }

    /**
     * Test node compilation without plural
     */
    public function testNodeCompilationWithoutPlural(): void
    {
        $loader = new ArrayLoader([]);
        $env = new Environment($loader);
        $compiler = new Compiler($env);

        $body = new Node([new TextNode('Hello World', 1)]);
        $node = new Twig_Node_Trans($body, null, null, 1, 'trans');

        $compiled = $compiler->compile($node)->getSource();

        $this->assertEquals('// line 1' . "\n" . 'echo __("Hello World");', $compiled);
    }

    /**
     * Test node compilation with plural
     */
    public function testNodeCompilationWithPlural(): void
    {
        $loader = new ArrayLoader([]);
        $env = new Environment($loader);
        $compiler = new Compiler($env);

        $body = new Node([new TextNode('One item', 1)]);
        $plural = new Node([new TextNode('%count% items', 1)]);
        $count = new ConstantExpression(5, 1);
        $node = new Twig_Node_Trans($body, $plural, $count, 1, 'trans');

        $compiled = $compiler->compile($node)->getSource();

        $this->assertEquals('// line 1' . "\n" . 'echo __n("One item", "%count% items", abs(5));', $compiled);
    }

    /**
     * Test CakePHP compilation
     */
    public function testCakePHPCompilation(): void
    {
        $loader = new ArrayLoader([]);
        $env = new Environment($loader);
        $compiler = new Compiler($env);

        $body = new Node([new TextNode('Test', 1)]);
        $node = new Twig_Node_Trans($body, null, null, 1, 'trans');

        $compiled = $compiler->compile($node)->getSource();

        // Should compile to echo __("Test");
        $this->assertEquals('// line 1' . "\n" . 'echo __("Test");', $compiled);
    }
}
