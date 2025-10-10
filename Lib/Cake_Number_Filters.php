<?php

/**
 * Number Helper Filters
 *
 * Use: {{ '3535839525'|size }} //=> 3.29 GB
 * Use: {{ '0.555'|p(2) }} //=> 0.56
 * Use: {{ '5999'|curr }} //=> $5,999.00
 * Use: {{ '2.3'|pct }} //=> 2.30%
 */
class Cake_Number_Filters
{
    /**
     * Number Helper instance
     *
     * @var NumberHelper
     */
    protected $numberHelper;

    /**
     * Constructor
     *
     * @param View $view
     */
    public function __construct(View $view)
    {
        $this->numberHelper = new NumberHelper($view);
    }

    /**
     * Wrapper to Number->toReadableSize()
     *
     * @param int $var Size in bytes
     * @return string
     */
    public function size($var)
    {
        return $this->numberHelper->toReadableSize($var);
    }

    /**
     * Wrapper to Number->toPercentage()
     *
     * @param float $var A floating point number
     * @param int $p The precision of the returned number
     * @return string
     */
    public function percentage($var, $p = 2)
    {
        return $this->numberHelper->toPercentage($var, $p);
    }

    /**
     * Wrapper to Number->currency()
     *
     * @param float $var
     * @param string $curr Valid values are 'USD', 'EUR', 'GBP'
     * @param array $opts f.e. 'before' and 'after' options.
     * @return string
     */
    public function currency($var, $curr = 'USD', $opts = [])
    {
        return $this->numberHelper->currency($var, $curr, $opts);
    }

    /**
     * Wrapper to Number->precision()
     *
     * @param float $var A floating point number
     * @param int $p The precision of the returned number
     * @return string
     */
    public function precision($var, $p = 2)
    {
        return $this->numberHelper->precision($var, $p);
    }
}
