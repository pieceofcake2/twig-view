<?php

use Twig\Compiler;
use Twig\Node\Expression\ConstantExpression;
use Twig\Node\Node;

/**
 * Represents an include node.
 *
 * Modified to use CakePHP paths
 */
class Twig_Node_Element extends Node
{
    /**
     * Constructor
     *
     * @param Node $expr
     * @param Node|null $variables
     * @param int $lineno
     * @param string|null $tag
     */
    public function __construct(Node $expr, ?Node $variables = null, int $lineno = 0, ?string $tag = null)
    {
        $only = false;
        $nodes = ['expr' => $expr];
        if ($variables !== null) {
            $nodes['variables'] = $variables;
        }
        parent::__construct($nodes, ['only' => (bool)$only], $lineno, $tag);
    }

    /**
     * Compiles the node to PHP.
     *
     * @param Compiler $compiler A Compiler instance
     */
    public function compile(Compiler $compiler): void
    {
        $compiler->addDebugInfo($this);

        if ($this->getNode('expr') instanceof ConstantExpression) {
            $template = $this->getNode('expr')->getAttribute('value');
            $value = 'Elements' . DS . $template . '.twig';
            $this->getNode('expr')->setAttribute('value', $value);

            $compiler
                ->write('$this->loadTemplate(')
                ->subcompile($this->getNode('expr'))
                ->raw(', ')
                ->repr($this->getTemplateName())
                ->raw(', ')
                ->repr($this->getTemplateLine())
                ->raw(')->display(');
        } else {
            $compiler
                ->write('$template = ')
                ->subcompile($this->getNode('expr'))
                ->raw(";\n")
                ->write('if (!$template')
                ->raw(" instanceof \\Twig\\TemplateWrapper) {\n")
                ->indent()
                ->write("\$template = \$this->env->load(\"Elements\" . DIRECTORY_SEPARATOR . \$template . \".twig\");\n")
                ->outdent()
                ->write("}\n")
                ->write('$template->display(');
        }

        if ($this->getAttribute('only') === false) {
            if (!$this->hasNode('variables')) {
                $compiler->raw('$context');
            } else {
                $compiler
                    ->raw('array_merge($context, ')
                    ->subcompile($this->getNode('variables'))
                    ->raw(')');
            }
        } else {
            if (!$this->hasNode('variables')) {
                $compiler->raw('[]');
            } else {
                $compiler->subcompile($this->getNode('variables'));
            }
        }

        $compiler->raw(");\n");
    }
}
