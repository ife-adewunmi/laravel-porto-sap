<?php

namespace Iadewunmi\PortoSap\Loaders;

use Iadewunmi\PortoSap\Traits\FilesAndDirectories;

trait ViewsLoaderTrait
{
    use FilesAndDirectories;

    /**
     * Building regex pattern to find container name
     * @return array
     */
    private function getViewsFromContainers(): array
    {
        $directories = $this->findDirectories(config('porto.root').DIRECTORY_SEPARATOR.'Containers', 'WEB'.DIRECTORY_SEPARATOR.'Views');

        $viewsList = [];
        foreach ($directories as $directory){
            $containerNameArray = $this->findAndChainBetween($directory, 'Containers', '(UI)(\\\\|\/)(WEB)(\\\\|\/)(Views)');
            if(!$containerNameArray){
                continue;
            }

            $containerName = end($containerNameArray);
            $containerName = str_replace(DIRECTORY_SEPARATOR,'@', $containerName);

            $viewsList[$containerName] = $directory;
            $viewsList[lcfirst($containerName)] = $directory;
            $viewsList[strtolower($containerName)] = $directory;
        }

        return $viewsList;
    }

    protected function loadViewsForBoot(): void
    {
        $views = $this->getViewsFromContainers();

        foreach ($views as $name => $path){
            $this->loadViewsFrom($path, $name);
        }
    }
}
