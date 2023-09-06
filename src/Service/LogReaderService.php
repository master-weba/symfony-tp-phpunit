<?php

namespace App\Service;

use Symfony\Component\Filesystem\Exception\FileNotFoundException;

class LogReaderService
{
    /**
     * @param string $filename
     * @return mixed
     */
    public function getEntries(string $filename): mixed
    {
        $path = "../$filename";

        if(file_exists($path) === false){
            throw new FileNotFoundException();
        }
        $json = file_get_contents($path);
        return json_decode($json,true);
    }


}
