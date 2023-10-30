<?php

namespace App\Tests\Unit;

use App\Entity\LogTrace;
use PHPUnit\Framework\TestCase;
use stdClass;
use TypeError;

class LogTraceUnitTest extends TestCase
{
    private const TEST_VALUES = ["date"=>"2023-09-05 14:00", "type"=>"error", "message"=>"Access Denied"];
    private function makeLogTrace(): LogTrace
    {
        return new LogTrace(date_create_immutable(self::TEST_VALUES["date"]),self::TEST_VALUES["type"],self::TEST_VALUES["message"]);
    }

    public function testConstructWithWrongAttributeTypeForDate():void
    {

        $testValues = ["string",12344,[],new StdClass(), null];

        foreach($testValues as $value){
            $this->expectException(TypeError::class);
            $trace = new LogTrace($value,self::TEST_VALUES["type"],self::TEST_VALUES["message"]);
        }

    }

    public function testConstructWithWrongAttributeTypeForType():void
    {
        $testValues = [12344,[],new StdClass(), null];

        foreach($testValues as $value){
            $this->expectException(TypeError::class);
            $trace = new LogTrace(date_create_immutable(self::TEST_VALUES["date"]),$value,self::TEST_VALUES["message"]);
        }

    }

    public function testConstructWithWrongAttributeTypeForMessage():void
    {
        $testValues = [12344,[],new StdClass(), null];

        foreach($testValues as $value){
            $this->expectException(TypeError::class);
            $trace = new LogTrace(date_create_immutable(self::TEST_VALUES["date"]),self::TEST_VALUES["type"],$value);
        }
    }
    public function testGetDate(): void
    {
        $trace = $this->makeLogTrace();
        $this->assertEquals(date_create_immutable(self::TEST_VALUES["date"]),$trace->getDate());
    }

    public function testGetType(): void
    {
        $trace = $this->makeLogTrace();
        $this->assertEquals(self::TEST_VALUES["type"],$trace->getType());
    }

    public function testGetMessage(): void
    {
        $trace = $this->makeLogTrace();
        $this->assertEquals(self::TEST_VALUES["message"],$trace->getMessage());
    }
}
