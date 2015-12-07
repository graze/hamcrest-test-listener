<?php

/**
 * This file is part of graze/hamcrest-test-listener.
 *
 * Copyright (c) 2015 Nature Delivered Ltd. <https://www.graze.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @license https://github.com/graze/hamcrest-test-listener/blob/master/LICENSE MIT
 * @link https://github.com/graze/hamcrest-test-listener
 */

namespace Hamcrest\Adapter\PHPUnit;

use Hamcrest\MatcherAssert;

class TestListener implements \PHPUnit_Framework_TestListener
{
    /**
     * @param PHPUnit_Framework_Test $test
     */
    public function startTest(\PHPUnit_Framework_Test $test)
    {
        MatcherAssert::resetCount();
    }

    /**
     * @param PHPUnit_Framework_Test $test
     * @param float $time
     */
    public function endTest(\PHPUnit_Framework_Test $test, $time)
    {
        try {
            if ($test instanceof \PHPUnit_Framework_TestCase) {
                $test->addToAssertionCount(MatcherAssert::getCount());
            }
        } catch (\Exception $e) {
            $result = $test->getTestResultObject();
            $result->addError($test, $e, $time);
        }
    }

    public function startTestSuite(\PHPUnit_Framework_TestSuite $suite)
    {
    }

    public function addError(\PHPUnit_Framework_Test $test, \Exception $e, $time)
    {
    }

    public function addWarning(\PHPUnit_Framework_Test $test, \PHPUnit_Framework_Warning $e, $time)
    {
    }

    public function addFailure(\PHPUnit_Framework_Test $test, \PHPUnit_Framework_AssertionFailedError $e, $time)
    {
    }

    public function addIncompleteTest(\PHPUnit_Framework_Test $test, \Exception $e, $time)
    {
    }

    public function addSkippedTest(\PHPUnit_Framework_Test $test, \Exception $e, $time)
    {
    }

    public function addRiskyTest(\PHPUnit_Framework_Test $test, \Exception $e, $time)
    {
    }

    public function endTestSuite(\PHPUnit_Framework_TestSuite $suite)
    {
    }
}
