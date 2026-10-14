<?php
declare(strict_types=1);

/**
 * TwigView for CakePHP
 *
 * @license The MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

namespace TwigView\View;

use App;
use Configure;
use Controller;
use Inflector;
use Twig\Environment;
use TwigView\Twig\Extension\I18nExtension;
use TwigView\Twig\Extension\InflectorExtension;
use TwigView\Twig\Extension\NumberExtension;
use TwigView\Twig\Extension\StringsExtension;
use TwigView\Twig\Extension\UtilsExtension;
use TwigView\Twig\Extension\ViewExtension;
use TwigView\Twig\FileLoader;
use TwigView\Twig\TokenParser\LayoutTokenParser;
use TwigView\Twig\TokenParser\TransTokenParser;
use View;

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
     * Template file extensions for Twig
     *
     * @var array<string>
     */
    protected array $extensions = [
        '.twig',
    ];

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
     *
     * @param Controller|null $controller Controller
     */
    public function __construct(?Controller $controller = null)
    {
        parent::__construct($controller);

        if ($this->ext === '.ctp') {
            $this->ext = '.twig';
        }

        if ($this->ext !== '.twig' && !in_array($this->ext, $this->extensions, true)) {
            $this->extensions[] = $this->ext;
        }

        $this->templatePaths = App::path('View');
        $loader = new FileLoader($this->templatePaths, $this->extensions);

        $this->Twig = new Environment($loader, [
            'cache' => Configure::read('TwigView.cache') ?: TMP . 'views',
            'charset' => strtolower(Configure::read('App.encoding')),
            'auto_reload' => Configure::read('debug') > 0,
            'autoescape' => false,
            'debug' => Configure::read('debug') > 0,
        ]);

        if (isset($controller->theme)) {
            $this->theme = $controller->theme;
            $loader->setTheme($controller->theme);
        }

        $this->Twig->addTokenParser(new LayoutTokenParser());
        $this->Twig->addTokenParser(new TransTokenParser());

        $this->Twig->addExtension(new I18nExtension());
        $this->Twig->addExtension(new InflectorExtension());
        $this->Twig->addExtension(new NumberExtension());
        $this->Twig->addExtension(new StringsExtension());
        $this->Twig->addExtension(new UtilsExtension());
        $this->Twig->addExtension(new ViewExtension($this));

        $customExtensions = Configure::read('TwigView.extensions');
        if (is_array($customExtensions)) {
            foreach ($customExtensions as $extension) {
                if (is_string($extension)) {
                    $this->Twig->addExtension(new $extension());
                } elseif (is_object($extension)) {
                    $this->Twig->addExtension($extension);
                }
            }
        }
    }

    /**
     * Render the view
     *
     * @param string $viewFile
     * @param array $_dataForView
     * @return string
     */
    protected function _render($viewFile, $_dataForView = [])
    {
        if (empty($_dataForView)) {
            $_dataForView = $this->viewVars;
        }

        $isTwigFile = false;
        foreach ($this->extensions as $extension) {
            if (str_ends_with($viewFile, $extension)) {
                $isTwigFile = true;
                break;
            }
        }

        if (!$isTwigFile) {
            return parent::_render($viewFile, $_dataForView);
        }

        $helpers = [];
        foreach ($this->Helpers->loaded() as $helper) {
            $helpers[Inflector::variable($helper)] = $this->loadHelper($helper);
        }

        if (!isset($_dataForView['cakeDebug'])) {
            $_dataForView['cakeDebug'] = null;
        }

        $data = $_dataForView + $helpers;
        $data['_view'] = $this;

        $template = $this->Twig->load($viewFile);

        return $template->render($data);
    }
}
