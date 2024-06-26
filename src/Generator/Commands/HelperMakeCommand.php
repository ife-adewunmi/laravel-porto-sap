<?php

namespace Iadewunmi\PortoSap\Generator\Commands;

use Iadewunmi\PortoSap\Generator\Traits\Console;
use Illuminate\Console\GeneratorCommand;

class HelperMakeCommand extends GeneratorCommand
{
    use Console;

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'make:helper';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new helper file';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Helper';

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub(): string
    {
        return __DIR__.'/stubs/helper.stub';
    }

    /**
     * Get the default namespace for the class.
     *
     * @param  string  $rootNamespace
     * @return string
     */
    protected function getDefaultNamespace($rootNamespace): string
    {
        return $this->getShipNamespace().'\Helpers';
    }
}
