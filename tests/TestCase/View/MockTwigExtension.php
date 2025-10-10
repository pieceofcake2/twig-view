<?php
/**
 * Mock Twig Extension for testing custom extension support
 */

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;

class MockTwigExtension extends AbstractExtension
{
    /**
     * Get filters
     *
     * @return array
     */
    public function getFilters(): array
    {
        return [
            new TwigFilter('custom_upper', function ($string) {
                return 'CUSTOM:' . strtoupper($string);
            }),
        ];
    }

    /**
     * Get functions
     *
     * @return array
     */
    public function getFunctions(): array
    {
        return [
            new TwigFunction('custom_hello', function ($name = 'World') {
                return 'Hello from custom extension, ' . $name . '!';
            }),
        ];
    }

    /**
     * Get extension name
     *
     * @return string
     */
    public function getName(): string
    {
        return 'mock_twig_extension';
    }
}
