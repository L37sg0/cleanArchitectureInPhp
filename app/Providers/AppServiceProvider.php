<?php

namespace App\Providers;

use Doctrine\ORM\EntityManagerInterface;
use Illuminate\Support\ServiceProvider;
use L37sg0\Architecture\Domain\Repository\CustomerRepositoryInterface;
use L37sg0\Architecture\Domain\Repository\InvoiceRepositoryInterface;
use L37sg0\Architecture\Domain\Repository\OrderRepositoryInterface;
use L37sg0\Architecture\Persistence\Doctrine\Repository\CustomerRepository;
use L37sg0\Architecture\Persistence\Doctrine\Repository\InvoiceRepository;
use L37sg0\Architecture\Persistence\Doctrine\Repository\OrderRepository;
use L37sg0\Architecture\Persistence\Hydrator\ClassMethodsHydrator;
use L37sg0\Architecture\Persistence\Hydrator\HydratorInterface;

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
        $this->app->bind(
            OrderRepositoryInterface::class,
            function ($app) {
                return new OrderRepository(
                    $app[EntityManagerInterface::class]
                );
            }
        );
        $this->app->bind(
            InvoiceRepositoryInterface::class,
            function ($app) {
                return new InvoiceRepository(
                    $app[EntityManagerInterface::class]
                );
            }
        );
        $this->app->bind(
            HydratorInterface::class,
            function ($app) {
                return new ClassMethodsHydrator();
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
