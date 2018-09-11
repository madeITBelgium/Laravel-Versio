<?php

use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use MadeITBelgium\Versio\Versio;

class DomainTest extends \PHPUnit\Framework\TestCase
{
    public function setUp()
    {
        parent::setUp();
    }

    public function testConstruct()
    {
        $versio = new Versio('test', 'test');
        $domain = $versio->domain();

        $this->assertEquals($versio, $domain->getVersio());
    }
    
    public function testCreateUser()
    {
        $versio = new Versio('test', 'test');

        $body = json_encode(['test' => 'test']);
        $response = new Response(200, [], $body);

        $mock = new MockHandler([
            $response,
        ]);

        $handler = HandlerStack::create($mock);
        $client = new Client(['handler' => $handler]);

        $versio->setClient($client);

        $domain = $versio->domain();
        $response = $domain->check('admin');

        $this->assertEquals(['test' => 'test'], $response);
    }
}
