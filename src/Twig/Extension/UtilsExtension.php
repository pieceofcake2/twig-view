<?php
declare(strict_types=1);

namespace TwigView\Twig\Extension;

use Twig\Extension\AbstractExtension;
use Twig\TwigTest;

/**
 * Utils Extension
 *
 * Provides utility tests.
 */
class UtilsExtension extends AbstractExtension
{
    /**
     * Returns a list of tests to add to the existing list.
     *
     * @return array<TwigTest>
     */
    public function getTests(): array
    {
        return [
            new TwigTest('multibyte', [$this, 'isMultibyte']),
        ];
    }

    /**
     * Check if string is multibyte
     *
     * @param string $value The string to check
     * @return bool
     */
    public function isMultibyte(string $value): bool
    {
        return mb_strlen($value, 'UTF-8') !== strlen($value);
    }

    /**
     * Returns the name of the extension.
     *
     * @return string
     */
    public function getName(): string
    {
        return 'utils';
    }
}
