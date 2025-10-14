<?php
declare(strict_types=1);

namespace TwigView\Test\TestCase\Twig\Extension;

use CakeTestCase;
use Twig\Environment;
use Twig\Loader\ArrayLoader;
use TwigView\Twig\Extension\UtilsExtension;

/**
 * UtilsExtension Test
 */
class UtilsExtensionTest extends CakeTestCase
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
        $this->twig->addExtension(new UtilsExtension());
    }

    /**
     * Test multibyte test with multibyte string
     *
     * @return void
     */
    public function testMultibyteWithMultibyteString(): void
    {
        $template = $this->twig->createTemplate('{% if text is multibyte %}YES{% else %}NO{% endif %}');
        $result = $template->render(['text' => 'こんにちは']);
        $this->assertEquals('YES', $result);
    }

    /**
     * Test multibyte test with ASCII string
     *
     * @return void
     */
    public function testMultibyteWithAsciiString(): void
    {
        $template = $this->twig->createTemplate('{% if text is multibyte %}YES{% else %}NO{% endif %}');
        $result = $template->render(['text' => 'hello']);
        $this->assertEquals('NO', $result);
    }

    /**
     * Test multibyte test with mixed string
     *
     * @return void
     */
    public function testMultibyteWithMixedString(): void
    {
        $template = $this->twig->createTemplate('{% if text is multibyte %}YES{% else %}NO{% endif %}');
        $result = $template->render(['text' => 'Hello 世界']);
        $this->assertEquals('YES', $result);
    }

    /**
     * Test multibyte test with emoji
     *
     * @return void
     */
    public function testMultibyteWithEmoji(): void
    {
        $template = $this->twig->createTemplate('{% if text is multibyte %}YES{% else %}NO{% endif %}');
        $result = $template->render(['text' => '👋']);
        $this->assertEquals('YES', $result);
    }

    /**
     * Test extension name
     *
     * @return void
     */
    public function testGetName(): void
    {
        $extension = new UtilsExtension();
        $this->assertEquals('utils', $extension->getName());
    }
}
