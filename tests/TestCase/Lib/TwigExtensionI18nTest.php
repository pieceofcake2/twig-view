<?php
/**
 * Twig_Extension_I18n Test Case
 */

use Twig\Environment;
use Twig\Loader\ArrayLoader;

$twigPath = CakePlugin::path('TwigView');
require_once $twigPath . 'Lib' . DS . 'Twig_Extension_I18n.php';

class TwigExtensionI18nTest extends CakeTestCase
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
        $this->twig->addExtension(new Twig_Extension_I18n());
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
        $extension = new Twig_Extension_I18n();
        $filters = $extension->getFilters();

        $this->assertIsArray($filters);
        $this->assertCount(1, $filters);
        $this->assertInstanceOf('Twig\TwigFilter', $filters[0]);
        $this->assertEquals('trans', $filters[0]->getName());
    }

    /**
     * Test trans filter
     */
    public function testTransFilter(): void
    {
        $template = $this->twig->createTemplate('{{ message|trans }}');
        $result = $template->render(['message' => 'Hello']);

        $this->assertEquals('Hello', $result);
    }

    /**
     * Test trans filter uses CakePHP __ function
     */
    public function testTransFilterUsesCakePHPFunction(): void
    {
        $template = $this->twig->createTemplate('{{ "test_string"|trans }}');
        $result = $template->render([]);

        // The __ function will return the string if no translation is found
        $this->assertEquals('test_string', $result);
    }
}
