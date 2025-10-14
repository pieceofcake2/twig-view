<?php
declare(strict_types=1);

namespace TwigView\Test\TestCase\Twig\Node;

use CakeTestCase;
use Twig\Compiler;
use Twig\Environment;
use Twig\Loader\ArrayLoader;
use Twig\Node\Expression\ConstantExpression;
use TwigView\Twig\Node\LayoutNode;

class LayoutNodeTest extends CakeTestCase
{
    /**
     * Test constructor
     */
    public function testConstructor(): void
    {
        $expr = new ConstantExpression('custom', 1);
        $node = new LayoutNode($expr, 1, 'layout');

        $this->assertInstanceOf(LayoutNode::class, $node);
        $this->assertEquals(1, $node->getTemplateLine());
    }

    /**
     * Test compile
     */
    public function testCompile(): void
    {
        $expr = new ConstantExpression('custom', 1);
        $node = new LayoutNode($expr, 1, 'layout');

        $env = new Environment(new ArrayLoader());
        $compiler = new Compiler($env);

        $node->compile($compiler);
        $source = $compiler->getSource();

        $this->assertStringContainsString('$this->env->getGlobals()[\'_view\']->layout("custom")', $source);
    }

    /**
     * Test compile with false value
     */
    public function testCompileWithFalseValue(): void
    {
        $expr = new ConstantExpression(false, 1);
        $node = new LayoutNode($expr, 1, 'layout');

        $env = new Environment(new ArrayLoader());
        $compiler = new Compiler($env);

        $node->compile($compiler);
        $source = $compiler->getSource();

        $this->assertStringContainsString('$this->env->getGlobals()[\'_view\']->layout(false)', $source);
    }

    /**
     * Test getNode returns expression
     */
    public function testGetNodeReturnsExpression(): void
    {
        $expr = new ConstantExpression('custom', 1);
        $node = new LayoutNode($expr, 1, 'layout');

        $retrievedExpr = $node->getNode('expr');
        $this->assertSame($expr, $retrievedExpr);
    }
}
