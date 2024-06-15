<?php

namespace Iadewunmi\PortoSap\Generator\Commands;

use Iadewunmi\PortoSap\Enums\ContainerTypes;
use Iadewunmi\PortoSap\Generator\Contracts\ComponentsGenerator;
use Iadewunmi\PortoSap\Generator\GeneratorCommand;

use Iadewunmi\PortoSap\Structure\Builder\ContainersBuilder;
use Iadewunmi\PortoSap\Structure\StructureMaker;
use Illuminate\Support\Str;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Input\InputOption;

#[AsCommand(name: 'porto:init')]
class InitializeCommand extends GeneratorCommand implements ComponentsGenerator
{

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'porto:init';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a whole porto structure pattern';

    /**
     * The type of class being generated.
     */
    protected string $fileType = 'Init';

    protected string $portoPath;

    /**
     * The structure of the file path.
     */
    protected string $pathStructure = '{section-name}/{container-name}/*';
    /**
     * The structure of the file name.
     */
    protected string $nameStructure = '{file-name}';

    /**
     * User required/optional inputs expected to be passed while calling the command.
     * This is a replacement of the `getArguments` function "which reads from the console whenever it's called".
     */
    public array $inputs = [
        ['root', null, InputOption::VALUE_OPTIONAL, 'The name of the root directory'],
        ['ui', null, InputOption::VALUE_OPTIONAL, 'The name of the UI'],
    ];

    protected function initializeParameters(): void
    {
        $this->portoPath = '';

        $this->setDirectoryPath();

        $this->printStartedMessage($this->sectionName . ':' . $this->containerName, 'Porto');
    }

    protected function processUserData(): void
    {
        $rootPath = $this->laravel->basePath().DIRECTORY_SEPARATOR.$this->portoPath;
        $namespace = $this->getNamespaceFromPath($this->portoPath);

        $this->setPathInEnvironmentFile($this->portoPath);

        // Get user inputs
        $this->userData = $this->getUserInputs();

        if (null === $this->userData) {
            // The user skipped this step
            return;
        }
        $this->userData = $this->sanitizeUserData($this->userData);

        if (!$this->fileSystem->exists($rootPath)) {
            $path = $rootPath.DIRECTORY_SEPARATOR.$this->sectionName;
            $containersBuilder = new ContainersBuilder($path, $namespace);
            $containerType = '';

        if(isset($this->userData['ui'])) {
            foreach (ContainerTypes::cases() as $containerTypesEnum) {
                if ($containerTypesEnum->value === $this->userData['ui']) {
                    $containerType = $containerTypesEnum->value;
                }
            }
        } else {
            $containerType = ContainerTypes::PORTO_CONTAINER_TYPE_STANDARD->value;
        }

            // Prepare stub content
            $containersBuilder
                ->setContainerName($this->containerName)
                ->setContainerType($containerType);

            (new StructureMaker($this, $containersBuilder))->execute();

            $this->printFinishedMessage($this->fileType);
        }
    }

    public function getUserInputs(): array|null
    {
        $ui = Str::upper($this->checkParameterOrChoice(
            'ui',
            'Which UI is this Action for?',
            ['DEFAULT', 'FULL', 'API', 'WEB', 'CLI'],
            0
        ));

        return ['ui' => $ui];
    }

    /**
     * @param string $path
     * @return bool
     */
    protected function setPathInEnvironmentFile(string $path): bool
    {
        if (! $this->writeNewEnvironmentFileWith($path)) {
            return false;
        }

        return true;
    }

    /**
     * @param string $path
     * @return bool
     */
    protected function writeNewEnvironmentFileWith(string $path): bool
    {
        $replaced = preg_replace(
            $this->pathReplacementPattern(),
            'PORTO_SAP_PATH='.$path,
            $input = file_get_contents($this->laravel->environmentFilePath())
        );

        if(config('porto.path') === $path){
            return false;
        }

        if (!getenv('PORTO_SAP_PATH') && ($replaced === $input || $replaced === null)) {
            file_put_contents($this->laravel->environmentFilePath(),"PORTO_SAP_PATH=$path", FILE_APPEND | LOCK_EX);

            return true;
        }

        file_put_contents($this->laravel->environmentFilePath(), $replaced);

        return true;
    }

    /**
     * @return string
     */
    protected function pathReplacementPattern(): string
    {
        $escaped = preg_quote('='.config('porto.path'), '/');
        return "/^PORTO_SAP_PATH{$escaped}/m";
    }

    private function setDirectoryPath(): void
    {
        if ($this->checkParameterOrConfirm(
            'root',
            'Do you wish to install porto structure in your '.config('porto.path').'/ directory?',
            true)
        ) {
            $this->portoPath = config('porto.path');
        }

        if(!$this->portoPath){
            $this->portoPath = $this->components->ask('Please, write your custom directory path');
        }

        if(!$this->portoPath){
            $this->components->error('The porto structure can\'t be installed without directory path');

            return;
        }

        if (preg_match('([^A-Za-z0-9_/\\\\])', $this->portoPath)) {
            throw new \InvalidArgumentException('Porto path contains invalid characters.');
        }

        $this->sectionName = ucfirst($this->checkParameterOrAsk('section', 'Enter the name of the Section', self::DEFAULT_SECTION_NAME));
        $this->containerName = ucfirst($this->checkParameterOrAsk('container', 'Enter the name of the Container'));

        $this->sectionName = $this->removeSpecialChars($this->sectionName);
        $this->containerName = $this->removeSpecialChars($this->containerName);
    }
}
