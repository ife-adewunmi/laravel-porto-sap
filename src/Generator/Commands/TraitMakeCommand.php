<?php

namespace Iadewunmi\PortoSap\Generator\Commands;

use Iadewunmi\PortoSap\Generator\Traits\ConsoleGenerator;
use Illuminate\Console\GeneratorCommand;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Symfony\Component\Console\Input\InputOption;

class TraitMakeCommand extends GeneratorCommand
{
    use ConsoleGenerator {
        handle as protected handleFromTrait;
        getOptions as protected getOptionsFromTrait;
    }
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'make:trait';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new trait';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Trait';

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub(): string
    {
        return __DIR__.'/stubs/trait.stub';
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions(): array
    {
        $options = $this->getOptionsFromTrait();

        $options[] = ['test', 'm', InputOption::VALUE_NONE, 'Saving trait for the tests'];

        return $options;
    }

    /**
     * @return bool|int|null
     * @throws FileNotFoundException
     */
    public function handle(): bool|int|null
    {
        if (!$this->option('container')) {
            $this->components->error('Trait must be in the container');

            return static::FAILURE;
        }

        return $this->handleFromTrait();
    }

    /**
     * Get the default namespace for the class.
     *
     * @param  string  $rootNamespace
     * @return string
     */
    protected function getDefaultNamespace($rootNamespace): string
    {
        if($this->option('test')){
            return $this->getNecessaryNamespace().'\Tests\Traits';
        }

        return $this->getNecessaryNamespace().'\Traits';
    }
}
