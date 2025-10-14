<?php
declare(strict_types=1);

namespace TwigView\Twig\Extension;

use Inflector;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

/**
 * Inflector Extension
 *
 * Provides text inflection filters using CakePHP's Inflector class.
 */
class InflectorExtension extends AbstractExtension
{
    /**
     * Wrapper for Inflector::slug() that lowercases the result
     *
     * @param string $string String to slug
     * @param string $replacement Replacement character (default: underscore)
     * @return string Slugified string (lowercased)
     */
    public function slug(string $string, string $replacement = '_'): string
    {
        return strtolower(Inflector::slug($string, $replacement));
    }

    /**
     * Returns a list of filters to add to the existing list.
     *
     * @return array<TwigFilter>
     */
    public function getFilters(): array
    {
        return [
            new TwigFilter('pluralize', [Inflector::class, 'pluralize']),
            new TwigFilter('singularize', [Inflector::class, 'singularize']),
            new TwigFilter('camelize', [Inflector::class, 'camelize']),
            new TwigFilter('underscore', [Inflector::class, 'underscore']),
            new TwigFilter('humanize', [Inflector::class, 'humanize']),
            new TwigFilter('tableize', [Inflector::class, 'tableize']),
            new TwigFilter('classify', [Inflector::class, 'classify']),
            new TwigFilter('variable', [Inflector::class, 'variable']),
            new TwigFilter('slug', [$this, 'slug']),
        ];
    }

    /**
     * Returns the name of the extension.
     *
     * @return string
     */
    public function getName(): string
    {
        return 'inflector';
    }
}
