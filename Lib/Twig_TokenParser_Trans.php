<?php

use Twig\Error\SyntaxError;
use Twig\Node\Expression\NameExpression;
use Twig\Node\Node;
use Twig\Node\PrintNode;
use Twig\Node\TextNode;
use Twig\Token;
use Twig\TokenParser\AbstractTokenParser;

class Twig_TokenParser_Trans extends AbstractTokenParser
{
    /**
     * Parses a token and returns a node.
     *
     * @param Token $token A Token instance
     * @return Twig_Node_Trans A Twig_Node_Trans instance
     */
    public function parse(Token $token): Twig_Node_Trans
    {
        $lineno = $token->getLine();
        $stream = $this->parser->getStream();
        $count = null;
        $plural = null;

        if (!$stream->test(Token::BLOCK_END_TYPE)) {
            $body = $this->parser->parseExpression();
        } else {
            $stream->expect(Token::BLOCK_END_TYPE);
            $body = $this->parser->subparse([$this, 'decideForFork']);
            if ($stream->next()->getValue() === 'plural') {
                $count = $this->parser->parseExpression();
                $stream->expect(Token::BLOCK_END_TYPE);
                $plural = $this->parser->subparse([$this, 'decideForEnd'], true);
            }
        }

        $stream->expect(Token::BLOCK_END_TYPE);
        $this->checkTransString($body, $lineno);

        return new Twig_Node_Trans($body, $plural, $count, $lineno, $this->getTag());
    }

    /**
     * Decide For Fork
     *
     * @param Token $token
     * @return bool
     */
    public function decideForFork(Token $token): bool
    {
        return $token->test(['plural', 'endtrans']);
    }

    /**
     * Decide For End
     *
     * @param Token $token
     * @return bool
     */
    public function decideForEnd(Token $token): bool
    {
        return $token->test('endtrans');
    }

    /**
     * Gets the tag name associated with this token parser.
     *
     * @return string
     */
    public function getTag(): string
    {
        return 'trans';
    }

    /**
     * Check Trans String
     *
     * @param Node $body
     * @param int $lineno
     * @return void
     */
    protected function checkTransString(Node $body, int $lineno): void
    {
        foreach ($body as $node) {
            if ($node instanceof TextNode || ($node instanceof PrintNode && $node->getNode('expr') instanceof NameExpression)) {
                continue;
            }

            throw new SyntaxError('The text to be translated with "trans" can only contain references to simple variables', $lineno);
        }
    }
}
