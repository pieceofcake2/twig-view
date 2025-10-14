<?php
declare(strict_types=1);

namespace TwigView\Twig\Extension;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;
use TwigView\Twig\TokenParser\TransTokenParser;

/**
 * I18n Extension
 *
 * Provides internationalization filters and functions using CakePHP's translation system.
 */
class I18nExtension extends AbstractExtension
{
    /**
     * Wrapper for __n() that formats the result with sprintf
     *
     * @param string $singular Singular form
     * @param string $plural Plural form
     * @param int $count Count
     * @return string Formatted string
     */
    public function pluralize(string $singular, string $plural, int $count): string
    {
        $message = __n($singular, $plural, $count);

        return sprintf($message, $count);
    }

    /**
     * Returns a list of filters to add to the existing list.
     *
     * @return array<\Twig\TwigFilter>
     */
    public function getFilters(): array
    {
        return [
            new TwigFilter('trans', '__'),
        ];
    }

    /**
     * Returns a list of functions to add to the existing list.
     *
     * @return array<TwigFunction>
     */
    public function getFunctions(): array
    {
        return [
            new TwigFunction('__', '__'),
            new TwigFunction('__d', '__d'),
            new TwigFunction('__n', [$this, 'pluralize']),
            new TwigFunction('__x', '__x'),
        ];
    }

    /**
     * Returns a list of token parsers to add to the existing list.
     *
     * @return array<\Twig\TokenParser\TokenParserInterface>
     */
    public function getTokenParsers(): array
    {
        return [
            new TransTokenParser(),
        ];
    }

    /**
     * Returns the name of the extension.
     *
     * @return string
     */
    public function getName(): string
    {
        return 'i18n';
    }
}
