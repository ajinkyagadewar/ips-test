<?php

namespace Tests;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Mockery;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication, RefreshDatabase;
    
    public function setUp()
    {
        parent::setUp();
        $this->artisan("db:seed");
    }
    
    /**
     * Below method provides a simplistic and generic way of handling the mock 
     * across the project. It allows us to depict the functionality of external 
     * services for testing.
     *
     * @param $class
     * @return Mockery\MockInterface
     */
    public function mock($class)
    {
        $mock = Mockery::mock($class);
        $this->app->instance($class, $mock);
        return $mock;
    }
    
    public function tearDown() {
        \Mockery::close();
    }
}
