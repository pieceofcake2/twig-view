<?php

use Twig\Token;
use Twig\TokenParser\AbstractTokenParser;

/**
 * Just a hacked version 'include'
 *
 *    {% element "login_form" %}
 *
 *     => loads: APP/views/elements/login_form.twig
 */

/*
 * This file is part of Twig.
 *
 * (c) 2009 Fabien Potencier
 * (c) 2009 Armin Ronacher
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
class Twig_TokenParser_Element extends AbstractTokenParser
{
    /**
     * Parses a token and returns a node.
     *
     * @param Token $token A Token instance
     * @return Twig_Node_Element A Twig_Node_Element instance
     */
    public function parse(Token $token): Twig_Node_Element
    {
        $stream = $this->parser->getStream();
        $expr = $this->parser->parseExpression();
        $variables = null;
        if ($stream->test(Token::NAME_TYPE, 'with')) {
            $stream->next();
            $variables = $this->parser->parseExpression();
        }

        $stream->expect(Token::BLOCK_END_TYPE);

        return new Twig_Node_Element($expr, $variables, $token->getLine(), $this->getTag());
    }

    /**
     * Gets the tag name associated with this token parser.
     *
     * @return string The tag name
     */
    public function getTag(): string
    {
        return 'element';
    }
}
