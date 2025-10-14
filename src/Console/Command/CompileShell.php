<?php
declare(strict_types=1);

/**
 * CompileShell
 *
 * Shell command to pre-compile Twig templates for performance optimization
 */

namespace TwigView\Console\Command;

use CakePlugin;
use Exception;
use FilesystemIterator;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use RegexIterator;
use Shell;
use TwigView\View\TwigView;

/**
 * CompileShell
 *
 * Pre-compiles Twig templates to improve production performance
 */
class CompileShell extends Shell
{
    /**
     * TwigView instance
     *
     * @var TwigView
     */
    private $TwigView;

    /**
     * Constructor
     *
     * @param ConsoleOutput|null $stdout
     * @param ConsoleOutput|null $stderr
     * @param ConsoleInput|null $stdin
     */
    public function __construct($stdout = null, $stderr = null, $stdin = null)
    {
        parent::__construct($stdout, $stderr, $stdin);

        $this->TwigView = new TwigView();
    }

    /**
     * Compile all Twig templates in all loaded plugins
     *
     * @return void
     */
    public function all()
    {
        $this->out('<info>Compiling Twig templates...</info>');
        $compiled = 0;
        $errors = 0;

        $plugins = CakePlugin::loaded();
        foreach ($plugins as $plugin) {
            $pluginPath = CakePlugin::path($plugin);

            $templateDirs = [];
            if (is_dir($pluginPath . 'View' . DS)) {
                $templateDirs[] = $pluginPath . 'View' . DS;
            }
            if (is_dir($pluginPath . 'templates' . DS)) {
                $templateDirs[] = $pluginPath . 'templates' . DS;
            }

            if (empty($templateDirs)) {
                continue;
            }

            $this->out('<info>Processing plugin: ' . $plugin . '</info>');

            foreach ($templateDirs as $templateDir) {
                $iterator = new RegexIterator(
                    new RecursiveIteratorIterator(
                        new RecursiveDirectoryIterator(
                            $templateDir,
                            FilesystemIterator::KEY_AS_PATHNAME |
                            FilesystemIterator::CURRENT_AS_FILEINFO |
                            FilesystemIterator::SKIP_DOTS,
                        ),
                        RecursiveIteratorIterator::CHILD_FIRST,
                        RecursiveIteratorIterator::CATCH_GET_CHILD,
                    ),
                    '/.*?\.twig$/',
                    RegexIterator::GET_MATCH,
                );

                foreach ($iterator as $paths) {
                    foreach ($paths as $path) {
                        if ($this->file($path)) {
                            $compiled++;
                        } else {
                            $errors++;
                        }
                    }
                }
            }
        }

        $this->out('');
        $this->out('<success>Compilation complete!</success>');
        $this->out('  Compiled: ' . $compiled);
        if ($errors > 0) {
            $this->out('  <error>Errors: ' . $errors . '</error>');
        }
    }

    /**
     * Compile a single template file
     *
     * @param string $fileName Path to template file
     * @return bool True if successful, false otherwise
     */
    public function file($fileName)
    {
        try {
            $relativePath = $this->getRelativePath($fileName);
            $this->TwigView->Twig->load($relativePath);

            $cache = $this->TwigView->Twig->getCache();
            if ($cache !== false) {
                $cacheKey = $this->TwigView->Twig->getTemplateClass($relativePath);
                $cacheFile = $cache . '/' . substr($cacheKey, 0, 2) . '/' . substr($cacheKey, 2) . '.php';

                if (!file_exists($cacheFile)) {
                    $source = $this->TwigView->Twig->getLoader()->getSourceContext($relativePath);
                    $compiledCode = $this->TwigView->Twig->compileSource($source);

                    $cacheDir = dirname($cacheFile);
                    if (!is_dir($cacheDir)) {
                        mkdir($cacheDir, 0777, true);
                    }
                    file_put_contents($cacheFile, $compiledCode);
                }
            }

            $this->out('  <success>✓ ' . $fileName . '</success>');

            return true;
        } catch (Exception $e) {
            $this->out('  <error>✗ ' . $fileName . '</error>');
            $this->out('    ' . $e->getMessage());

            return false;
        }
    }

    /**
     * Get relative path from template paths
     *
     * @param string $fileName Absolute path to template file
     * @return string Relative path for Twig loader
     */
    protected function getRelativePath($fileName)
    {
        $templatePaths = $this->TwigView->templatePaths;

        foreach ($templatePaths as $path) {
            if (strpos($fileName, $path) === 0) {
                return substr($fileName, strlen($path));
            }
        }

        return $fileName;
    }

    /**
     * Get option parser
     *
     * @return ConsoleOptionParser
     */
    public function getOptionParser()
    {
        $parser = parent::getOptionParser();
        $parser->addSubcommand('all', [
            'short' => 'a',
            'help' => __('Searches and compiles all Twig templates (.twig files) for performance optimization.'),
        ])->addSubcommand('file', [
            'short' => 'f',
            'help' => __('Compile a single Twig template file.'),
        ])->description(__('Twig template compiler. Pre-compiles templates to improve production performance.'));

        return $parser;
    }
}
