<?php

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class Twig_Extension_I18n extends AbstractExtension
{
    /**
     * Returns the token parser instances to add to the existing list.
     *
     * @return array An array of token parsers
     */
    public function getTokenParsers(): array
    {
        return [new Twig_TokenParser_Trans()];
    }

    /**
     * Returns a list of filters to add to the existing list.
     *
     * @return array An array of filters
     */
    public function getFilters(): array
    {
        return [
            new TwigFilter('trans', '__'),
        ];
    }
}
