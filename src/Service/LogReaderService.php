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


}
