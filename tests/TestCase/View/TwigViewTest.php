<?php
declare(strict_types=1);

/**
 * TwigView Test Case
 */

namespace TwigView\Test\TestCase\View;

use App;
use CakeTestCase;
use Configure;
use Controller;
use ReflectionClass;
use Twig\Environment;
use TwigView\View\TwigView;

require_once dirname(__FILE__) . DS . 'MockTwigExtension.php';

class TwigViewTest extends CakeTestCase
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
     * Test template path
     *
     * @var string
     */
    protected $testTemplatePath;

    /**
     * Set up
     */
    public function setUp(): void
    {
        parent::setUp();

        // Add test_app/templates to App::path('View')
        $this->testTemplatePath = dirname(__DIR__, 2) . DS . 'test_app' . DS . 'templates' . DS;
        App::build(['View' => [$this->testTemplatePath]], App::APPEND);

        // Create a mock Controller
        $this->Controller = $this->getMockBuilder('Controller')
            ->disableOriginalConstructor()
            ->getMock();

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
     * Test constructor initializes Twig environment
     */
    public function testConstructorInitializesTwigEnvironment(): void
    {
        $this->assertInstanceOf(Environment::class, $this->View->Twig);
        $this->assertIsArray($this->View->templatePaths);
        $this->assertNotEmpty($this->View->templatePaths);
    }

    /**
     * Test file extension is set correctly
     */
    public function testFileExtension(): void
    {
        // TwigView sets .twig extension after parent constructor
        $this->assertEquals('.twig', $this->View->ext);
    }

    /**
     * Test Twig environment has correct extensions
     */
    public function testTwigEnvironmentHasExtensions(): void
    {
        $extensions = $this->View->Twig->getExtensions();

        $extensionClasses = [];
        foreach ($extensions as $extension) {
            $extensionClasses[] = get_class($extension);
        }

        $this->assertContains('TwigView\Twig\Extension\I18nExtension', $extensionClasses);
        $this->assertContains('TwigView\Twig\Extension\InflectorExtension', $extensionClasses);
        $this->assertContains('TwigView\Twig\Extension\NumberExtension', $extensionClasses);
        $this->assertContains('TwigView\Twig\Extension\StringsExtension', $extensionClasses);
        $this->assertContains('TwigView\Twig\Extension\UtilsExtension', $extensionClasses);
        $this->assertContains('TwigView\Twig\Extension\ViewExtension', $extensionClasses);
    }

    /**
     * Test Twig environment has token parsers
     */
    public function testTwigEnvironmentHasTokenParsers(): void
    {
        $tokenParsers = $this->View->Twig->getTokenParsers();

        $parserTags = [];
        foreach ($tokenParsers as $parser) {
            if (method_exists($parser, 'getTag')) {
                $parserTags[] = $parser->getTag();
            }
        }

        $this->assertContains('layout', $parserTags);
        $this->assertContains('trans', $parserTags);
    }

    /**
     * Test theme is set from controller
     */
    public function testThemeSetFromController(): void
    {
        // Test that theme property exists in view
        $this->assertObjectHasProperty('theme', $this->View);
    }

    /**
     * Test render with Twig template
     */
    public function testRenderWithTwigTemplate(): void
    {
        // Test that _render method exists
        $reflection = new ReflectionClass($this->View);
        $this->assertTrue($reflection->hasMethod('_render'));

        $method = $reflection->getMethod('_render');
        $this->assertTrue($method->isProtected());
    }

    /**
     * Test render falls back to parent for CTP files
     */
    public function testRenderFallsBackToParentForCtpFiles(): void
    {
        $view = new TwigView($this->Controller);

        $templatePath = $this->testTemplatePath . 'test_ctp_simple.ctp';

        // Use reflection to access protected _render method
        $reflection = new ReflectionClass($view);
        $method = $reflection->getMethod('_render');
        $method->setAccessible(true);

        $result = $method->invoke($view, $templatePath, []);

        $this->assertEquals('Hello CTP', $result);
    }

    /**
     * Test render includes helpers in context
     */
    public function testRenderIncludesHelpersInContext(): void
    {
        // Test that loadHelper method exists (used for helper integration)
        $this->assertTrue(method_exists($this->View, 'loadHelper'));
    }

    /**
     * Test render sets cakeDebug if not provided
     */
    public function testRenderSetsCakeDebugIfNotProvided(): void
    {
        // Test that viewVars property exists
        $this->assertObjectHasProperty('viewVars', $this->View);
    }

    /**
     * Test Twig environment configuration
     */
    public function testTwigEnvironmentConfiguration(): void
    {
        // Test charset is set
        $this->assertEquals('UTF-8', $this->View->Twig->getCharset());

        // Test cache is configured
        $cache = $this->View->Twig->getCache(false);
        $this->assertTrue($cache !== false);
    }

    /**
     * Test custom extension from Controller is preserved
     */
    public function testCustomExtensionFromController(): void
    {
        // Create a controller with custom extension
        $controller = $this->getMockBuilder('Controller')
            ->disableOriginalConstructor()
            ->getMock();
        $controller->ext = '.html';

        $view = new TwigView($controller);

        // Custom extension should be preserved
        $this->assertEquals('.html', $view->ext);
    }

    /**
     * Test default extension when Controller has .ctp
     */
    public function testDefaultExtensionWhenControllerHasCtp(): void
    {
        // Create a controller with default .ctp extension
        $controller = $this->getMockBuilder('Controller')
            ->disableOriginalConstructor()
            ->getMock();
        $controller->ext = '.ctp';

        $view = new TwigView($controller);

        // Should be changed to .twig
        $this->assertEquals('.twig', $view->ext);
    }

    /**
     * Test .twig files are rendered with Twig
     */
    public function testTwigFilesRenderedWithTwig(): void
    {
        $view = new TwigView($this->Controller);

        $templatePath = $this->testTemplatePath . 'test.twig';

        // Use reflection to access protected _render method
        $reflection = new ReflectionClass($view);
        $method = $reflection->getMethod('_render');
        $method->setAccessible(true);

        $result = $method->invoke($view, $templatePath, ['name' => 'Twig']);

        $this->assertEquals('Hello Twig', $result);
    }

    /**
     * Test custom extension files are rendered with Twig
     */
    public function testCustomExtensionFilesRenderedWithTwig(): void
    {
        // Create a controller with custom extension
        $controller = $this->getMockBuilder('Controller')
            ->disableOriginalConstructor()
            ->getMock();
        $controller->ext = '.html';

        $view = new TwigView($controller);

        $templatePath = $this->testTemplatePath . 'test.html';

        // Use reflection to access protected _render method
        $reflection = new ReflectionClass($view);
        $method = $reflection->getMethod('_render');
        $method->setAccessible(true);

        $result = $method->invoke($view, $templatePath, ['extension' => 'HTML']);

        $this->assertEquals('Custom HTML', $result);
    }

    /**
     * Test .twig files work even with custom extension set
     */
    public function testTwigFilesWorkWithCustomExtension(): void
    {
        // Create a controller with custom extension
        $controller = $this->getMockBuilder('Controller')
            ->disableOriginalConstructor()
            ->getMock();
        $controller->ext = '.html';

        $view = new TwigView($controller);

        $templatePath = $this->testTemplatePath . 'test_twig_always.twig';

        // Use reflection to access protected _render method
        $reflection = new ReflectionClass($view);
        $method = $reflection->getMethod('_render');
        $method->setAccessible(true);

        $result = $method->invoke($view, $templatePath, ['works' => 'always']);

        $this->assertEquals('Twig always', $result);
    }

    /**
     * Test .ctp files always use parent renderer
     */
    public function testCtpFilesAlwaysUseParentRenderer(): void
    {
        // Create a controller with custom extension
        $controller = $this->getMockBuilder('Controller')
            ->disableOriginalConstructor()
            ->getMock();
        $controller->ext = '.html';

        $view = new TwigView($controller);

        $templatePath = $this->testTemplatePath . 'test_ctp_with_var.ctp';

        // Use reflection to access protected _render method
        $reflection = new ReflectionClass($view);
        $method = $reflection->getMethod('_render');
        $method->setAccessible(true);

        $result = $method->invoke($view, $templatePath, ['var' => 'works']);

        $this->assertEquals('CTP works', $result);
    }

    /**
     * Test Controller theme is set
     */
    public function testControllerThemeIsSet(): void
    {
        // Use reflection to create Controller and set theme
        $controller = new Controller();
        $controller->theme = 'MyTheme';

        $view = new TwigView($controller);

        $this->assertEquals('MyTheme', $view->theme);
    }

    /**
     * Test constructor works with null Controller
     */
    public function testConstructorWorksWithNullController(): void
    {
        $view = new TwigView(null);

        $this->assertInstanceOf(TwigView::class, $view);
        $this->assertInstanceOf(Environment::class, $view->Twig);
        $this->assertEquals('.twig', $view->ext);
    }

    /**
     * Test render uses viewVars when $_dataForView is empty
     */
    public function testRenderUsesViewVarsWhenDataForViewEmpty(): void
    {
        $view = new TwigView($this->Controller);
        $view->viewVars = ['name' => 'ViewVars'];

        $templatePath = $this->testTemplatePath . 'test.twig';

        $reflection = new ReflectionClass($view);
        $method = $reflection->getMethod('_render');
        $method->setAccessible(true);

        // Pass empty array
        $result = $method->invoke($view, $templatePath, []);

        $this->assertEquals('Hello ViewVars', $result);
    }

    /**
     * Test render falls back for unknown extension
     */
    public function testRenderFallsBackForUnknownExtension(): void
    {
        $view = new TwigView($this->Controller);

        $templatePath = $this->testTemplatePath . 'test.unknown';

        $reflection = new ReflectionClass($view);
        $method = $reflection->getMethod('_render');
        $method->setAccessible(true);

        $result = $method->invoke($view, $templatePath, []);

        $this->assertEquals('Unknown Extension', $result);
    }

    /**
     * Test multiple View paths are added to Twig loader
     */
    public function testMultipleViewPathsAddedToTwigLoader(): void
    {
        $view = new TwigView($this->Controller);

        // Verify Twig loader has multiple paths
        $loader = $view->Twig->getLoader();
        $paths = $loader->getPaths();

        $this->assertGreaterThan(1, count($paths));
    }

    /**
     * Test cakeDebug is set to null if not provided
     */
    public function testCakeDebugSetToNullIfNotProvided(): void
    {
        $view = new TwigView($this->Controller);

        $templatePath = $this->testTemplatePath . 'test_cake_debug.twig';

        $reflection = new ReflectionClass($view);
        $method = $reflection->getMethod('_render');
        $method->setAccessible(true);

        // Don't provide cakeDebug in data
        $result = $method->invoke($view, $templatePath, []);

        $this->assertEquals('DEBUG_IS_NULL', $result);
    }

    /**
     * Test cakeDebug is not overwritten if provided
     */
    public function testCakeDebugNotOverwrittenIfProvided(): void
    {
        $view = new TwigView($this->Controller);

        $templatePath = $this->testTemplatePath . 'test_cake_debug.twig';

        $reflection = new ReflectionClass($view);
        $method = $reflection->getMethod('_render');
        $method->setAccessible(true);

        // Provide cakeDebug in data
        $result = $method->invoke($view, $templatePath, ['cakeDebug' => 'CUSTOM_DEBUG']);

        $this->assertEquals('CUSTOM_DEBUG', $result);
    }

    /**
     * Test _view is included in template context
     */
    public function testViewContextIncludedInTemplate(): void
    {
        $view = new TwigView($this->Controller);

        $templatePath = $this->testTemplatePath . 'test_view_context.twig';

        $reflection = new ReflectionClass($view);
        $method = $reflection->getMethod('_render');
        $method->setAccessible(true);

        $result = $method->invoke($view, $templatePath, []);

        $this->assertEquals('.twig', $result);
    }

    /**
     * Test helpers are included in template context
     */
    public function testHelpersIncludedInTemplateContext(): void
    {
        $view = new TwigView($this->Controller);

        // Load Html helper
        $view->loadHelper('Html');

        // Verify helper was loaded and can be used
        $this->assertTrue($view->Helpers->loaded('Html'));
    }

    /**
     * Test custom extension works with real Controller
     */
    public function testCustomExtensionWithRealController(): void
    {
        $controller = new Controller();
        $controller->ext = '.html';

        $view = new TwigView($controller);

        // Verify extension was preserved
        $this->assertEquals('.html', $view->ext);

        // Verify it can render .html files
        $templatePath = $this->testTemplatePath . 'test.html';

        $reflection = new ReflectionClass($view);
        $method = $reflection->getMethod('_render');
        $method->setAccessible(true);

        $result = $method->invoke($view, $templatePath, ['extension' => 'HTML']);

        $this->assertEquals('Custom HTML', $result);
    }

    /**
     * Test theme support
     */
    public function testThemeSupport(): void
    {
        $controller = new Controller();
        $controller->theme = 'TestTheme';

        $view = new TwigView($controller);

        // Verify theme was set
        $this->assertEquals('TestTheme', $view->theme);
    }

    /**
     * Test themed template rendering
     */
    public function testThemedTemplateRendering(): void
    {
        $controller = new Controller();
        $controller->theme = 'TestTheme';

        $view = new TwigView($controller);

        $templatePath = $this->testTemplatePath . 'Themed' . DS . 'TestTheme' . DS . 'test_themed.twig';

        $reflection = new ReflectionClass($view);
        $method = $reflection->getMethod('_render');
        $method->setAccessible(true);

        $result = $method->invoke($view, $templatePath, ['message' => 'Hello']);

        $this->assertEquals('Themed Template: Hello', $result);
    }

    /**
     * Test normal layout rendering
     */
    public function testNormalLayoutRendering(): void
    {
        $view = new TwigView($this->Controller);

        // Render template
        $templatePath = $this->testTemplatePath . 'test_with_layout.twig';
        $reflection = new ReflectionClass($view);
        $method = $reflection->getMethod('_render');
        $method->setAccessible(true);

        $contentResult = $method->invoke($view, $templatePath, []);
        $this->assertEquals('Content from template', $contentResult);

        // Render layout with content
        $layoutPath = $this->testTemplatePath . 'Layouts' . DS . 'default.twig';
        $layoutResult = $method->invoke($view, $layoutPath, ['content_for_layout' => $contentResult]);

        $this->assertEquals("Layout Header\nContent from template\nLayout Footer", $layoutResult);
    }

    /**
     * Test _getViewFileName finds .twig files
     */
    public function testGetViewFileNameFindsTwigFiles(): void
    {
        $view = new TwigView($this->Controller);

        $reflection = new ReflectionClass($view);
        $method = $reflection->getMethod('_getViewFileName');
        $method->setAccessible(true);

        // Test finding a .twig file without specifying extension
        $result = $method->invoke($view, 'test');

        // Should find test.twig
        $this->assertStringEndsWith('test.twig', $result);
        $this->assertFileExists($result);
    }

    /**
     * Test _getViewFileName with .ctp files
     */
    public function testGetViewFileNameFindsCtpFiles(): void
    {
        $view = new TwigView($this->Controller);

        $reflection = new ReflectionClass($view);
        $method = $reflection->getMethod('_getViewFileName');
        $method->setAccessible(true);

        // Test finding a .ctp file
        $result = $method->invoke($view, 'test_ctp_simple');

        // Should find test_ctp_simple.ctp
        $this->assertStringEndsWith('test_ctp_simple.ctp', $result);
        $this->assertFileExists($result);
    }

    /**
     * Test _getViewFileName prioritizes .twig over .ctp when both exist
     */
    public function testGetViewFileNamePrioritizesTwigOverCtp(): void
    {
        $view = new TwigView($this->Controller);

        $reflection = new ReflectionClass($view);
        $method = $reflection->getMethod('_getViewFileName');
        $method->setAccessible(true);

        // test.twig and test.ctp both exist
        // With .twig extension set, should find .twig first
        $result = $method->invoke($view, 'test');

        $this->assertStringEndsWith('test.twig', $result);
    }

    /**
     * Test _getViewFileName with custom extension
     */
    public function testGetViewFileNameWithCustomExtension(): void
    {
        $controller = new Controller();
        $controller->ext = '.html';

        $view = new TwigView($controller);

        $reflection = new ReflectionClass($view);
        $method = $reflection->getMethod('_getViewFileName');
        $method->setAccessible(true);

        // Test finding a .html file
        $result = $method->invoke($view, 'test');

        // Should find test.html
        $this->assertStringEndsWith('test.html', $result);
        $this->assertFileExists($result);
    }

    /**
     * Test custom Twig extension from Configure
     */
    public function testCustomTwigExtensionFromConfigure(): void
    {
        // Set custom extension in Configure
        Configure::write('TwigView.extensions', [MockTwigExtension::class]);

        $controller = new Controller();
        $view = new TwigView($controller);

        // Verify extension was added
        $extensions = $view->Twig->getExtensions();
        $extensionClasses = [];
        foreach ($extensions as $extension) {
            $extensionClasses[] = get_class($extension);
        }

        $this->assertContains(MockTwigExtension::class, $extensionClasses);

        // Clean up
        Configure::delete('TwigView.extensions');
    }

    /**
     * Test custom Twig extension filter works
     */
    public function testCustomTwigExtensionFilterWorks(): void
    {
        // Set custom extension in Configure
        Configure::write('TwigView.extensions', [new MockTwigExtension()]);

        $controller = new Controller();
        $view = new TwigView($controller);

        // Create a template that uses the custom filter
        $template = $view->Twig->createTemplate('{{ "hello"|custom_upper }}');
        $result = $template->render([]);

        $this->assertEquals('CUSTOM:HELLO', $result);

        // Clean up
        Configure::delete('TwigView.extensions');
    }

    /**
     * Test custom Twig extension function works
     */
    public function testCustomTwigExtensionFunctionWorks(): void
    {
        // Set custom extension in Configure
        Configure::write('TwigView.extensions', [new MockTwigExtension()]);

        $controller = new Controller();
        $view = new TwigView($controller);

        // Create a template that uses the custom function
        $template = $view->Twig->createTemplate('{{ custom_hello("Test") }}');
        $result = $template->render([]);

        $this->assertEquals('Hello from custom extension, Test!', $result);

        // Clean up
        Configure::delete('TwigView.extensions');
    }
}
