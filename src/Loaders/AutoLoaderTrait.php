<?php

namespace Iadewunmi\PortoSap\Loaders;

trait AutoLoaderTrait
{
    // Using each component loader trait
    use ConfigsLoaderTrait;
    use RoutesLoaderTrait;
    use TranslationsLoaderTrait;
    use MigrationsLoaderTrait;
    use MiddlewareLoaderTrait;
    use AliasesLoaderTrait;
    use ViewsLoaderTrait;
    use ProvidersLoaderTrait;
    use HelpersLoaderTrait;
    use CommandsLoaderTrait;

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