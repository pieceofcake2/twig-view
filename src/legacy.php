<?php
/**
 * Legacy Class Name Autoloader
 *
 * This file provides backward compatibility by automatically aliasing
 * namespaced classes to their legacy non-namespaced class names.
 *
 * Usage in legacy files:
 *   require_once dirname(__DIR__) . '/src/legacy.php';
 */

spl_autoload_register(function ($class) {
    $aliases = [
        'TwigView' => 'TwigView\View\TwigView',
        'CompileShell' => 'TwigView\Console\Command\CompileShell',
    ];

    if (isset($aliases[$class])) {
        class_alias($aliases[$class], $class);

        return true;
    }

    return false;
});
