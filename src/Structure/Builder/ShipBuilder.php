<?php

namespace Iadewunmi\PortoSap\Structure\Builder;

class ShipBuilder extends Structure
{
    /**
     * @param string $path
     * @param string $namespace
     */
    public function __construct(string $path, string $namespace)
    {
        $this->setComponentVariable('path', $path.'/Ship');
        $this->setComponentVariable('namespace', $namespace.'\Ship');
    }

    /**
     * @throws \JsonException
     */
    public function getStructure(): array
    {
        $structure = [];

        $structureComponent = $this->getComponent('ship');

        if($this->findExistingFile($structureComponent)){
            $structure = $this->getComponentContents($structureComponent);
        }

        return $structure;
    }
}
