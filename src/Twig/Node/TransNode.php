<?php
declare(strict_types=1);

namespace TwigView\Twig\Node;

use Twig\Compiler;
use Twig\Node\Expression\AbstractExpression;
use Twig\Node\Expression\ConstantExpression;
use Twig\Node\Expression\FilterExpression;
use Twig\Node\Expression\NameExpression;
use Twig\Node\Node;
use Twig\Node\PrintNode;
use Twig\Node\TextNode;

/**
 * Represents a trans node.
 *
 * Modified to use CakePHP functions
 */
class TransNode extends Node
{
    /**
     * Constructor
     *
     * @param Node $body
     * @param Node|null $plural
     * @param AbstractExpression|null $count
     * @param int $lineno
     * @param string|null $tag
     */
    public function __construct(Node $body, ?Node $plural = null, ?AbstractExpression $count = null, int $lineno = 0, ?string $tag = null)
    {
        $nodes = ['body' => $body];
        if ($plural !== null) {
            $nodes['plural'] = $plural;
        }
        if ($count !== null) {
            $nodes['count'] = $count;
        }
        parent::__construct($nodes, [], $lineno, $tag);
    }

    /**
     * Compiles the node to PHP.
     *
     * @param Compiler $compiler A Compiler instance
     * @return void
     */
    public function compile(Compiler $compiler): void
    {
        $compiler->addDebugInfo($this);
        [$msg, $vars] = $this->compileString($this->getNode('body'));

        if ($this->hasNode('plural')) {
            [$msg1, $vars1] = $this->compileString($this->getNode('plural'));
            $vars = array_merge($vars, $vars1);
        }

        $function = $this->hasNode('plural') ? '__n' : '__';

        if ($vars) {
            $compiler
                ->write('echo strtr(' . $function . '(')
                ->subcompile($msg);

            if ($this->hasNode('plural')) {
                $compiler
                    ->raw(', ')
                    ->subcompile($msg1)
                    ->raw(', abs(')
                    ->subcompile($this->getNode('count'))
                    ->raw(')');
            }

            $compiler->raw('), array(');

            foreach ($vars as $var) {
                if ($var->getAttribute('name') === 'count') {
                    $compiler
                        ->string('%count%')
                        ->raw(' => abs(')
                        ->subcompile($this->getNode('count'))
                        ->raw('), ');
                } else {
                    $compiler
                        ->string('%' . $var->getAttribute('name') . '%')
                        ->raw(' => ')
                        ->subcompile($var)
                        ->raw(', ');
                }
            }

            $compiler->raw("));\n");
        } else {
            $compiler
                ->write('echo ' . $function . '(')
                ->subcompile($msg);

            if ($this->hasNode('plural')) {
                $compiler
                    ->raw(', ')
                    ->subcompile($msg1)
                    ->raw(', abs(')
                    ->subcompile($this->getNode('count'))
                    ->raw(')');
            }

            $compiler->raw(");\n");
        }
    }

    /**
     * Compile String
     *
     * @param Node $body
     * @return array{0: Node, 1: array<\Twig\Node\Expression\NameExpression>}
     */
    protected function compileString(Node $body): array
    {
        if ($body instanceof NameExpression || $body instanceof ConstantExpression) {
            return [$body, []];
        }

        $msg = '';
        $vars = [];
        $node = null;

        if ($body instanceof TextNode) {
            $node = $body;
            $msg = $node->getAttribute('data');
        } else {
            foreach ($body as $n) {
                if ($n instanceof PrintNode) {
                    $expr = $n->getNode('expr');
                    while ($expr instanceof FilterExpression) {
                        $expr = $expr->getNode('node');
                    }
                    $msg .= sprintf('%%%s%%', $expr->getAttribute('name'));
                    $vars[] = new NameExpression($expr->getAttribute('name'), $expr->getTemplateLine());
                    $node = $n;
                } else {
                    $msg .= $n->getAttribute('data');
                    $node = $n;
                }
            }
        }

        return [new Node([new ConstantExpression(trim($msg), $node ? $node->getTemplateLine() : 0)]), $vars];
    }
}
