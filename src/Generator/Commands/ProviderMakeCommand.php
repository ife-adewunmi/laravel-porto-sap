<?php

namespace Iadewunmi\PortoSap\Generator\Commands;

use Illuminate\Foundation\Console\ProviderMakeCommand as LaravelProviderMakeCommand;
use Iadewunmi\PortoSap\Generator\Traits\ConsoleGenerator;

class ProviderMakeCommand extends LaravelProviderMakeCommand
{
    use ConsoleGenerator;

    /**
     * Resolve the fully-qualified path to the stub.
     *
     * @param  string  $stub
     * @return string
     */
    protected function resolveStubPath($stub): string
    {
        return __DIR__.$stub;
    }

    /**
     * Get the default namespace for the class.
     *
     * @param  string  $rootNamespace
     * @return string
     */
    protected function getDefaultNamespace($rootNamespace): string
    {
        return $this->getNecessaryNamespace().'\Providers';
    }
}
