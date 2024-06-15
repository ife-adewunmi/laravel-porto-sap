<?php

namespace Iadewunmi\PortoSap\Generator\Commands;

use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Foundation\Console\ObserverMakeCommand as LaravelObserverMakeCommand;
use Iadewunmi\PortoSap\Generator\Traits\ConsoleGenerator;

class ObserverMakeCommand extends LaravelObserverMakeCommand
{
    use ConsoleGenerator {
        handle as protected handleFromTrait;
    }

    /**
     * @return bool|int|null
     * @throws FileNotFoundException
     */
    public function handle(): bool|int|null
    {
        if (!$this->option('container')) {
            $this->components->error('Observer must be in the container');

            return static::FAILURE;
        }

        return $this->handleFromTrait();
    }

    /**
     * Qualify the given model class base name.
     *
     * @param  string  $model
     * @return string
     */
    protected function qualifyModel(string $model)
    {
        $model = ltrim($model, '\\/');

        $model = str_replace('/', '\\', $model);

        $rootNamespace = $this->getNecessaryNamespace().'\Models';

        return $rootNamespace.'\\'.$model;
    }

    /**
     * Get the default namespace for the class.
     *
     * @param  string  $rootNamespace
     * @return string
     */
    protected function getDefaultNamespace($rootNamespace): string
    {
        return $this->getNecessaryNamespace().'\Observers';
    }
}
