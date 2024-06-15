<?php

namespace Iadewunmi\PortoSap\Generator\Contracts;

interface ComponentsGenerator
{
    /**
     * Reads all data for the component to be generated (as well as the mappings for path, file and stubs).
     */
    public function getUserInputs(): array|null;
}