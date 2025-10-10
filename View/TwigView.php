<?php
/**
 * TwigView for CakePHP
 *
 * @version 0.5
 * @package TwigView
 * @subpackage TwigView.View
 * @author Kjell Bublitz <m3nt0r.de@gmail.com>
 * @link http://github.com/m3nt0r My GitHub
 * @link http://twitter.com/m3nt0r My Twitter
 * @author Graham Weldon (http://grahamweldon.com)
 * @license The MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

use Twig\Environment;
use Twig\Loader\FilesystemLoader;

$twigPath = CakePlugin::path('TwigView');

require_once $twigPath . 'Lib' . DS . 'Twig_TokenParser_Element.php';
require_once $twigPath . 'Lib' . DS . 'Twig_Node_Element.php';
require_once $twigPath . 'Lib' . DS . 'Twig_TokenParser_Trans.php';
require_once $twigPath . 'Lib' . DS . 'Twig_Node_Trans.php';
require_once $twigPath . 'Lib' . DS . 'Twig_Extension_I18n.php';
require_once $twigPath . 'Lib' . DS . 'Twig_Extension_Ago.php';
require_once $twigPath . 'Lib' . DS . 'Twig_Extension_Basic.php';
require_once $twigPath . 'Lib' . DS . 'Cake_Number_Filters.php';
require_once $twigPath . 'Lib' . DS . 'Twig_Extension_Number.php';

/**
 * TwigView for CakePHP
 */
class TwigView extends View
{
    /**
     * File extension
     *
     * @var string
     */
    public $ext = '.twig';

    /**
     * Twig Environment Instance
     *
     * @var Environment
     */
    public $Twig;

    /**
     * Collection of View paths for template lookup
     *
     * @var array
     */
    public $templatePaths = [];

    /**
     * Constructor
     * Overridden to provide Twig loading
     *
     * @param Controller $Controller Controller
     */
    public function __construct(?Controller $Controller = null)
    {
        $this->templatePaths = App::path('View');
        $loader = new FilesystemLoader($this->templatePaths[0]);

        // Add all additional View paths to Twig loader
        $pathCount = count($this->templatePaths);
        for ($i = 1; $i < $pathCount; $i++) {
            $loader->addPath($this->templatePaths[$i]);
        }

        $this->Twig = new Environment($loader, [
            'cache' => Configure::read('TwigView.cache') ?: TMP . 'views',
            'charset' => strtolower(Configure::read('App.encoding')),
            'auto_reload' => Configure::read('debug') > 0,
            'autoescape' => false,
            'debug' => Configure::read('debug') > 0,
        ]);

        parent::__construct($Controller);

        // Change .ctp extension to .twig, but preserve custom extensions
        if ($this->ext === '.ctp') {
            $this->ext = '.twig';
        }

        // Add default token parsers
        $this->Twig->addTokenParser(new Twig_TokenParser_Element());
        $this->Twig->addTokenParser(new Twig_TokenParser_Trans());

        // Add default extensions
        $this->Twig->addExtension(new Twig_Extension_I18n());
        $this->Twig->addExtension(new Twig_Extension_Ago($this));
        $this->Twig->addExtension(new Twig_Extension_Basic());
        $this->Twig->addExtension(new Twig_Extension_Number($this));

        // Add custom extensions from Configure
        $customExtensions = Configure::read('TwigView.extensions');
        if (is_array($customExtensions)) {
            foreach ($customExtensions as $extension) {
                if (is_string($extension)) {
                    // Class name string
                    $this->Twig->addExtension(new $extension());
                } elseif (is_object($extension)) {
                    // Already instantiated extension
                    $this->Twig->addExtension($extension);
                }
            }
        }

        if (isset($Controller->theme)) {
            $this->theme = $Controller->theme;
        }
    }

    /**
     * Render the view
     *
     * @param string $viewFile
     * @param string $_dataForView
     * @return string
     */
    protected function _render($viewFile, $_dataForView = [])
    {
        if (empty($_dataForView)) {
            $_dataForView = $this->viewVars;
        }

        // Check if it's a CTP file (should use parent renderer)
        $isCtpFile = str_ends_with($viewFile, '.ctp');

        // Check if it's a Twig template (has .twig extension or matches $this->ext)
        $isTwigFile = str_ends_with($viewFile, '.twig')
            || str_ends_with($viewFile, $this->ext) && $this->ext !== '.ctp';

        // Use parent renderer for CTP files and other file types
        if ($isCtpFile || !$isTwigFile) {
            return parent::_render($viewFile, $_dataForView);
        }

        // Use Twig renderer for .twig files or custom extension files
        // Setup the helpers from the new Helper Collection
        $helpers = [];
        foreach ($this->Helpers->loaded() as $helper) {
            $helpers[Inflector::variable($helper)] = $this->loadHelper($helper);
        }

        if (!isset($_dataForView['cakeDebug'])) {
            $_dataForView['cakeDebug'] = null;
        }

        $data = $_dataForView + $helpers;
        $data['_view'] = $this;

        $relativeFn = str_replace($this->templatePaths, '', $viewFile);
        $template = $this->Twig->load($relativeFn);

        ob_start();
        echo $template->render($data);

        return ob_get_clean() || '';
    }
}
