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

use Hamcrest\Adapter\PHPUnit\TestListener;
use Hamcrest\MatcherAssert;

class TestListenerTest extends \PHPUnit_Framework_TestCase
{
    public function testShouldResetAssertionCountOnTestStart()
    {
        $listener = new TestListener();

        // Bump the hamcrest assertion count by 1.
        assertThat(true, is(true));

        $this->assertSame(1, MatcherAssert::getCount(), 'Hamcrest is not counting assertions correctly.');

        $listener->startTest(Mockery::mock(PHPUnit_Framework_Test::class));

        $this->assertSame(0, MatcherAssert::getCount(), 'The listener did not reset the hamcrest assertion count.');
    }

    public function testShouldCallAddToAssertionCountOnTestEnd()
    {
        $listener = new TestListener();

        $test = Mockery::mock(PHPUnit_Framework_TestCase::class);
        $test->shouldReceive('addToAssertionCount')->with(1)->once();

        // Bump the hamcrest assertion count by 1.
        assertThat(true, is(true));

        $listener->endTest($test, 0.0);
    }

    public function testShouldOnlyCallAddToAssertionCountOnTestCases()
    {
        $listener = new TestListener();

        $test = Mockery::mock(PHPUnit_Framework_Test::class);
        $test->shouldReceive('addToAssertionCount')->never();

        // Bump the hamcrest assertion count by 1.
        assertThat(true, is(true));

        $listener->endTest($test, 0.0);
    }
}
