<?php
declare(strict_types=1);

/**
 * Legacy class name autoloader Test Case
 */

namespace TwigView\Test\TestCase;

use CakeTestCase;
use ReflectionClass;
use TwigView\Console\Command\CompileShell;
use TwigView\View\TwigView;

class LegacyTest extends CakeTestCase
{
    /**
     * Test legacy class names are aliased to the namespaced classes
     */
    public function testLegacyClassNamesAreAliased(): void
    {
        $this->assertTrue(class_exists('TwigView'));
        $this->assertSame(TwigView::class, (new ReflectionClass('TwigView'))->getName());

        $this->assertTrue(class_exists('CompileShell'));
        $this->assertSame(CompileShell::class, (new ReflectionClass('CompileShell'))->getName());
    }

    /**
     * Test unknown class names are left to the other autoloaders
     */
    public function testUnknownClassNameIsNotAliased(): void
    {
        $this->assertFalse(class_exists('TwigViewLegacyUnknownClass'));
    }
}
