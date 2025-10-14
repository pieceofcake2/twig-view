<?php
declare(strict_types=1);

namespace TwigView\Twig\Extension;

use CakeNumber;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

/**
 * Number Extension
 *
 * Provides number formatting filters using CakePHP's CakeNumber class.
 */
class NumberExtension extends AbstractExtension
{
    /**
     * Returns a list of filters to add to the existing list.
     *
     * @return array<TwigFilter>
     */
    public function getFilters(): array
    {
        return [
            new TwigFilter('to_readable_size', [CakeNumber::class, 'toReadableSize']),
            new TwigFilter('toReadableSize', [CakeNumber::class, 'toReadableSize']),
            new TwigFilter('to_percentage', [CakeNumber::class, 'toPercentage']),
            new TwigFilter('toPercentage', [CakeNumber::class, 'toPercentage']),
            new TwigFilter('format_delta', [CakeNumber::class, 'formatDelta']),
            new TwigFilter('formatDelta', [CakeNumber::class, 'formatDelta']),
            new TwigFilter('currency', [CakeNumber::class, 'currency']),
            new TwigFilter('precision', [CakeNumber::class, 'precision']),
        ];
    }

    /**
     * Returns the name of the extension.
     *
     * @return string
     */
    public function getName(): string
    {
        return 'number';
    }
}
