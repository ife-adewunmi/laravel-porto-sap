<?php

namespace Iadewunmi\PortoSap\Generator\Commands;

use Iadewunmi\PortoSap\Generator\Traits\ConsoleGenerator;
use Illuminate\Console\GeneratorCommand;
use Illuminate\Contracts\Filesystem\FileNotFoundException;

class ContractMakeCommand extends GeneratorCommand
{
    use ConsoleGenerator;

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'make:contract';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new contract class';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Contract';

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub(): string
    {
        return __DIR__.'/stubs/contract.stub';
    }

    /**
     * @return bool|void|null
     * @throws FileNotFoundException
     */
    public function handle()
    {
        if (!$this->option('container')) {
            $this->components->error('Contract must be in the container');

            return static::FAILURE;
        }

        return parent::handle();
    }

    /**
     * Get the default namespace for the class.
     *
     * @param  string  $rootNamespace
     * @return string
     */
    protected function getDefaultNamespace($rootNamespace): string
    {
        return $this->getNecessaryNamespace().'\Contracts';
    }
}
