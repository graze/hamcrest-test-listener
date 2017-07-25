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
use PHPUnit\Framework\BaseTestListener;
use PHPUnit\Framework\Test;
use PHPUnit\Framework\TestCase;

class TestListener extends BaseTestListener
{
    public function startTest(Test $test)
    {
        MatcherAssert::resetCount();
    }

    public function endTest(Test $test, $time)
    {
        try {
            if ($test instanceof TestCase) {
                $test->addToAssertionCount(MatcherAssert::getCount());
            }
        } catch (\Exception $e) {
            $result = $test->getTestResultObject();
            $result->addError($test, $e, $time);
        }
    }
}
