<?php

namespace Iadewunmi\PortoSap\Traits;

use Illuminate\Support\Facades\File;

trait FilesAndDirectories
{
    /**
     * @param string $path
     * @param string $needle
     * @param array $directoriesPaths
     * @return array
     */
    protected function findDirectories(string $path, string $needle, array &$directoriesPaths = []): array
    {
        $directories = $this->findExistingDirectory($path) ? File::directories($path) : [];

        $needleArray = explode(DIRECTORY_SEPARATOR, $needle);
        $needleFirst = $needleArray[0];
        $needleAdditions = null;

        if(count($needleArray) > 1){
            array_shift($needleArray);
            $needleAdditions = implode(DIRECTORY_SEPARATOR, $needleArray);
        }

        foreach ($directories as $directoryPath){
            $directoryPathInfo = pathinfo($directoryPath);

            if($directoryPathInfo['basename'] !== $needleFirst){
                $this->findDirectories(path: $directoryPath, needle: $needle, directoriesPaths: $directoriesPaths);
            } else {
                $fullPath = $directoryPath.DIRECTORY_SEPARATOR.$needleAdditions;

                if($fullPath = $this->findExistingDirectory($fullPath)){
                    $directoriesPaths[] = $fullPath;
                }
            }
        }

        return $directoriesPaths;
    }

    /**
     * @param string $path
     * @return string|null
     */
    protected function findExistingDirectory(string $path): ?string
    {
        return File::isDirectory($path) ? $path : null;
    }

    /**
     * @param string $path
     * @return string|null
     */
    protected function findExistingFile(string $path): ?string
    {
        return File::isFile($path) ? $path : null;
    }

    /**
     * @param string|array $path
     * @return array
     */
    protected function findFilesInDirectories(string|array $path): array
    {
        $filesPaths = [];

        if(is_array($path)){
            foreach ($path as $p){
                $files = File::files($p);
                foreach ($files as $file){
                    $filesPaths[] = $file->getRealPath();
                }
            }

            return $filesPaths;
        }

        $files = $this->findExistingDirectory($path) ? File::files($path) : [];

        foreach ($files as $file){
            $filesPaths[] = $file->getRealPath();
        }

        return $filesPaths;
    }

    /**
     * @param string $path
     * @return string|null
     */
    protected function findNamespaceInFile(string $path): ?string
    {
        $fileStr = File::get($path);
        $fileArray = explode("\n", $fileStr);
        $nameSpaceArray = preg_grep('/^namespace /', $fileArray);

        $namespaceStr = array_shift($nameSpaceArray);

        preg_match('/^namespace (.*);$/', trim($namespaceStr), $match);

        return array_pop($match);
    }

    /**
     * @param string $path
     * @param string $before
     * @param string $after
     * @return array
     */
    protected function findAndChainBetween(string $path, string $before, string $after): array
    {
        $pathArray = explode(DIRECTORY_SEPARATOR, $path);
        $pathPattern = '';
        foreach ($pathArray as $item){
            $pathPattern .= '('.$item.')(\\\\|\/)';
            if($item === $before){
                $pathPattern .= '|(\\\\|\/)'.$after;
                break;
            }
        }

        return preg_split('/'.$pathPattern.'/i', $path,-1, PREG_SPLIT_NO_EMPTY);
    }

    /**
     * @param string $path
     * @return string
     */
    protected function getClassFromFile(string $path): string
    {
        return $this->findNamespaceInFile($path) . '\\' . File::name($path);
    }

    /**
     * @param string $path
     * @return string
     */
    protected function getNamespaceFromPath(string $path): string
    {
        return implode('\\', array_map('ucfirst', explode('/', $path)));
    }

    /**
     * @param string $path
     * @return string
     */
    protected function createDirectory(string $path): string
    {
        if (!$this->findExistingDirectory($path)) {
            File::makeDirectory($path, 0777, true, true);
        }

        return $path;
    }

    /**
     * @param string $path
     */
    protected function deleteDirectory(string $path): void
    {
        if (!$this->findExistingDirectory($path)) {
            File::deleteDirectory($path);
        }
    }

    /**
     * @param string $path
     * @param string $content
     * @param bool $forceRewrite
     * @return bool|int
     */
    protected function makeFile(string $path, string $content, bool $forceRewrite = false): bool|int
    {
        if(!$this->findExistingFile($path)){
            return File::put($path, $content);
        }

        if($forceRewrite){
            return File::put($path, $content);
        }

        return false;
    }

    /**
     * @param string $content
     * @return mixed
     * @throws \JsonException
     */
    protected function convertFromJsonToArray(string $content): mixed
    {
        return json_decode($content, true, 512, JSON_THROW_ON_ERROR);
    }
}
