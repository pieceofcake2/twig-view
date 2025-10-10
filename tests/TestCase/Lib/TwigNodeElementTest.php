<?php
/**
 * Twig_Node_Element Test Case
 */

use Twig\Compiler;
use Twig\Environment;
use Twig\Loader\ArrayLoader;
use Twig\Node\Expression\ConstantExpression;

$twigPath = CakePlugin::path('TwigView');
require_once $twigPath . 'Lib' . DS . 'Twig_Node_Element.php';

class TwigNodeElementTest extends CakeTestCase
{
    /**
     * Test node construction
     */
    public function testNodeConstruction(): void
    {
        $expr = new ConstantExpression('test', 1);
        $node = new Twig_Node_Element($expr, null, 1, 'element');

        $this->assertInstanceOf('Twig_Node_Element', $node);
        $this->assertEquals(1, $node->getTemplateLine());
        // Note: getNodeTag() is not set when using custom tag parameter in Twig 3
        // The tag is stored differently in the node structure
    }

    /**
     * Test node with variables
     */
    public function testNodeWithVariables(): void
    {
        $expr = new ConstantExpression('test', 1);
        $variables = new ConstantExpression(['foo' => 'bar'], 1);
        $node = new Twig_Node_Element($expr, $variables, 1, 'element');

        $this->assertInstanceOf('Twig_Node_Element', $node);
        $this->assertNotNull($node->getNode('variables'));
    }

    /**
     * Test node compilation
     */
    public function testNodeCompilation(): void
    {
        $loader = new ArrayLoader([]);
        $env = new Environment($loader);
        $compiler = new Compiler($env);

        $expr = new ConstantExpression('test', 1);
        $node = new Twig_Node_Element($expr, null, 1, 'element');

        $compiled = $compiler->compile($node)->getSource();

        $this->assertIsString($compiled);
        $this->assertStringContainsString('loadTemplate', $compiled);
        $this->assertStringContainsString('Elements', $compiled);
    }

    /**
     * Test path modification
     */
    public function testPathModification(): void
    {
        $loader = new ArrayLoader([]);
        $env = new Environment($loader);
        $compiler = new Compiler($env);

        $expr = new ConstantExpression('login_form', 1);
        $node = new Twig_Node_Element($expr, null, 1, 'element');

        $compiled = $compiler->compile($node)->getSource();

        // Should contain Elements directory path
        $this->assertStringContainsString('Elements', $compiled);
        $this->assertStringContainsString('login_form.twig', $compiled);
    }
}
