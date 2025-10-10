<?php
/**
 * All TwigView plugin tests
 */

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
