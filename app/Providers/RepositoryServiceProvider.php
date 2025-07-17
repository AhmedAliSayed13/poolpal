<?php namespace App\Providers;



// website
use App\Repositories\test\TestInterface;
use App\Repositories\test\TestRepository;
use App\Repositories\task\TaskInterface;
use App\Repositories\task\TaskRepository;

use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // Test
        $this->app->bind(
            TestInterface::class,
            TestRepository::class
        );
        // Task
        $this->app->bind(
            TaskInterface::class,
            TaskRepository::class
        );



    }
}
