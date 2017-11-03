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
 * @link    https://github.com/graze/hamcrest-test-listener
 */

namespace Hamcrest\Adapter\PHPUnit;

use Exception;
use Hamcrest\MatcherAssert;
use Hamcrest\Util;
use Mockery as m;
use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;
use PHPUnit\Framework\Test;
use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\TestResult;

class TestListenerTest extends TestCase
{
    use MockeryPHPUnitIntegration;

    public static function setUpBeforeClass()
    {
        // Require the Hamcrest global functions.
        Util::registerGlobalFunctions();
    }

    /**
     * @covers \Hamcrest\Adapter\PHPUnit\TestListener::startTest()
     */
    public function testShouldResetAssertionCountOnTestStart()
    {
        $listener = new TestListener();

        // Bump the hamcrest assertion count by 1.
        assertThat(true, is(true));

        $this->assertSame(1, MatcherAssert::getCount(), 'Hamcrest is not counting assertions correctly.');

        $listener->startTest(m::mock(Test::class));

        $this->assertSame(0, MatcherAssert::getCount(), 'The listener did not reset the hamcrest assertion count.');
    }

    /**
     * @covers \Hamcrest\Adapter\PHPUnit\TestListener::endTest()
     */
    public function testShouldCallAddToAssertionCountOnTestEnd()
    {
        $listener = new TestListener();

        $test = m::mock(TestCase::class);
        $test->shouldReceive('addToAssertionCount')->with(1)->once();

        // Bump the hamcrest assertion count by 1.
        assertThat(true, is(true));

        $listener->endTest($test, 0.0);
    }

    /**
     * @covers \Hamcrest\Adapter\PHPUnit\TestListener::endTest()
     */
    public function testShouldOnlyCallAddToAssertionCountOnTestCases()
    {
        $listener = new TestListener();

        $test = m::mock(Test::class);
        $test->shouldReceive('addToAssertionCount')->never();

        // Bump the hamcrest assertion count by 1.
        assertThat(true, is(true));

        $listener->endTest($test, 0.0);
    }

    /**
     * @covers \Hamcrest\Adapter\PHPUnit\TestListener::endTest()
     */
    public function testHandleExceptions()
    {
        $listener = new TestListener();

        $test = m::mock(TestCase::class);
        $exception = m::mock(Exception::class);
        $test->shouldReceive('addToAssertionCount')->andThrow($exception);

        $result = m::mock(TestResult::class);
        $test->shouldReceive('getTestResultObject')->times(1)->andReturn($result);

        $result->shouldReceive('addError')->with($test, $exception, 0.0)->times(1);

        $listener->endTest($test, 0.0);
    }
}
