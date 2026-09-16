<?php

declare(strict_types=1);

namespace Application\Providers;

use Application\Adaptor\Stadium\StadiumFactory;
use Application\Adaptor\Stadium\StadiumRepository;
use Application\Adaptor\Team\TeamFactory;
use Application\Adaptor\Team\TeamRepository;
use Application\Domain\Stadium\StadiumFactoryInterface;
use Application\Domain\Stadium\StadiumRepositoryInterface;
use Application\Domain\Team\TeamFactoryInterface;
use Application\Domain\Team\TeamRepositoryInterface;
use Illuminate\Support\ServiceProvider;

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
        $this->app->bind(
            TeamRepositoryInterface::class,
            TeamRepository::class
        );

        // Factories
        $this->app->bind(
            StadiumFactoryInterface::class,
            StadiumFactory::class
        );
        $this->app->bind(
            TeamFactoryInterface::class,
            TeamFactory::class
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
