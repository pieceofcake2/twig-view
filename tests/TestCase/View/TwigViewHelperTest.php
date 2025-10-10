<?php
/**
 * TwigView Helper Integration Test Case
 */

App::uses('TwigView', 'TwigView.View');
App::uses('Controller', 'Controller');

class TwigViewHelperTest extends CakeTestCase
{
    /**
     * TwigView instance
     *
     * @var TwigView
     */
    protected $View;

    /**
     * Controller instance
     *
     * @var Controller
     */
    protected $Controller;

    /**
     * Set up
     */
    public function setUp(): void
    {
        parent::setUp();

        // Create a real Controller
        $this->Controller = new Controller();
        $this->View = new TwigView($this->Controller);
    }

    /**
     * Tear down
     */
    public function tearDown(): void
    {
        parent::tearDown();
        unset($this->View);
        unset($this->Controller);
    }

    /**
     * Test TimeHelper integration through ago filter
     */
    public function testTimeHelperIntegration(): void
    {
        // Create a template using the ago filter
        $template = $this->View->Twig->createTemplate('{{ date|ago }}');

        // Test with a date 2 hours ago
        $twoHoursAgo = date('Y-m-d H:i:s', strtotime('-2 hours'));
        $result = $template->render(['date' => $twoHoursAgo]);

        // TimeHelper returns "2 hours ago" format
        $this->assertEquals('2 hours ago', $result);
    }

    /**
     * Test NumberHelper integration through size filter
     */
    public function testNumberHelperSizeFilter(): void
    {
        $template = $this->View->Twig->createTemplate('{{ bytes|size }}');

        // Test with 1024 bytes (1 KB)
        $result = $template->render(['bytes' => 1024]);
        $this->assertEquals('1 KB', $result);

        // Test with 1048576 bytes (1 MB)
        $result = $template->render(['bytes' => 1048576]);
        $this->assertEquals('1.00 MB', $result);

        // Test with 1073741824 bytes (1 GB)
        $result = $template->render(['bytes' => 1073741824]);
        $this->assertEquals('1.00 GB', $result);

        // Test with 1536 bytes (rounds to 2 KB)
        $result = $template->render(['bytes' => 1536]);
        $this->assertEquals('2 KB', $result);

        // Test with 2621440 bytes (2.5 MB)
        $result = $template->render(['bytes' => 2621440]);
        $this->assertEquals('2.50 MB', $result);
    }

    /**
     * Test NumberHelper integration through precision filter
     */
    public function testNumberHelperPrecisionFilter(): void
    {
        $template = $this->View->Twig->createTemplate('{{ number|p(2) }}');

        $result = $template->render(['number' => 3.14159]);
        $this->assertEquals('3.14', $result);

        // Test with 3 decimal places
        $template = $this->View->Twig->createTemplate('{{ number|p(3) }}');
        $result = $template->render(['number' => 3.14159]);
        $this->assertEquals('3.142', $result);
    }

    /**
     * Test NumberHelper integration through currency filter
     */
    public function testNumberHelperCurrencyFilter(): void
    {
        $template = $this->View->Twig->createTemplate('{{ amount|curr }}');

        // Default USD currency
        $result = $template->render(['amount' => 1234.56]);
        $this->assertEquals('$1,234.56', $result);

        // Test with GBP
        $template = $this->View->Twig->createTemplate('{{ amount|curr("GBP") }}');
        $result = $template->render(['amount' => 1234.56]);
        $this->assertEquals('£1,234.56', $result);

        // Test with EUR
        $template = $this->View->Twig->createTemplate('{{ amount|curr("EUR") }}');
        $result = $template->render(['amount' => 1234.56]);
        $this->assertEquals('€1.234,56', $result);
    }

    /**
     * Test NumberHelper integration through percentage filter
     */
    public function testNumberHelperPercentageFilter(): void
    {
        $template = $this->View->Twig->createTemplate('{{ ratio|pct }}');

        $result = $template->render(['ratio' => 2.5]);
        $this->assertEquals('2.50%', $result);

        // Test with different precision
        $template = $this->View->Twig->createTemplate('{{ ratio|pct(1) }}');
        $result = $template->render(['ratio' => 2.555]);
        $this->assertEquals('2.6%', $result);
    }

    /**
     * Test multiple helpers in one template
     */
    public function testMultipleHelpersInTemplate(): void
    {
        $template = $this->View->Twig->createTemplate(
            'Date: {{ date|ago }}, Size: {{ bytes|size }}, Price: {{ price|curr }}',
        );

        $oneDayAgo = date('Y-m-d H:i:s', strtotime('-1 day'));
        $result = $template->render([
            'date' => $oneDayAgo,
            'bytes' => 1048576, // 1 MB
            'price' => 99.99,
        ]);

        // Verify exact formatted output from all helpers
        $this->assertEquals('Date: 1 day ago, Size: 1.00 MB, Price: $99.99', $result);
    }

    /**
     * Test that helpers are accessible in Twig context
     */
    public function testHelpersAccessibleInContext(): void
    {
        // Load some helpers
        $this->View->loadHelper('Time');
        $this->View->loadHelper('Form');
        $this->View->loadHelper('Html');

        $helpers = $this->View->Helpers->attached();

        // Should have loaded helpers
        $this->assertContains('Time', $helpers);
        $this->assertContains('Form', $helpers);
        $this->assertContains('Html', $helpers);
    }

    /**
     * Test basic filter functionality
     */
    public function testBasicFilters(): void
    {
        // Test low filter (strtolower)
        $template = $this->View->Twig->createTemplate('{{ text|low }}');
        $result = $template->render(['text' => 'HELLO']);
        $this->assertEquals('hello', $result);

        // Test up filter (strtoupper)
        $template = $this->View->Twig->createTemplate('{{ text|up }}');
        $result = $template->render(['text' => 'hello']);
        $this->assertEquals('HELLO', $result);
    }

    /**
     * Test trans filter
     */
    public function testTransFilter(): void
    {
        $template = $this->View->Twig->createTemplate('{{ message|trans }}');
        $result = $template->render(['message' => 'Hello World']);

        // Should return the translated string (or original if no translation)
        $this->assertEquals('Hello World', $result);
    }
}
