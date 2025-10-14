<?php
declare(strict_types=1);

namespace TwigView\Twig\TokenParser;

use Twig\Token;
use Twig\TokenParser\AbstractTokenParser;
use TwigView\Twig\Node\LayoutNode;

/**
 * Token parser for the {% layout %} tag.
 *
 * Sets the layout for the view.
 *
 * Usage:
 * ```twig
 * {% layout 'Error' %}
 * {% layout 'Ajax' %}
 * {% layout false %}
 * ```
 */
class LayoutTokenParser extends AbstractTokenParser
{
    /**
     * Parses a token and returns a node.
     *
     * @param Token $token A Token instance
     * @return LayoutNode A LayoutNode instance
     */
    public function parse(Token $token): LayoutNode
    {
        $lineno = $token->getLine();
        $stream = $this->parser->getStream();

        // Parse the layout name expression
        $expr = $this->parser->parseExpression();

        $stream->expect(Token::BLOCK_END_TYPE);

        return new LayoutNode($expr, $lineno, $this->getTag());
    }

    /**
     * Gets the tag name associated with this token parser.
     *
     * @return string The tag name
     */
    public function getTag(): string
    {
        return 'layout';
    }
}
