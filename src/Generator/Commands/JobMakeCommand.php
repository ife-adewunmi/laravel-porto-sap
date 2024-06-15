<?php

namespace Iadewunmi\PortoSap\Generator\Commands;

use Illuminate\Foundation\Console\JobMakeCommand as LaravelJobMakeCommand;
use Iadewunmi\PortoSap\Generator\Traits\ConsoleGenerator;

class JobMakeCommand extends LaravelJobMakeCommand
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
        return $this->getNecessaryNamespace().'\Jobs';
    }
}
