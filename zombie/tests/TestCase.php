<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Testing\TestResponse;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    private ?TestResponse $testResponse = null;

    public function setUp(): void
    {
        parent::setUp();

        \Hamcrest\Util::registerGlobalFunctions();
    }

    public function tearDown(): void
    {
        $this->addToAssertionCount(\Hamcrest\MatcherAssert::getCount());
    }

    public function systemReceivesRequest(array $request): void
    {
        $this->testResponse = $this->json(
            method: $request['method'],
            uri: $request['uri'],
            data: $request['content'],
        );
    }

    public function responseStatusCode(): int
    {
        return $this->testResponse->getStatusCode();
    }

    public function responseContent(): array
    {
        return json_decode($this->testResponse->getContent(), true);
    }
}
