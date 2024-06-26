<?php

namespace Iadewunmi\PortoSap\Generator\Commands;

use Illuminate\Foundation\Console\RuleMakeCommand as LaravelRuleMakeCommand;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Iadewunmi\PortoSap\Generator\Traits\ConsoleGenerator;

class RuleMakeCommand extends LaravelRuleMakeCommand
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
            $this->components->error('Rule must be in the container');

            return static::FAILURE;
        }

        return $this->handleFromTrait();
    }

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub(): string
    {
        $stub = $this->option('implicit')
            ? '/stubs/rule.implicit.stub'
            : '/stubs/rule.stub';

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
        return $this->getNecessaryNamespace().'\Data\Rules';
    }
}
