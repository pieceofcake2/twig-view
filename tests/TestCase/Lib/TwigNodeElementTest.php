<?php
/**
 * Twig_Node_Element Test Case
 */

use Twig\Compiler;
use Twig\Environment;
use Twig\Loader\ArrayLoader;
use Twig\Node\Expression\ConstantExpression;
use Twig\Node\Expression\NameExpression;

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

    /**
     * Test compilation with variables
     */
    public function testCompilationWithVariables(): void
    {
        $loader = new ArrayLoader([]);
        $env = new Environment($loader);
        $compiler = new Compiler($env);

        $expr = new ConstantExpression('test', 1);
        $variables = new ConstantExpression(['foo' => 'bar'], 1);
        $node = new Twig_Node_Element($expr, $variables, 1, 'element');

        $compiled = $compiler->compile($node)->getSource();

        $this->assertIsString($compiled);
        $this->assertStringContainsString('array_merge($context', $compiled);
    }

    /**
     * Test compilation generates correct output
     */
    public function testCompilationGeneratesCorrectOutput(): void
    {
        $loader = new ArrayLoader([]);
        $env = new Environment($loader);
        $compiler = new Compiler($env);

        $expr = new ConstantExpression('test', 1);
        $node = new Twig_Node_Element($expr, null, 1, 'element');

        $compiled = $compiler->compile($node)->getSource();

        $this->assertMatchesRegularExpression('/\$this->loadTemplate\("Elements.*test\.twig"/', $compiled);
        $this->assertMatchesRegularExpression('/->display\(\$context\);/', $compiled);
    }

    /**
     * Test compilation with variables merges context
     */
    public function testCompilationWithVariablesMergesContext(): void
    {
        $loader = new ArrayLoader([]);
        $env = new Environment($loader);
        $compiler = new Compiler($env);

        $expr = new ConstantExpression('test', 1);
        $variables = new ConstantExpression(['foo' => 'bar'], 1);
        $node = new Twig_Node_Element($expr, $variables, 1, 'element');

        $compiled = $compiler->compile($node)->getSource();

        $this->assertStringContainsString('array_merge($context', $compiled);
        $this->assertStringContainsString('"foo"', $compiled);
        $this->assertStringContainsString('"bar"', $compiled);
    }

    /**
     * Test compilation with only attribute without variables
     */
    public function testCompilationWithOnlyAttributeWithoutVariables(): void
    {
        $loader = new ArrayLoader([]);
        $env = new Environment($loader);
        $compiler = new Compiler($env);

        $expr = new ConstantExpression('test', 1);
        $node = new Twig_Node_Element($expr, null, 1, 'element');

        $reflection = new ReflectionClass($node);
        $property = $reflection->getProperty('attributes');
        $property->setAccessible(true);
        $attributes = $property->getValue($node);
        $attributes['only'] = true;
        $property->setValue($node, $attributes);

        $compiled = $compiler->compile($node)->getSource();

        $this->assertMatchesRegularExpression('/->display\(\[\]\);/', $compiled);
    }

    /**
     * Test compilation with only attribute with variables
     */
    public function testCompilationWithOnlyAttributeWithVariables(): void
    {
        $loader = new ArrayLoader([]);
        $env = new Environment($loader);
        $compiler = new Compiler($env);

        $expr = new ConstantExpression('test', 1);
        $variables = new ConstantExpression(['foo' => 'bar'], 1);
        $node = new Twig_Node_Element($expr, $variables, 1, 'element');

        $reflection = new ReflectionClass($node);
        $property = $reflection->getProperty('attributes');
        $property->setAccessible(true);
        $attributes = $property->getValue($node);
        $attributes['only'] = true;
        $property->setValue($node, $attributes);

        $compiled = $compiler->compile($node)->getSource();

        $this->assertStringNotContainsString('array_merge', $compiled);
        $this->assertStringContainsString('"foo"', $compiled);
        $this->assertStringContainsString('"bar"', $compiled);
        $this->assertMatchesRegularExpression('/->display\(\["foo" => "bar"\]\);/', $compiled);
    }

    /**
     * Test compilation with variable expression (NameExpression)
     */
    public function testCompilationWithVariableExpression(): void
    {
        $loader = new ArrayLoader([]);
        $env = new Environment($loader);
        $compiler = new Compiler($env);

        $expr = new NameExpression('elementName', 1);
        $node = new Twig_Node_Element($expr, null, 1, 'element');

        $compiled = $compiler->compile($node)->getSource();

        $this->assertStringContainsString('$template = ', $compiled);
        $this->assertStringContainsString('($context["elementName"] ?? null)', $compiled);
        $this->assertStringContainsString('if (!$template instanceof \\Twig\\TemplateWrapper)', $compiled);
        $this->assertStringContainsString('$this->env->load("Elements" . DIRECTORY_SEPARATOR . $template . ".twig")', $compiled);
        $this->assertStringContainsString('$template->display($context);', $compiled);
    }

    /**
     * Test compilation with variable expression and variables
     */
    public function testCompilationWithVariableExpressionAndVariables(): void
    {
        $loader = new ArrayLoader([]);
        $env = new Environment($loader);
        $compiler = new Compiler($env);

        $expr = new NameExpression('elementName', 1);
        $variables = new ConstantExpression(['foo' => 'bar'], 1);
        $node = new Twig_Node_Element($expr, $variables, 1, 'element');

        $compiled = $compiler->compile($node)->getSource();

        $this->assertStringContainsString('$template = ', $compiled);
        $this->assertStringContainsString('($context["elementName"] ?? null)', $compiled);
        $this->assertStringContainsString('array_merge($context', $compiled);
        $this->assertStringContainsString('"foo"', $compiled);
        $this->assertStringContainsString('"bar"', $compiled);
    }
}
