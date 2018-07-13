<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use App\Repositories;
use App\Interfaces;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Interface mapping to Repositories
     *
     * @var array
     */
    private static $repositoryInterfaces = [
      Interfaces\CourseTagsRepositoryInterface::class 
            => Repositories\CourseTagsRepository::class,
      Interfaces\UserRepositoryInterface::class 
            => Repositories\UserRepository::class
    ];
    
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->registerRepositoryInterfaces();
    }
    
    /**
     * Bind the implementations of various interfaces to the interface 
     * definitions.
     */
    private function registerRepositoryInterfaces()
    {
        foreach (self::$repositoryInterfaces as $interface => $implementation){
            $this->app->bind($interface, $implementation);
        }
    }
}
