<?php
/**
 * Twig_Extension_Ago Test Case
 */

use Twig\Environment;
use Twig\Loader\ArrayLoader;

$twigPath = CakePlugin::path('TwigView');
require_once $twigPath . 'Lib' . DS . 'Twig_Extension_Ago.php';

class TwigExtensionAgoTest extends CakeTestCase
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

        // Create a mock View object
        $view = $this->getMockBuilder('View')
            ->disableOriginalConstructor()
            ->getMock();

        $this->twig->addExtension(new Twig_Extension_Ago($view));
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
        $view = $this->getMockBuilder('View')
            ->disableOriginalConstructor()
            ->getMock();

        $extension = new Twig_Extension_Ago($view);
        $filters = $extension->getFilters();

        $this->assertIsArray($filters);
        $this->assertCount(1, $filters);
        $this->assertInstanceOf('Twig\TwigFilter', $filters[0]);
        $this->assertEquals('ago', $filters[0]->getName());
    }

    /**
     * Test ago filter
     */
    public function testAgoFilter(): void
    {
        $template = $this->twig->createTemplate('{{ date|ago }}');
        $twoHoursAgo = date('Y-m-d H:i:s', strtotime('-2 hours'));
        $result = $template->render(['date' => $twoHoursAgo]);

        $this->assertEquals('2 hours ago', $result);
    }
}
