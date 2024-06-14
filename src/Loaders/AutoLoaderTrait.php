<?php

namespace Iadewunmi\PortoSap\Loaders;

use Iadewunmi\PortoSap\Loaders\{
    ConfigsLoader,
    RoutesLoader,
    TranslationsLoader,
    MigrationsLoader,
    MiddlewareLoader,
    AliasesLoader,
    ViewsLoader,
    ProvidersLoader,
    HelpersLoader,
    CommandsLoader,
};

trait AutoLoaderTrait
{
    // Using each component loader trait
    use ConfigsLoader;
    use RoutesLoader;
    use TranslationsLoader;
    use MigrationsLoader;
    use MiddlewareLoader;
    use AliasesLoader;
    use ViewsLoader;
    use ProvidersLoader;
    use HelpersLoader;
    use CommandsLoader;

    /**
     * To be used from the `boot` function of the main service provider.
     */
    public function runLoadersBoot(): void
    {
        if(config('porto.enabled')){
            $this->loadRoutesForBoot();
            $this->loadTranslationsForBoot();
            $this->loadHelpersForBoot();
            $this->loadMigrationsForBoot();
            $this->loadViewsForBoot();
        }
    }

    public function runLoaderRegister(): void
    {
        $this->loadConfigsFromPackage();

        if(config('porto.enabled')){
            $this->loadConfigsForRegister();
            $this->loadProvidersForRegister();
            $this->loadAliasesForRegister();
            $this->loadMiddlewareForRegister();
            $this->loadCommandsForRegister();
        }
    }
}