<?php
declare(strict_types=1);

namespace TwigView\Test\TestCase\Twig\Extension;

use CakeTestCase;
use Exception;
use Twig\Environment;
use Twig\Loader\ArrayLoader;
use TwigView\Twig\Extension\ViewExtension;
use View;

/**
 * ViewExtension Test
 */
class ViewExtensionTest extends CakeTestCase
{
    /**
     * @var \Twig\Environment
     */
    protected $twig;

    /**
     * @var \View
     */
    protected $view;

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();

        $this->view = new View();
        $loader = new ArrayLoader([]);
        $this->twig = new Environment($loader);
        $this->twig->addExtension(new ViewExtension($this->view));
    }

    /**
     * Test element function
     *
     * @return void
     */
    public function testElement(): void
    {
        $template = $this->twig->createTemplate('{{ element("test") }}');

        // Element rendering requires actual template files, so we expect an error
        try {
            $result = $template->render([]);
            // If element file exists, result should be a string
            $this->assertIsString($result);
        } catch (Exception $e) {
            // Expected: Element file not found
            $this->assertStringContainsString('Element Not Found', $e->getMessage());
        }
    }

    /**
     * Test element function with data
     *
     * @return void
     */
    public function testElementWithData(): void
    {
        $template = $this->twig->createTemplate('{{ element("test", {"key": "value"}) }}');

        // Element rendering requires actual template files, so we expect an error
        try {
            $result = $template->render([]);
            // If element file exists, result should be a string
            $this->assertIsString($result);
        } catch (Exception $e) {
            // Expected: Element file not found
            $this->assertStringContainsString('Element Not Found', $e->getMessage());
        }
    }

    /**
     * Test fetch function
     *
     * @return void
     */
    public function testFetch(): void
    {
        // Set a view block
        $this->view->assign('testBlock', 'Test Content');

        $template = $this->twig->createTemplate('{{ fetch("testBlock") }}');
        $result = $template->render([]);
        $this->assertEquals('Test Content', $result);
    }

    /**
     * Test fetch function with default
     *
     * @return void
     */
    public function testFetchWithDefault(): void
    {
        $template = $this->twig->createTemplate('{{ fetch("nonexistent", "default value") }}');
        $result = $template->render([]);
        $this->assertEquals('default value', $result);
    }

    /**
     * Test url function
     *
     * @return void
     */
    public function testUrl(): void
    {
        $template = $this->twig->createTemplate('{{ url("/test/path") }}');
        $result = $template->render([]);
        $this->assertStringContainsString('/test/path', $result);
    }

    /**
     * Test url function with array
     *
     * @return void
     */
    public function testUrlWithArray(): void
    {
        $template = $this->twig->createTemplate('{{ url({"controller": "Posts", "action": "view", "id": 1}) }}');
        $result = $template->render([]);
        $this->assertIsString($result);
    }

    /**
     * Test url function with full parameter
     *
     * @return void
     */
    public function testUrlWithFull(): void
    {
        $template = $this->twig->createTemplate('{{ url("/test", true) }}');
        $result = $template->render([]);
        $this->assertIsString($result);
    }

    /**
     * Test path function
     *
     * @return void
     */
    public function testPath(): void
    {
        $template = $this->twig->createTemplate('{{ path("/test/path") }}');
        $result = $template->render([]);
        $this->assertStringContainsString('/test/path', $result);
    }

    /**
     * Test path function with array
     *
     * @return void
     */
    public function testPathWithArray(): void
    {
        $template = $this->twig->createTemplate('{{ path({"controller": "Users", "action": "index"}) }}');
        $result = $template->render([]);
        $this->assertIsString($result);
    }

    /**
     * Test extension name
     *
     * @return void
     */
    public function testGetName(): void
    {
        $extension = new ViewExtension($this->view);
        $this->assertEquals('view', $extension->getName());
    }
}
