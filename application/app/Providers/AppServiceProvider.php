<?php

declare(strict_types=1);

namespace Application\Providers;

use Illuminate\Support\ServiceProvider;
use Application\Domain\Stadium\StadiumRepositoryInterface;
use Application\Adaptor\Stadium\StadiumRepository;
use Application\Domain\Stadium\StadiumFactoryInterface;
use Application\Adaptor\Stadium\StadiumFactory;
use Illuminate\Support\Facades\Log;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Repositories
        $this->app->bind(
            StadiumRepositoryInterface::class,
            StadiumRepository::class
        );

        // Factories
        $this->app->bind(
            StadiumFactoryInterface::class,
            StadiumFactory::class
        );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
