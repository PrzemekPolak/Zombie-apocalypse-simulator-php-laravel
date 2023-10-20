<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    public function setUp(): void
    {
        parent::setUp();

        \Hamcrest\Util::registerGlobalFunctions();
    }

    public function tearDown(): void
    {
        $this->addToAssertionCount(\Hamcrest\MatcherAssert::getCount());
    }
}
