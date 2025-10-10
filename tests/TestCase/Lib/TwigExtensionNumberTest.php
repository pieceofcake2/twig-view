<?php
/**
 * Twig_Extension_Number Test Case
 */

use Twig\Environment;
use Twig\Loader\ArrayLoader;

$twigPath = CakePlugin::path('TwigView');
require_once $twigPath . 'Lib' . DS . 'Cake_Number_Filters.php';
require_once $twigPath . 'Lib' . DS . 'Twig_Extension_Number.php';

class TwigExtensionNumberTest extends CakeTestCase
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

        $this->twig->addExtension(new Twig_Extension_Number($view));
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

        $extension = new Twig_Extension_Number($view);
        $filters = $extension->getFilters();

        $this->assertIsArray($filters);
        $this->assertCount(4, $filters);

        $filterNames = [];
        foreach ($filters as $filter) {
            $this->assertInstanceOf('Twig\TwigFilter', $filter);
            $filterNames[] = $filter->getName();
        }

        $this->assertContains('size', $filterNames);
        $this->assertContains('pct', $filterNames);
        $this->assertContains('curr', $filterNames);
        $this->assertContains('p', $filterNames);
    }

    /**
     * Test precision filter
     */
    public function testPrecisionFilter(): void
    {
        $template = $this->twig->createTemplate('{{ num|p(2) }}');
        $result = $template->render(['num' => 0.555]);

        $this->assertEquals('0.56', $result);
    }

    /**
     * Test toReadableSize filter
     */
    public function testSizeFilter(): void
    {
        $template = $this->twig->createTemplate('{{ num|size }}');
        $result = $template->render(['num' => 1024]);

        $this->assertEquals('1 KB', $result);
    }

    /**
     * Test percentage filter
     */
    public function testPercentageFilter(): void
    {
        $template = $this->twig->createTemplate('{{ num|pct }}');
        $result = $template->render(['num' => 2.3]);

        $this->assertEquals('2.30%', $result);
    }

    /**
     * Test currency filter
     */
    public function testCurrencyFilter(): void
    {
        $template = $this->twig->createTemplate('{{ num|curr }}');
        $result = $template->render(['num' => 5999]);

        $this->assertEquals('$5,999.00', $result);
    }
}
