<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class LogsControllerTest extends WebTestCase
{
    private function getTestData(){
        return json_decode(file_get_contents("tests/data/logs.json"),true);
    }

    public function testGetLogsPage(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/logs');

        $this->assertResponseIsSuccessful();
    }

    public function testCountDisplayedLogs(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/logs');

        $this->assertPageTitleContains('Logs Viewer - Logs index');
        $this->assertEquals(count($this->getTestData()),$crawler->filter("tr[id^='log-entry-']")->count());
    }

    public function testDateDisplayedForFirstEntry(): void
    {
        var_dump($this->getTestData()[0]["date"]);
        $client = static::createClient();
        $crawler = $client->request('GET', '/logs');

       $this->assertSelectorTextSame("#log-entry-0-date",$this->getTestData()[0]["date"]);
    }
}
