<?php
declare(strict_types=1);

namespace TwigView\Test\TestCase\Twig\Extension;

use CakeTestCase;
use Twig\Environment;
use Twig\Loader\ArrayLoader;
use TwigView\Twig\Extension\NumberExtension;

/**
 * NumberExtension Test
 */
class NumberExtensionTest extends CakeTestCase
{
    /**
     * @var \Twig\Environment
     */
    protected $twig;

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();

        $loader = new ArrayLoader([]);
        $this->twig = new Environment($loader);
        $this->twig->addExtension(new NumberExtension());
    }

    /**
     * Test to_readable_size filter
     *
     * @return void
     */
    public function testToReadableSize(): void
    {
        $template = $this->twig->createTemplate('{{ size|to_readable_size }}');
        $result = $template->render(['size' => 1024]);
        $this->assertStringContainsString('KB', $result);

        $result = $template->render(['size' => 1048576]);
        $this->assertStringContainsString('MB', $result);
    }

    /**
     * Test toReadableSize alias
     *
     * @return void
     */
    public function testToReadableSizeAlias(): void
    {
        $template = $this->twig->createTemplate('{{ size|toReadableSize }}');
        $result = $template->render(['size' => 1024]);
        $this->assertStringContainsString('KB', $result);
    }

    /**
     * Test to_percentage filter
     *
     * @return void
     */
    public function testToPercentage(): void
    {
        $template = $this->twig->createTemplate('{{ num|to_percentage }}');
        $result = $template->render(['num' => 0.5]);
        $this->assertStringContainsString('50', $result);
        $this->assertStringContainsString('%', $result);
    }

    /**
     * Test toPercentage alias
     *
     * @return void
     */
    public function testToPercentageAlias(): void
    {
        $template = $this->twig->createTemplate('{{ num|toPercentage }}');
        $result = $template->render(['num' => 0.75]);
        $this->assertStringContainsString('75', $result);
    }

    /**
     * Test format_delta filter
     *
     * @return void
     */
    public function testFormatDelta(): void
    {
        $template = $this->twig->createTemplate('{{ num|format_delta }}');
        $result = $template->render(['num' => 10]);
        $this->assertStringContainsString('+', $result);

        $result = $template->render(['num' => -10]);
        $this->assertStringContainsString('-', $result);
    }

    /**
     * Test formatDelta alias
     *
     * @return void
     */
    public function testFormatDeltaAlias(): void
    {
        $template = $this->twig->createTemplate('{{ num|formatDelta }}');
        $result = $template->render(['num' => 5]);
        $this->assertStringContainsString('+', $result);
    }

    /**
     * Test currency filter
     *
     * @return void
     */
    public function testCurrency(): void
    {
        $template = $this->twig->createTemplate('{{ num|currency }}');
        $result = $template->render(['num' => 1234.56]);
        $this->assertStringContainsString('1,234.56', $result);
    }

    /**
     * Test precision filter
     *
     * @return void
     */
    public function testPrecision(): void
    {
        $template = $this->twig->createTemplate('{{ num|precision(2) }}');
        $result = $template->render(['num' => 3.14159]);
        $this->assertEquals('3.14', $result);
    }

    /**
     * Test extension name
     *
     * @return void
     */
    public function testGetName(): void
    {
        $extension = new NumberExtension();
        $this->assertEquals('number', $extension->getName());
    }
}
