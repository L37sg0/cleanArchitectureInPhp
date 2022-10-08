<?php

namespace App\Providers;

use Doctrine\ORM\EntityManagerInterface;
use Illuminate\Support\ServiceProvider;
use L37sg0\Architecture\Domain\Repository\CustomerRepositoryInterface;
use L37sg0\Architecture\Persistence\Doctrine\Repository\CustomerRepository;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            CustomerRepositoryInterface::class,
            function ($app) {
                return new CustomerRepository(
                    $app[EntityManagerInterface::class]
                );
            }
        );
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
