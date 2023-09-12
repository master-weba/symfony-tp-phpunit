<?php

namespace App\Service;

use Symfony\Component\Filesystem\Exception\FileNotFoundException;

class LogReaderService
{
    public function __construct(
        private readonly string $rootDir
    )
    {
    }

    /**
     * @param string $filename
     * @return mixed
     */
    public function getEntries(string $filename): mixed
    {
        $path = $this->rootDir."/".$filename;

        if(file_exists($path) === false){
            throw new FileNotFoundException();
        }
        $json = file_get_contents($path);
        return json_decode($json,true);
    }
}
