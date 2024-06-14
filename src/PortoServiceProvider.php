<?php

namespace Iadewunmi\PortoSap;

use Apiato\Core\Loaders\AutoLoaderTrait;
use Illuminate\Support\ServiceProvider;

class PortoServiceProvider extends ServiceProvider
{
    use AutoLoaderTrait;

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register(): void
    {
        $this->runLoaderRegister();
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(): void
    {
        $this->runLoadersBoot();
    }
}
