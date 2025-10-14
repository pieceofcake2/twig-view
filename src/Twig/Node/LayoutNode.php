<?php
declare(strict_types=1);

namespace TwigView\Twig\Node;

use Twig\Compiler;
use Twig\Node\Node;

/**
 * Represents a layout node.
 *
 * Sets the layout for the view.
 */
class LayoutNode extends Node
{
    /**
     * Constructor
     *
     * @param Node $expr Layout name expression
     * @param int $lineno Line number
     * @param string|null $tag Tag name
     */
    public function __construct(Node $expr, int $lineno = 0, ?string $tag = null)
    {
        parent::__construct(['expr' => $expr], [], $lineno, $tag);
    }

    /**
     * Compiles the node to PHP.
     *
     * @param Compiler $compiler A Compiler instance
     * @return void
     */
    public function compile(Compiler $compiler): void
    {
        $compiler
            ->addDebugInfo($this)
            ->write('$this->env->getGlobals()[\'_view\']->layout(')
            ->subcompile($this->getNode('expr'))
            ->raw(");\n");
    }
}
