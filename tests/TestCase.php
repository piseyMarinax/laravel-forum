<?php

namespace Tests;
use Illuminate\Contracts\Debug\ExceptionHandler;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use App\Exceptions\Handler;
abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    public function setUp()
    {
        parent::setUp();

        $this->disableExceptoinHanding();
    }

    protected function singIn($user = null)
    {
        $user = $user?: create('App\User');
        
        $this->actingAs($user);

        return $this;
    }

    protected function disableExceptoinHanding()
    {
        $this->oldExceptionHandler = $this->app->make(ExceptionHandler::class);

        $this->app->instance(ExceptionHandler::class, new class extends Handler {
            public function __construct() {}
            public function report(\Exception $e) {}
            public function render($request, \Exception $e){
                throw $e;
            }
        });
    }

     protected function withExceptionHanding()
     {
        $this->app->instance(ExceptionHandler::class, $this->disableExceptoinHanding());

        return $this;
     }
}
