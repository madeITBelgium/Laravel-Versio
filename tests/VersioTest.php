<?php

use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use MadeITBelgium\Versio\Versio;

class VersioTest extends \PHPUnit\Framework\TestCase
{
    public function setUp()
    {
        parent::setUp();
    }

    public function testConstructor()
    {
        $versio = new Versio('test', 'test');
        $client = new Client();
        $versio->setClient($client);

        $this->assertEquals($versio->getClient(), $client);

        $client = new Client();
        $versio = new Versio('test', 'test', $client);

        $this->assertEquals($versio->getClient(), $client);
    }

    /**
     * @expectedException Exception
     */
    public function testServerErrorException()
    {
        $client = $this->createClient(500);
        $versio = new Versio('test', 'test', $client);

        $domain = $versio->domain();
        $response = $domain->check('admin');
    }

    private function createClient($responseCode, $body = '')
    {
        $response = new Response($responseCode, [], $body);

        $mock = new MockHandler([
            $response,
        ]);

        $handler = HandlerStack::create($mock);
        $client = new Client(['handler' => $handler]);

        return $client;
    }
}
