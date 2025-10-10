<?php

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

App::import('Lib', 'TwigView.Cake_Number_Filters');

/**
 * Twig_Extension_Number
 *
 * Use: {{ '3535839525'|size }} //=> 3.29 GB
 * Use: {{ '0.555'|p(2) }} //=> 0.56
 * Use: {{ '5999'|curr }} //=> $5,999.00
 * Use: {{ '2.3'|pct }} //=> 2.30%
 */
class Twig_Extension_Number extends AbstractExtension
{
    /**
     * Cake Number Filters instance
     *
     * @var Cake_Number_Filters
     */
    protected $numberFilters;

    /**
     * Constructor
     *
     * @param View $view
     */
    public function __construct(View $view)
    {
        $this->numberFilters = new Cake_Number_Filters($view);
    }

    /**
     * Returns a list of filters to add to the existing list.
     *
     * @return array An array of filters
     */
    public function getFilters(): array
    {
        return [
            new TwigFilter('size', [$this->numberFilters, 'size']),
            new TwigFilter('pct', [$this->numberFilters, 'percentage']),
            new TwigFilter('curr', [$this->numberFilters, 'currency']),
            new TwigFilter('p', [$this->numberFilters, 'precision']),
        ];
    }
}
