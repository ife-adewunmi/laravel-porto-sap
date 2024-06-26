<?php

namespace Iadewunmi\PortoSap\Generator\Commands;

use Illuminate\Foundation\Console\ConsoleMakeCommand as LaravelConsoleMakeCommand;
use Iadewunmi\PortoSap\Generator\Traits\ConsoleGenerator;
use Illuminate\Console\Command;

class ConsoleMakeCommand extends LaravelConsoleMakeCommand
{
    use ConsoleGenerator;

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub(): string
    {
        return __DIR__.'/stubs/console.stub';
    }

    /**
     * Replace the namespace for the given stub.
     *
     * @param  string  $stub
     * @param  string  $name
     * @return $this
     */
    protected function replaceNamespace(&$stub, $name)
    {
        $searches = [
            ['DummyParentNamespace'],
            ['{{ parentNamespace }}'],
            ['{{parentNamespace}}']
        ];

        foreach ($searches as $search) {
            $stub = str_replace(
                $search,
                [$this->getParentNamespace()],
                $stub
            );
        }

        return parent::replaceNamespace($stub, $name);
    }

    /**
     * Replace the class name for the given stub.
     *
     * @param  string  $stub
     * @param  string  $name
     * @return string
     */
    protected function replaceClass($stub, $name): string
    {
        $stub = parent::replaceClass($stub, $name);

        $searches = [
            ['DummyParentClass'],
            ['{{ parentClass }}'],
            ['{{parentClass}}']
        ];

        foreach ($searches as $search) {
            $stub = str_replace(
                $search,
                ['AbstractConsoleCommand'],
                $stub
            );
        }

        return $stub;
    }

    protected function getParentNamespace(): string
    {
        $filePath = config('porto.root').'/Ship/Abstracts/Commands/ConsoleCommand.php';
        return $this->findExistingFile($filePath) ? $this->getShipNamespace().'\Abstracts\Commands\ConsoleCommand as AbstractConsoleCommand' : Command::class;
    }

    /**
     * @return string
     */
    protected function getNecessaryNamespace(): string
    {
        if($container = $this->option('container')){
            $containerNamespace = $this->getNamespaceFromPath($container);

            return $this->getContainersNamespace().'\\'.$containerNamespace.'\UI\CLI';
        }

        return $this->getShipNamespace();
    }

    /**
     * Get the default namespace for the class.
     *
     * @param  string  $rootNamespace
     * @return string
     */
    protected function getDefaultNamespace($rootNamespace): string
    {
        return $this->getNecessaryNamespace().'\Commands';
    }
}
