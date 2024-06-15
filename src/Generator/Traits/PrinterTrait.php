<?php

namespace Iadewunmi\PortoSap\Generator\Traits;

trait PrinterTrait
{
    public function printStartedMessage($containerName, $fileName = null)
    {
        $this->printInfoMessage('> Generating (' . $fileName . ') in (' . $containerName . ') Container.');
    }

    public function printInfoMessage($message)
    {
        $this->info($message);
    }

    /**
     * @return void
     */
    public function printFinishedMessage($type)
    {
        $this->printInfoMessage($type . ' generated successfully.');
    }

    public function printErrorMessage($message)
    {
        $this->error($message);
    }
}