<?php

namespace Iadewunmi\PortoSap\Generator\Commands;

use Illuminate\Foundation\Console\RequestMakeCommand as LaravelRequestMakeCommand;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Iadewunmi\PortoSap\Generator\Traits\ConsoleGenerator;
use Symfony\Component\Console\Input\InputOption;

class RequestMakeCommand extends LaravelRequestMakeCommand
{
    use ConsoleGenerator {
        handle as protected handleFromTrait;
        getOptions as protected getOptionsFromTrait;
    }

    /**
     * @var string
     */
    private string $uiType;

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getOptions(): array
    {
        $options = $this->getOptionsFromTrait();

        $options[] = ['uiType', null, InputOption::VALUE_OPTIONAL, 'Type of the container\'s user interface'];

        return $options;
    }

    /**
     * @return bool|int|null
     * @throws FileNotFoundException
     */
    public function handle(): bool|int|null
    {
        if (!$this->option('container')) {
            $this->components->error('Request must be in the container');

            return static::FAILURE;
        }

        if(in_array($this->option('uiType'), ['api', 'web'])){
            $uiType = $this->option('uiType');
        } else {
            $uiType = $this->components->choice('Please, select type of the user\'s interface', ['api', 'web'], 'web');
        }

        $this->uiType = strtoupper($uiType);

        return $this->handleFromTrait();
    }

    /**
     * Resolve the fully-qualified path to the stub.
     *
     * @param  string  $stub
     * @return string
     */
    protected function resolveStubPath($stub): string
    {
        return  __DIR__.$stub;
    }

    /**
     * Get the default namespace for the class.
     *
     * @param  string  $rootNamespace
     * @return string
     */
    protected function getDefaultNamespace($rootNamespace): string
    {
        return $this->getNecessaryNamespace().'\UI\\'.$this->uiType.'\Requests';
    }
}
