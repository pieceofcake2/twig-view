<?php
declare(strict_types=1);

namespace TwigView\Test\TestCase\Twig\Extension;

use CakeTestCase;
use Twig\Environment;
use Twig\Loader\ArrayLoader;
use TwigView\Twig\Extension\InflectorExtension;

/**
 * InflectorExtension Test
 */
class InflectorExtensionTest extends CakeTestCase
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
        $this->twig->addExtension(new InflectorExtension());
    }

    /**
     * Test pluralize filter
     *
     * @return void
     */
    public function testPluralize(): void
    {
        $template = $this->twig->createTemplate('{{ word|pluralize }}');
        $this->assertEquals('apples', $template->render(['word' => 'apple']));
        $this->assertEquals('people', $template->render(['word' => 'person']));
    }

    /**
     * Test singularize filter
     *
     * @return void
     */
    public function testSingularize(): void
    {
        $template = $this->twig->createTemplate('{{ word|singularize }}');
        $this->assertEquals('apple', $template->render(['word' => 'apples']));
        $this->assertEquals('person', $template->render(['word' => 'people']));
    }

    /**
     * Test camelize filter
     *
     * @return void
     */
    public function testCamelize(): void
    {
        $template = $this->twig->createTemplate('{{ word|camelize }}');
        $this->assertEquals('HelloWorld', $template->render(['word' => 'hello_world']));
        // Inflector::camelize does not process hyphens, only underscores
        $this->assertEquals('FooBar', $template->render(['word' => 'foo_bar']));
    }

    /**
     * Test underscore filter
     *
     * @return void
     */
    public function testUnderscore(): void
    {
        $template = $this->twig->createTemplate('{{ word|underscore }}');
        $this->assertEquals('hello_world', $template->render(['word' => 'HelloWorld']));
        $this->assertEquals('foo_bar', $template->render(['word' => 'FooBar']));
    }

    /**
     * Test humanize filter
     *
     * @return void
     */
    public function testHumanize(): void
    {
        $template = $this->twig->createTemplate('{{ word|humanize }}');
        $this->assertEquals('Hello World', $template->render(['word' => 'hello_world']));
        $this->assertEquals('Foo Bar', $template->render(['word' => 'foo_bar']));
    }

    /**
     * Test tableize filter
     *
     * @return void
     */
    public function testTableize(): void
    {
        $template = $this->twig->createTemplate('{{ word|tableize }}');
        $this->assertEquals('people', $template->render(['word' => 'Person']));
        $this->assertEquals('user_profiles', $template->render(['word' => 'UserProfile']));
    }

    /**
     * Test classify filter
     *
     * @return void
     */
    public function testClassify(): void
    {
        $template = $this->twig->createTemplate('{{ word|classify }}');
        $this->assertEquals('Person', $template->render(['word' => 'people']));
        $this->assertEquals('UserProfile', $template->render(['word' => 'user_profiles']));
    }

    /**
     * Test variable filter
     *
     * @return void
     */
    public function testVariable(): void
    {
        $template = $this->twig->createTemplate('{{ word|variable }}');
        $this->assertEquals('helloWorld', $template->render(['word' => 'hello_world']));
        $this->assertEquals('fooBar', $template->render(['word' => 'foo_bar']));
    }

    /**
     * Test slug filter
     *
     * @return void
     */
    public function testSlug(): void
    {
        $template = $this->twig->createTemplate('{{ word|slug("-") }}');
        // Inflector::slug uses underscore by default, pass '-' for hyphen separator
        $this->assertEquals('hello-world', $template->render(['word' => 'Hello World']));
        $this->assertEquals('foo-bar', $template->render(['word' => 'Foo Bar']));
    }

    /**
     * Test extension name
     *
     * @return void
     */
    public function testGetName(): void
    {
        $extension = new InflectorExtension();
        $this->assertEquals('inflector', $extension->getName());
    }
}
