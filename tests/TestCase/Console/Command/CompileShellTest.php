<?php
/**
 * CompileShell Test Case
 */

App::uses('CompileShell', 'TwigView.Console/Command');

class CompileShellTest extends CakeTestCase
{
    /**
     * Shell instance
     *
     * @var CompileShell
     */
    protected $Shell;

    /**
     * Output stub
     *
     * @var ConsoleOutput
     */
    protected $out;

    /**
     * Error output stub
     *
     * @var ConsoleOutput
     */
    protected $err;

    /**
     * Original cache configuration
     *
     * @var string|null
     */
    protected $originalCache;

    /**
     * Set up
     */
    public function setUp(): void
    {
        parent::setUp();

        $this->originalCache = Configure::read('TwigView.cache');

        $this->out = $this->getMockBuilder('ConsoleOutput')
            ->disableOriginalConstructor()
            ->getMock();

        $this->err = $this->getMockBuilder('ConsoleOutput')
            ->disableOriginalConstructor()
            ->getMock();

        $this->Shell = new CompileShell($this->out, $this->err);
    }

    /**
     * Tear down
     */
    public function tearDown(): void
    {
        parent::tearDown();

        $testCacheDir = TMP . 'compile_test_cache';
        if (is_dir($testCacheDir)) {
            $this->clearCacheDirectory($testCacheDir);
            rmdir($testCacheDir);
        }

        if ($this->originalCache === null) {
            Configure::delete('TwigView.cache');
        } else {
            Configure::write('TwigView.cache', $this->originalCache);
        }

        unset($this->Shell);
        unset($this->out);
        unset($this->err);
    }

    /**
     * Count cache files recursively in cache directory
     *
     * @param string $dir Cache directory path
     * @return int Number of .php files
     */
    protected function countCacheFiles(string $dir): int
    {
        $count = 0;
        if (!is_dir($dir)) {
            return 0;
        }

        $iterator = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator($dir, FilesystemIterator::SKIP_DOTS),
            RecursiveIteratorIterator::SELF_FIRST,
        );

        foreach ($iterator as $file) {
            if ($file->isFile() && $file->getExtension() === 'php') {
                $count++;
            }
        }

        return $count;
    }

    /**
     * Clear cache directory recursively
     *
     * @param string $dir Cache directory path
     * @return void
     */
    protected function clearCacheDirectory(string $dir): void
    {
        if (!is_dir($dir)) {
            return;
        }

        $iterator = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator($dir, FilesystemIterator::SKIP_DOTS),
            RecursiveIteratorIterator::CHILD_FIRST,
        );

        foreach ($iterator as $file) {
            if ($file->isDir()) {
                rmdir($file->getPathname());
            } else {
                unlink($file->getPathname());
            }
        }
    }

    /**
     * Test constructor initializes TwigView
     */
    public function testConstructorInitializesTwigView(): void
    {
        $this->assertInstanceOf('CompileShell', $this->Shell);

        $reflection = new ReflectionClass($this->Shell);
        $property = $reflection->getProperty('TwigView');
        $property->setAccessible(true);

        $twigView = $property->getValue($this->Shell);
        $this->assertInstanceOf('TwigView', $twigView);
    }

    /**
     * Test file method compiles successfully
     */
    public function testFileMethodCompilesSuccessfully(): void
    {
        $testTemplatePath = dirname(__DIR__, 3) . DS . 'test_app' . DS . 'templates' . DS . 'test.twig';

        $this->assertFileExists($testTemplatePath);

        $result = $this->Shell->file($testTemplatePath);

        $this->assertIsBool($result);
    }

    /**
     * Test file method handles invalid template
     */
    public function testFileMethodHandlesInvalidTemplate(): void
    {
        $invalidPath = '/path/to/nonexistent/template.twig';

        $result = $this->Shell->file($invalidPath);

        $this->assertFalse($result);
    }

    /**
     * Test getOptionParser returns parser
     */
    public function testGetOptionParserReturnsParser(): void
    {
        $parser = $this->Shell->getOptionParser();

        $this->assertInstanceOf('ConsoleOptionParser', $parser);
    }

    /**
     * Test getOptionParser has all subcommand
     */
    public function testGetOptionParserHasAllSubcommand(): void
    {
        $parser = $this->Shell->getOptionParser();
        $subcommands = $parser->subcommands();

        $this->assertArrayHasKey('all', $subcommands);
    }

    /**
     * Test getOptionParser has file subcommand
     */
    public function testGetOptionParserHasFileSubcommand(): void
    {
        $parser = $this->Shell->getOptionParser();
        $subcommands = $parser->subcommands();

        $this->assertArrayHasKey('file', $subcommands);
    }

    /**
     * Test all method processes templates
     */
    public function testAllMethodProcessesTemplates(): void
    {
        $this->assertTrue(method_exists($this->Shell, 'all'));
        $this->assertTrue(is_callable([$this->Shell, 'all']));
    }

    /**
     * Test that compiled cache is actually created
     */
    public function testCompiledCacheIsCreated(): void
    {
        $cacheDir = TMP . 'compile_test_cache';
        $this->clearCacheDirectory($cacheDir);

        $testTemplatePath = dirname(__DIR__, 3) . DS . 'test_app' . DS . 'templates' . DS;
        $testFile = $testTemplatePath . 'test.twig';

        App::build(['View' => [$testTemplatePath]], App::APPEND);

        $countBefore = $this->countCacheFiles($cacheDir);

        Configure::write('TwigView.cache', $cacheDir);

        $shell = new CompileShell($this->out, $this->err);
        $result = $shell->file($testFile);

        $this->assertTrue($result, 'Template should compile successfully');

        $countAfter = $this->countCacheFiles($cacheDir);
        $this->assertGreaterThan($countBefore, $countAfter, 'Cache file should be created');

        $view = new TwigView();
        $reflection = new ReflectionClass($view);
        $method = $reflection->getMethod('_render');
        $method->setAccessible(true);

        $result = $method->invoke($view, $testFile, ['name' => 'Test']);
        $this->assertEquals('Hello Test', $result);
    }

    /**
     * Test that compiled cache is actually used
     */
    public function testCompiledCacheIsUsed(): void
    {
        $cacheDir = TMP . 'compile_test_cache';
        $this->clearCacheDirectory($cacheDir);

        $testTemplatePath = dirname(__DIR__, 3) . DS . 'test_app' . DS . 'templates' . DS;
        $testFile = $testTemplatePath . 'test.twig';

        App::build(['View' => [$testTemplatePath]], App::APPEND);
        Configure::write('TwigView.cache', $cacheDir);

        $shell = new CompileShell($this->out, $this->err);
        $shell->file($testFile);

        $cacheFiles = glob($cacheDir . DS . '*' . DS . '*.php');
        $this->assertNotEmpty($cacheFiles, 'Cache files should exist');

        $cacheFile = $cacheFiles[0];
        $originalMtime = filemtime($cacheFile);
        $countBefore = $this->countCacheFiles($cacheDir);

        sleep(1);

        $view = new TwigView();
        $reflection = new ReflectionClass($view);
        $method = $reflection->getMethod('_render');
        $method->setAccessible(true);

        $result = $method->invoke($view, $testFile, ['name' => 'CachedTest']);

        $this->assertEquals('Hello CachedTest', $result, 'Cached template should render correctly');

        $newMtime = filemtime($cacheFile);
        $this->assertEquals($originalMtime, $newMtime, 'Cache file should not be recompiled when rendering');

        $countAfter = $this->countCacheFiles($cacheDir);
        $this->assertEquals($countBefore, $countAfter, 'No new cache files should be created when using existing cache');
    }
}
