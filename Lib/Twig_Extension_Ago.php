<?php

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

App::import('Helper', 'Time');

/**
 * Time Ago in Words
 * Use: {{ user.User.created|ago }}
 */
class Twig_Extension_Ago extends AbstractExtension
{
    /**
     * Time Helper instance
     *
     * @var TimeHelper
     */
    protected $timeHelper;

    /**
     * Constructor
     *
     * @param View $view
     */
    public function __construct(View $view)
    {
        $this->timeHelper = new TimeHelper($view);
    }

    /**
     * Wrapper to Time->timeAgoInWords()
     *
     * @param mixed $var
     * @return string
     */
    public function cakeAgo($var): string
    {
        return $this->timeHelper->timeAgoInWords($var);
    }

    /**
     * Returns a list of filters to add to the existing list.
     *
     * @return array An array of filters
     */
    public function getFilters(): array
    {
        return [
            new TwigFilter('ago', [$this, 'cakeAgo']),
        ];
    }
}
