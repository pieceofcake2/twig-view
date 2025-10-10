<?php
/**
 * Twig_Extension_Basic Test Case
 */

use Twig\Environment;
use Twig\Loader\ArrayLoader;

$twigPath = CakePlugin::path('TwigView');
require_once $twigPath . 'Lib' . DS . 'Twig_Extension_Basic.php';

class TwigExtensionBasicTest extends CakeTestCase
{
    /**
     * Twig Environment
     *
     * @var Environment
     */
    protected $twig;

    /**
     * Set up
     */
    public function setUp(): void
    {
        parent::setUp();

        $loader = new ArrayLoader([]);
        $this->twig = new Environment($loader);
        $this->twig->addExtension(new Twig_Extension_Basic());
    }

    /**
     * Tear down
     */
    public function tearDown(): void
    {
        parent::tearDown();
        unset($this->twig);
    }

    /**
     * Test getFilters
     */
    public function testGetFilters(): void
    {
        $extension = new Twig_Extension_Basic();
        $filters = $extension->getFilters();

        $this->assertIsArray($filters);
        $this->assertCount(5, $filters);

        $filterNames = [];
        foreach ($filters as $filter) {
            $this->assertInstanceOf('Twig\TwigFilter', $filter);
            $filterNames[] = $filter->getName();
        }

        $this->assertContains('debug', $filterNames);
        $this->assertContains('pr', $filterNames);
        $this->assertContains('low', $filterNames);
        $this->assertContains('up', $filterNames);
        $this->assertContains('env', $filterNames);
    }

    /**
     * Test low filter
     */
    public function testLowFilter(): void
    {
        $template = $this->twig->createTemplate('{{ text|low }}');
        $result = $template->render(['text' => 'FOO']);

        $this->assertEquals('foo', $result);
    }

    /**
     * Test up filter
     */
    public function testUpFilter(): void
    {
        $template = $this->twig->createTemplate('{{ text|up }}');
        $result = $template->render(['text' => 'foo']);

        $this->assertEquals('FOO', $result);
    }
}
