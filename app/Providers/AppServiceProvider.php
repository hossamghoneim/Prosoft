<?php

namespace App\Providers;

use App\Interfaces\AdminRepositoryInterface;
use App\Interfaces\BrandRepositoryInterface;
use App\Interfaces\CarModelRepositoryInterface;
use App\Interfaces\RoleRepositoryInterface;
use App\Interfaces\SettingRepositoryInterface;
use App\Repositories\AdminRepository;
use App\Repositories\BrandRepository;
use App\Repositories\CarModelRepository;
use App\Repositories\RoleRepository;
use App\Repositories\SettingRepository;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->bindRepositoriesInterfaces();
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Schema::defaultStringLength(191);
    }

    private function bindRepositoriesInterfaces(): void
    {
        $this->app->bind(AdminRepositoryInterface::class, AdminRepository::class);
        $this->app->bind(SettingRepositoryInterface::class, SettingRepository::class);
        $this->app->bind(RoleRepositoryInterface::class, RoleRepository::class);
        $this->app->bind(BrandRepositoryInterface::class, BrandRepository::class);
        $this->app->bind(CarModelRepositoryInterface::class, CarModelRepository::class);
    }

}
