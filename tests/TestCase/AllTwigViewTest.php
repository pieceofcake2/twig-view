<?php
declare(strict_types=1);

/**
 * All TwigView plugin tests
 */

namespace TwigView\Test\TestCase;

use CakeTestCase;
use CakeTestSuite;

class AllTwigViewTest extends CakeTestCase
{
    /**
     * Suite define the tests for this suite
     *
     * @return CakeTestSuite
     */
    public static function suite(): CakeTestSuite
    {
        $suite = new CakeTestSuite('All TwigView test');

        $path = __DIR__ . DS;
        $suite->addTestDirectoryRecursive($path);

        return $suite;
    }
}
