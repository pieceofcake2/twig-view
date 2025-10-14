<?php
declare(strict_types=1);

namespace TwigView\Twig;

use CakePlugin;
use Twig\Error\LoaderError;
use Twig\Loader\LoaderInterface;
use Twig\Source;

/**
 * File Loader for Twig
 *
 * Loads template files from CakePHP 2.x paths including plugins and themes.
 */
class FileLoader implements LoaderInterface
{
    /**
     * Template file extensions
     *
     * @var array<string>
     */
    protected $extensions = [];

    /**
     * View paths
     *
     * @var array<string>
     */
    protected $paths = [];

    /**
     * Theme name
     *
     * @var string|null
     */
    protected $theme = null;

    /**
     * Constructor
     *
     * @param array<string> $paths View paths
     * @param array<string> $extensions Template file extensions (default: ['.twig'])
     */
    public function __construct(array $paths = [], array $extensions = ['.twig'])
    {
        $this->paths = $paths;
        $this->extensions = $extensions;
    }

    /**
     * Set theme
     *
     * @param string|null $theme Theme name
     * @return void
     */
    public function setTheme(?string $theme): void
    {
        $this->theme = $theme;
    }

    /**
     * Add path
     *
     * @param string $path Path to add
     * @return void
     */
    public function addPath(string $path): void
    {
        if (!in_array($path, $this->paths, true)) {
            $this->paths[] = $path;
        }
    }

    /**
     * Get paths
     *
     * @return array<string>
     */
    public function getPaths(): array
    {
        return $this->paths;
    }

    /**
     * Returns the source context for a given template logical name.
     *
     * @param string $name The template logical name
     * @return Source
     * @throws LoaderError When $name is not found
     */
    public function getSourceContext(string $name): Source
    {
        $path = $this->findTemplate($name);

        return new Source(file_get_contents($path), $name, $path);
    }

    /**
     * Gets the cache key to use for the cache for a given template name.
     *
     * @param string $name The name of the template to load
     * @return string The cache key
     * @throws LoaderError When $name is not found
     */
    public function getCacheKey(string $name): string
    {
        return $this->findTemplate($name);
    }

    /**
     * Returns true if the template is still fresh.
     *
     * @param string $name The template name
     * @param int $time Timestamp of the last modification time of the cached template
     * @return bool true if the template is fresh, false otherwise
     * @throws LoaderError When $name is not found
     */
    public function isFresh(string $name, int $time): bool
    {
        return filemtime($this->findTemplate($name)) <= $time;
    }

    /**
     * Check if we have the source code of a template, given its name.
     *
     * @param string $name The name of the template to check if we can load
     * @return bool If the template source code is handled by this loader or not
     */
    public function exists(string $name): bool
    {
        try {
            $this->findTemplate($name);

            return true;
        } catch (LoaderError $e) {
            return false;
        }
    }

    /**
     * Find a template file
     *
     * @param string $name Template name
     * @return string Full path to template file
     * @throws LoaderError When template is not found
     */
    protected function findTemplate(string $name): string
    {
        if ($name[0] === '/' || (isset($name[1]) && $name[1] === ':')) {
            if (file_exists($name)) {
                return $name;
            }
        }

        if (strpos($name, '.') !== false) {
            [$plugin, $template] = explode('.', $name, 2);

            if (CakePlugin::loaded($plugin)) {
                $pluginPath = CakePlugin::path($plugin);

                $templateDirs = ['templates', 'View'];
                foreach ($templateDirs as $dir) {
                    $templatePath = $pluginPath . $dir . DS . $template;
                    $file = $this->checkExtensions($templatePath);
                    if ($file !== null) {
                        return $file;
                    }
                }
            }
        }

        if ($this->theme !== null) {
            foreach ($this->paths as $path) {
                $themedPath = $path . 'Themed' . DS . $this->theme . DS . $name;
                $file = $this->checkExtensions($themedPath);
                if ($file !== null) {
                    return $file;
                }
            }
        }

        foreach ($this->paths as $path) {
            $templatePath = $path . $name;
            $file = $this->checkExtensions($templatePath);
            if ($file !== null) {
                return $file;
            }
        }

        throw new LoaderError(sprintf('Unable to find template "%s".', $name));
    }

    /**
     * Check partial path with all template file extensions to see
     * which file exists.
     *
     * @param string $partial Template path excluding extension
     * @return string|null
     */
    protected function checkExtensions(string $partial): ?string
    {
        if (file_exists($partial)) {
            return $partial;
        }

        foreach ($this->extensions as $extension) {
            $path = $partial . $extension;
            if (file_exists($path)) {
                return $path;
            }
        }

        return null;
    }
}
