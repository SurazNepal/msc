<?php

namespace App\Providers;

use App\Interfaces\AboutRepositoryInterface;
use App\Interfaces\ClientRepositoryInterface;
use App\Interfaces\FooterRepositoryInterface;
use App\Interfaces\HowWeWorkRepositoryInterface;
use App\Interfaces\LogoRepositoryInterface;
use App\Interfaces\PortfolioRepositoryInterface;
use App\Interfaces\ServiceRepositoryInterface;
use App\Interfaces\TeamRepositoryInterface;
use App\Repositories\AboutRepository;
use App\Repositories\ClientRepository;
use App\Repositories\FooterRepository;
use App\Repositories\HowWeWorkRepository;
use App\Repositories\LogoRepository;
use App\Repositories\ServiceRepository;
use Carbon\CarbonImmutable;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\ServiceProvider;
use Illuminate\Validation\Rules\Password;
use App\Repositories\PortfolioRepository;
use App\Repositories\TeamRepository;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Force the binding right here inside the core app provider
        $this->app->bind(ServiceRepositoryInterface::class, ServiceRepository::class);
        $this->app->bind(PortfolioRepositoryInterface::class, PortfolioRepository::class);
        $this->app->bind(TeamRepositoryInterface::class, TeamRepository::class);
        $this->app->bind(ClientRepositoryInterface::class,ClientRepository::class);
        $this->app->bind(HowWeWorkRepositoryInterface::class, HowWeWorkRepository::class);
        $this->app->bind(AboutRepositoryInterface::class, AboutRepository::class);
        $this->app->bind(LogoRepositoryInterface::class, LogoRepository::class);
        $this->app->bind(FooterRepositoryInterface::class, FooterRepository::class);

    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->configureDefaults();
    }

    /**
     * Configure default behaviors for production-ready applications.
     */
    protected function configureDefaults(): void
    {
        Date::use(CarbonImmutable::class);

        DB::prohibitDestructiveCommands(
            app()->isProduction(),
        );

        Password::defaults(fn (): ?Password => app()->isProduction()
            ? Password::min(12)
                ->mixedCase()
                ->letters()
                ->numbers()
                ->symbols()
                ->uncompromised()
            : null,
        );
    }
}
