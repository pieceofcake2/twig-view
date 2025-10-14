<?php
declare(strict_types=1);

namespace TwigView\Test\TestCase\Twig;

use CakeTestCase;
use Twig\Error\LoaderError;
use Twig\Source;
use TwigView\Twig\FileLoader;

class FileLoaderTest extends CakeTestCase
{
    /**
     * Test template paths
     *
     * @var array
     */
    protected $testPaths;

    /**
     * FileLoader instance
     *
     * @var FileLoader
     */
    protected $loader;

    /**
     * Set up
     */
    public function setUp(): void
    {
        parent::setUp();

        $this->testPaths = [
            dirname(__DIR__, 2) . DS . 'test_app' . DS . 'templates' . DS,
        ];

        $this->loader = new FileLoader($this->testPaths, ['.twig']);
    }

    /**
     * Tear down
     */
    public function tearDown(): void
    {
        unset($this->loader);
        parent::tearDown();
    }

    /**
     * Test constructor
     */
    public function testConstructor(): void
    {
        $loader = new FileLoader($this->testPaths, ['.twig']);
        $this->assertInstanceOf(FileLoader::class, $loader);
        $this->assertEquals($this->testPaths, $loader->getPaths());
    }

    /**
     * Test constructor with default extensions
     */
    public function testConstructorWithDefaultExtensions(): void
    {
        $loader = new FileLoader($this->testPaths);
        $this->assertInstanceOf(FileLoader::class, $loader);
    }

    /**
     * Test setTheme
     */
    public function testSetTheme(): void
    {
        $this->loader->setTheme('TestTheme');
        $this->assertInstanceOf(FileLoader::class, $this->loader);
    }

    /**
     * Test setTheme with null
     */
    public function testSetThemeWithNull(): void
    {
        $this->loader->setTheme('TestTheme');
        $this->loader->setTheme(null);
        $this->assertInstanceOf(FileLoader::class, $this->loader);
    }

    /**
     * Test addPath
     */
    public function testAddPath(): void
    {
        $newPath = '/some/other/path/';
        $this->loader->addPath($newPath);

        $paths = $this->loader->getPaths();
        $this->assertContains($newPath, $paths);
    }

    /**
     * Test addPath does not add duplicate
     */
    public function testAddPathDoesNotAddDuplicate(): void
    {
        $existingPath = $this->testPaths[0];
        $this->loader->addPath($existingPath);

        $paths = $this->loader->getPaths();
        $count = count(array_keys($paths, $existingPath, true));
        $this->assertEquals(1, $count);
    }

    /**
     * Test getPaths
     */
    public function testGetPaths(): void
    {
        $paths = $this->loader->getPaths();
        $this->assertIsArray($paths);
        $this->assertEquals($this->testPaths, $paths);
    }

    /**
     * Test getSourceContext
     */
    public function testGetSourceContext(): void
    {
        $source = $this->loader->getSourceContext('test.twig');

        $this->assertInstanceOf(Source::class, $source);
        $this->assertEquals('Hello {{ name }}', $source->getCode());
    }

    /**
     * Test getSourceContext with absolute path
     */
    public function testGetSourceContextWithAbsolutePath(): void
    {
        $absolutePath = $this->testPaths[0] . 'test.twig';
        $source = $this->loader->getSourceContext($absolutePath);

        $this->assertInstanceOf(Source::class, $source);
        $this->assertEquals('Hello {{ name }}', $source->getCode());
    }

    /**
     * Test getSourceContext throws exception for missing template
     */
    public function testGetSourceContextThrowsExceptionForMissingTemplate(): void
    {
        $this->expectException(LoaderError::class);
        $this->expectExceptionMessage('Unable to find template');

        $this->loader->getSourceContext('nonexistent.twig');
    }

    /**
     * Test getCacheKey
     */
    public function testGetCacheKey(): void
    {
        $cacheKey = $this->loader->getCacheKey('test.twig');
        $expectedPath = $this->testPaths[0] . 'test.twig';

        $this->assertIsString($cacheKey);
        $this->assertEquals($expectedPath, $cacheKey);
    }

    /**
     * Test getCacheKey with absolute path
     */
    public function testGetCacheKeyWithAbsolutePath(): void
    {
        $absolutePath = $this->testPaths[0] . 'test.twig';
        $cacheKey = $this->loader->getCacheKey($absolutePath);

        $this->assertEquals($absolutePath, $cacheKey);
    }

    /**
     * Test isFresh
     */
    public function testIsFresh(): void
    {
        $time = time() + 3600;
        $result = $this->loader->isFresh('test.twig', $time);

        $this->assertTrue($result);
    }

    /**
     * Test isFresh returns false for old timestamp
     */
    public function testIsFreshReturnsFalseForOldTimestamp(): void
    {
        $time = 0;
        $result = $this->loader->isFresh('test.twig', $time);

        $this->assertFalse($result);
    }

    /**
     * Test exists
     */
    public function testExists(): void
    {
        $result = $this->loader->exists('test.twig');
        $this->assertTrue($result);
    }

    /**
     * Test exists returns false for missing template
     */
    public function testExistsReturnsFalseForMissingTemplate(): void
    {
        $result = $this->loader->exists('nonexistent.twig');
        $this->assertFalse($result);
    }

    /**
     * Test loading template without extension
     */
    public function testLoadingTemplateWithoutExtension(): void
    {
        $source = $this->loader->getSourceContext('test');

        $this->assertInstanceOf(Source::class, $source);
        $this->assertEquals('Hello {{ name }}', $source->getCode());
    }

    /**
     * Test loading template with custom extension
     */
    public function testLoadingTemplateWithCustomExtension(): void
    {
        $loader = new FileLoader($this->testPaths, ['.twig', '.html']);
        $source = $loader->getSourceContext('test.html');

        $this->assertInstanceOf(Source::class, $source);
    }

    /**
     * Test theme support
     */
    public function testThemeSupport(): void
    {
        $this->loader->setTheme('TestTheme');

        // Theme template should be found if it exists
        $this->assertInstanceOf(FileLoader::class, $this->loader);
    }

    /**
     * Test multiple extensions
     */
    public function testMultipleExtensions(): void
    {
        $loader = new FileLoader($this->testPaths, ['.twig', '.html', '.xml']);

        $this->assertInstanceOf(FileLoader::class, $loader);
    }

    /**
     * Test empty paths array
     */
    public function testEmptyPathsArray(): void
    {
        $loader = new FileLoader([], ['.twig']);

        $this->expectException(LoaderError::class);
        $loader->getSourceContext('test.twig');
    }

    /**
     * Test template with subdirectory
     */
    public function testTemplateWithSubdirectory(): void
    {
        $result = $this->loader->exists('test_with_element.twig');
        $this->assertTrue($result);
    }
}
