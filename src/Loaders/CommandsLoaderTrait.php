<?php

namespace Iadewunmi\PortoSap\Loaders;

use Iadewunmi\PortoSap\Generator\Traits\ConsoleKernel;

trait CommandsLoaderTrait
{
    use ConsoleKernel;

    /**
     * @return array
     */
    private function getCommandsFromContainers(): array
    {
        return $this->findDirectories(config('porto.root'), 'CLI'.DIRECTORY_SEPARATOR.'Commands');
    }

    /**
     * @return string
     */
    private function getCommandsFromShip(): string
    {
        return config('porto.root').DIRECTORY_SEPARATOR.'Commands';
    }

    /**
     * Load commands for the ConsoleKernel
     */
    protected function loadCommandsForConsoleKernel(): void
    {
        $this->load($this->getCommandsFromShip());

        foreach ($this->getCommandsFromContainers() as $directory){
            $this->load($directory);
        }
    }

    /**
     * Load commands from the package
     */
    protected function loadCommandsForRegister(): void
    {
        $commandFiles = $this->findFilesInDirectories([
            __DIR__ . '/../Generator/Commands',
        ]);

        $commandClasses = [];
        foreach ($commandFiles as $file){
            $commandClasses[] = $this->getClassFromFile($file);
        }

        $this->commands($commandClasses);
    }
}
