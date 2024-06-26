<?php

namespace Iadewunmi\PortoSap\Structure;

use Iadewunmi\PortoSap\Structure\Builder\Structure;
use Illuminate\Console\Command;

class StructureMaker
{
    /**
     * @param Command $command
     * @param Structure $structure
     */
    public function __construct(
        private readonly Command $command,
        private readonly Structure $structure
    ) {}

    public function execute(): void
    {
        $this->structure->createRootDirectory();
        $this->structure->build();
        $this->structure->showInCli($this->command);
    }
}
