<?php

namespace Tests;

use Exception;
use App\Exceptions\Handler;
use Illuminate\Foundation\Testing\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Contracts\Debug\ExceptionHandler;
use Nuwave\Lighthouse\Testing\MakesGraphQLRequests;

abstract class APITest extends TestCase
{
    use WithFaker;
    use CreatesApplication;

    /**
     * enable debug and stack trace while testing
     */
    protected function disableExceptionHandling()
    {
        $this->app->instance(ExceptionHandler::class, new class extends Handler {
            public function __construct()
            {
                // no-op
            }
            public function report(Exception $exception)
            {
                // no-op
            }
            public function render($request, Exception $exception)
            {
                throw $exception;
            }
        });
    }
}
