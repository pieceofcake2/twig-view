<?php
declare(strict_types=1);

namespace TwigView\Twig\Extension;

use Router;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;
use View;

/**
 * View Extension
 *
 * Provides view-related functions for elements, fetch, and routing.
 */
class ViewExtension extends AbstractExtension
{
    /**
     * View instance
     *
     * @var \View
     */
    protected $view;

    /**
     * Constructor
     *
     * @param \View $view View instance
     */
    public function __construct(View $view)
    {
        $this->view = $view;
    }

    /**
     * Returns a list of functions to add to the existing list.
     *
     * @return array<\Twig\TwigFunction>
     */
    public function getFunctions(): array
    {
        return [
            new TwigFunction('element', [$this, 'element'], ['is_safe' => ['html']]),
            new TwigFunction('fetch', [$this, 'fetch'], ['is_safe' => ['html']]),
            new TwigFunction('url', [$this, 'url']),
            new TwigFunction('path', [$this, 'path']),
        ];
    }

    /**
     * Render an element
     *
     * @param string $name Element name
     * @param array<string, mixed> $data Data to pass to element
     * @param array<string, mixed> $options Options for element rendering
     * @return string
     */
    public function element(string $name, array $data = [], array $options = []): string
    {
        return $this->view->element($name, $data, $options);
    }

    /**
     * Fetch content from view blocks
     *
     * @param string $name Block name
     * @param string $default Default content if block doesn't exist
     * @return string
     */
    public function fetch(string $name, string $default = ''): string
    {
        return $this->view->fetch($name, $default);
    }

    /**
     * Generate URL from array or string
     *
     * @param array<string, mixed>|string|null $url URL array or string
     * @param bool $full Generate full URL with protocol and domain
     * @return string
     */
    public function url(array|string|null $url = null, bool $full = false): string
    {
        return Router::url($url, $full);
    }

    /**
     * Generate relative path (alias for url with full = false)
     *
     * @param array<string, mixed>|string $url URL array or string
     * @return string
     */
    public function path(array|string|null $url = null): string
    {
        return Router::url($url, false);
    }

    /**
     * Returns the name of the extension.
     *
     * @return string
     */
    public function getName(): string
    {
        return 'view';
    }
}
