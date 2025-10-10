<?php

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

/**
 * CakePHP Basic functions
 *
 * Use: {{ user|debug }}
 * Use: {{ user|pr }}
 * Use: {{ 'FOO'|low }}
 * Use: {{ 'foo'|up }}
 * Use: {{ 'HTTP_HOST'|env }}
 */
class Twig_Extension_Basic extends AbstractExtension
{
    /**
     * Returns a list of filters to add to the existing list.
     *
     * @return array An array of filters
     */
    public function getFilters(): array
    {
        return [
            new TwigFilter('debug', 'debug'),
            new TwigFilter('pr', 'pr'),
            new TwigFilter('low', 'strtolower'),
            new TwigFilter('up', 'strtoupper'),
            new TwigFilter('env', 'env'),
        ];
    }
}
