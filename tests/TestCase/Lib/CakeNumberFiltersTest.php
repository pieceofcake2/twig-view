<?php
/**
 * Cake_Number_Filters Test Case
 */

$twigPath = CakePlugin::path('TwigView');
require_once $twigPath . 'Lib' . DS . 'Cake_Number_Filters.php';

class CakeNumberFiltersTest extends CakeTestCase
{
    /**
     * Filters instance
     *
     * @var Cake_Number_Filters
     */
    protected $filters;

    /**
     * Set up
     */
    public function setUp(): void
    {
        parent::setUp();

        // Create a mock View object
        $view = $this->getMockBuilder('View')
            ->disableOriginalConstructor()
            ->getMock();

        $this->filters = new Cake_Number_Filters($view);
    }

    /**
     * Tear down
     */
    public function tearDown(): void
    {
        parent::tearDown();
        unset($this->filters);
    }

    /**
     * Test size method
     */
    public function testSize(): void
    {
        $result = $this->filters->size(1024);
        $this->assertEquals('1 KB', $result);
    }

    /**
     * Test percentage method
     */
    public function testPercentage(): void
    {
        $result = $this->filters->percentage(2.5, 2);
        $this->assertEquals('2.50%', $result);
    }

    /**
     * Test currency method
     */
    public function testCurrency(): void
    {
        $result = $this->filters->currency(1234.56);
        $this->assertEquals('$1,234.56', $result);
    }

    /**
     * Test precision method
     */
    public function testPrecision(): void
    {
        $result = $this->filters->precision(3.14159, 2);
        $this->assertEquals('3.14', $result);
    }

    /**
     * Test precision with different precision values
     */
    public function testPrecisionWithDifferentValues(): void
    {
        $result = $this->filters->precision(3.14159, 4);
        $this->assertEquals('3.1416', $result);
    }
}
