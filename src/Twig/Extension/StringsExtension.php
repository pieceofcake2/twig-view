<?php
declare(strict_types=1);

namespace TwigView\Twig\Extension;

use CakeText;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

/**
 * Strings Extension
 *
 * Provides string manipulation filters using CakePHP's CakeText class.
 */
class StringsExtension extends AbstractExtension
{
    /**
     * Returns a list of filters to add to the existing list.
     *
     * @return array<TwigFilter>
     */
    public function getFilters(): array
    {
        return [
            new TwigFilter('tokenize', [CakeText::class, 'tokenize']),
            new TwigFilter('insert', [CakeText::class, 'insert']),
            new TwigFilter('clean_insert', [CakeText::class, 'cleanInsert']),
            new TwigFilter('cleanInsert', [CakeText::class, 'cleanInsert']),
            new TwigFilter('wrap', [CakeText::class, 'wrap']),
            new TwigFilter('wrap_block', [CakeText::class, 'wrapBlock']),
            new TwigFilter('wrapBlock', [CakeText::class, 'wrapBlock']),
            new TwigFilter('word_wrap', [CakeText::class, 'wordWrap']),
            new TwigFilter('wordWrap', [CakeText::class, 'wordWrap']),
            new TwigFilter('highlight', [CakeText::class, 'highlight']),
            new TwigFilter('tail', [CakeText::class, 'tail']),
            new TwigFilter('truncate', [CakeText::class, 'truncate']),
            new TwigFilter('excerpt', [CakeText::class, 'excerpt']),
            new TwigFilter('to_list', [CakeText::class, 'toList']),
            new TwigFilter('toList', [CakeText::class, 'toList']),
            new TwigFilter('strip_links', [CakeText::class, 'stripLinks']),
            new TwigFilter('stripLinks', [CakeText::class, 'stripLinks']),
        ];
    }

    /**
     * Returns the name of the extension.
     *
     * @return string
     */
    public function getName(): string
    {
        return 'strings';
    }
}
