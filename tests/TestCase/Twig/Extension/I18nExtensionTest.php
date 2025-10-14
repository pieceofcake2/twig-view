<?php
declare(strict_types=1);

namespace TwigView\Test\TestCase\Twig\Extension;

use CakeTestCase;
use Twig\Environment;
use Twig\Loader\ArrayLoader;
use TwigView\Twig\Extension\I18nExtension;

/**
 * I18nExtension Test
 */
class I18nExtensionTest extends CakeTestCase
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
        $this->twig->addExtension(new I18nExtension());
    }

    /**
     * Test trans filter
     *
     * @return void
     */
    public function testTransFilter(): void
    {
        $template = $this->twig->createTemplate('{{ "Hello World"|trans }}');
        $result = $template->render([]);
        $this->assertEquals('Hello World', $result);
    }

    /**
     * Test __ function
     *
     * @return void
     */
    public function testDoubleUnderscoreFunction(): void
    {
        $template = $this->twig->createTemplate('{{ __("Hello World") }}');
        $result = $template->render([]);
        $this->assertEquals('Hello World', $result);
    }

    /**
     * Test __d function
     *
     * @return void
     */
    public function testDomainFunction(): void
    {
        $template = $this->twig->createTemplate('{{ __d("default", "Hello World") }}');
        $result = $template->render([]);
        $this->assertEquals('Hello World', $result);
    }

    /**
     * Test __n function
     *
     * @return void
     */
    public function testPluralFunction(): void
    {
        $template = $this->twig->createTemplate('{{ __n("one item", "%d items", count) }}');

        $result = $template->render(['count' => 1]);
        $this->assertEquals('one item', $result);

        $result = $template->render(['count' => 5]);
        $this->assertEquals('5 items', $result);
    }

    /**
     * Test trans tag
     *
     * @return void
     */
    public function testTransTag(): void
    {
        $template = $this->twig->createTemplate('{% trans %}Hello World{% endtrans %}');
        $result = $template->render([]);
        $this->assertEquals('Hello World', $result);
    }

    /**
     * Test trans tag with variable
     *
     * @return void
     */
    public function testTransTagWithVariable(): void
    {
        $template = $this->twig->createTemplate('{% trans %}Hello {{ name }}{% endtrans %}');
        $result = $template->render(['name' => 'John']);
        $this->assertEquals('Hello John', $result);
    }

    /**
     * Test trans tag with plural
     *
     * @return void
     */
    public function testTransTagWithPlural(): void
    {
        $template = $this->twig->createTemplate('{% trans %}One item{% plural count %}{{ count }} items{% endtrans %}');

        $result = $template->render(['count' => 1]);
        $this->assertEquals('One item', $result);

        $result = $template->render(['count' => 5]);
        $this->assertEquals('5 items', $result);
    }

    /**
     * Test extension name
     *
     * @return void
     */
    public function testGetName(): void
    {
        $extension = new I18nExtension();
        $this->assertEquals('i18n', $extension->getName());
    }
}
