<?php
declare(strict_types=1);

namespace TwigView\Test\TestCase\Twig\Node;

use CakeTestCase;
use Twig\Compiler;
use Twig\Environment;
use Twig\Loader\ArrayLoader;
use Twig\Node\Expression\NameExpression;
use Twig\Node\Node;
use Twig\Node\PrintNode;
use Twig\Node\TextNode;
use TwigView\Twig\Node\TransNode;

class TransNodeTest extends CakeTestCase
{
    /**
     * Test constructor with simple text
     */
    public function testConstructorWithSimpleText(): void
    {
        $body = new Node([new TextNode('Hello World', 1)]);
        $node = new TransNode($body, null, null, 1, 'trans');

        $this->assertInstanceOf(TransNode::class, $node);
        $this->assertEquals(1, $node->getTemplateLine());
    }

    /**
     * Test constructor with plural
     */
    public function testConstructorWithPlural(): void
    {
        $body = new Node([new TextNode('You have %count% message.', 1)]);
        $plural = new Node([new TextNode('You have %count% messages.', 1)]);
        $count = new NameExpression('count', 1);

        $node = new TransNode($body, $plural, $count, 1, 'trans');

        $this->assertInstanceOf(TransNode::class, $node);
    }

    /**
     * Test compile with simple text
     */
    public function testCompileWithSimpleText(): void
    {
        $body = new Node([new TextNode('Hello World', 1)]);
        $node = new TransNode($body, null, null, 1, 'trans');

        $env = new Environment(new ArrayLoader());
        $compiler = new Compiler($env);

        $node->compile($compiler);
        $source = $compiler->getSource();

        $this->assertStringContainsString('echo __("Hello World")', $source);
    }

    /**
     * Test compile with plural
     */
    public function testCompileWithPlural(): void
    {
        $body = new Node([new TextNode('You have %count% message.', 1)]);
        $plural = new Node([new TextNode('You have %count% messages.', 1)]);
        $count = new NameExpression('count', 1);

        $node = new TransNode($body, $plural, $count, 1, 'trans');

        $env = new Environment(new ArrayLoader());
        $compiler = new Compiler($env);

        $node->compile($compiler);
        $source = $compiler->getSource();

        $this->assertStringContainsString('__n("You have %count% message.", "You have %count% messages."', $source);
    }

    /**
     * Test compile with variables
     */
    public function testCompileWithVariables(): void
    {
        $body = new Node([
            new TextNode('Hello ', 1),
            new PrintNode(new NameExpression('name', 1), 1),
        ]);

        $node = new TransNode($body, null, null, 1, 'trans');

        $env = new Environment(new ArrayLoader());
        $compiler = new Compiler($env);

        $node->compile($compiler);
        $source = $compiler->getSource();

        $this->assertStringContainsString('strtr(__("Hello %name%")', $source);
        $this->assertStringContainsString('"%name%" => ($context["name"]', $source);
    }

    /**
     * Test getNode returns body
     */
    public function testGetNodeReturnsBody(): void
    {
        $body = new Node([new TextNode('Hello World', 1)]);
        $node = new TransNode($body, null, null, 1, 'trans');

        $retrievedBody = $node->getNode('body');
        $this->assertSame($body, $retrievedBody);
    }

    /**
     * Test hasNode for plural
     */
    public function testHasNodeForPlural(): void
    {
        $body = new Node([new TextNode('singular', 1)]);
        $plural = new Node([new TextNode('plural', 1)]);
        $count = new NameExpression('count', 1);

        $node = new TransNode($body, $plural, $count, 1, 'trans');

        $this->assertTrue($node->hasNode('plural'));
        $this->assertTrue($node->hasNode('count'));
    }

    /**
     * Test hasNode without plural
     */
    public function testHasNodeWithoutPlural(): void
    {
        $body = new Node([new TextNode('Hello World', 1)]);
        $node = new TransNode($body, null, null, 1, 'trans');

        $this->assertFalse($node->hasNode('plural'));
        $this->assertFalse($node->hasNode('count'));
    }
}
