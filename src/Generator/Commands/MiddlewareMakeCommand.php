<?php

namespace Iadewunmi\PortoSap\Generator\Commands;

use Illuminate\Routing\Console\MiddlewareMakeCommand as LaravelMiddlewareMakeCommand;
use Iadewunmi\PortoSap\Generator\Traits\ConsoleGenerator;

class MiddlewareMakeCommand extends LaravelMiddlewareMakeCommand
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
        return $this->getNecessaryNamespace().'\Middleware';
    }
}
