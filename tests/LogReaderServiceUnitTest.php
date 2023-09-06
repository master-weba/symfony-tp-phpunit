<?php

namespace App\Tests;

use App\Service\LogReaderService;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Filesystem\Exception\FileNotFoundException;

class LogReaderServiceUnitTest extends TestCase
{

    private const FILE_PATH = "tests/data/logs.json";

    public function testGetEntries(): void
    {

        $entries = (new LogReaderService("."))->getEntries(self::FILE_PATH);

        $this->assertIsArray($entries);
        $this->assertNotEmpty($entries);
    }

    public function testGetEntriesWithInvalidFilename():void
    {
        $this->expectException(FileNotFoundException::class);
        $entries = (new LogReaderService("."))->getEntries("tests/var/logs.json");
    }
}
