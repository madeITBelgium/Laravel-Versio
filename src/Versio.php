<?php

namespace MadeITBelgium\Versio;

use GuzzleHttp\Client;
use MadeITBelgium\Versio\Exceptions\ContactNotFoundException;
use MadeITBelgium\Versio\Exceptions\RateLimitException;

/**
 * Versio API.
 *
 * @version    0.0.1
 *
 * @copyright  Copyright (c) 2018 Made I.T. (http://www.madeit.be)
 * @author     Made I.T. <info@madeit.be>
 * @license    http://www.gnu.org/licenses/old-licenses/lgpl-3.0.txt    LGPL
 */
class Versio
{
    protected $version = '0.0.1';

    private $client;

    private $lastResultCode;

    /**
     * Construct Versio.
     *
     * @param $server
     * @param $hash
     * @param $client
     */
    public function __construct($username, $password, $client = null, $test = false)
    {
        $hostname = 'https://www.versio.nl/api/v1/';
        if ($test) {
            $hostname = 'https://www.versio.nl/testapi/v1/';
        }

        if ($client == null) {
            $this->client = new Client([
                'base_uri' => $hostname,
                'timeout'  => 5.0,
                'headers'  => [
                    'User-Agent' => 'Made I.T. Versio SDK V'.$this->version,
                    'Accept'     => 'application/json',
                ],
                'auth'       => [$username, $password],
                'verify'     => true,
            ]);
        } else {
            $this->client = $client;
        }
    }

    public function setClient($client)
    {
        $this->client = $client;
    }

    public function getClient()
    {
        return $this->client;
    }

    /**
     * Execute API call.
     *
     * @param $endpoint
     * @param $returnCode
     * @param $parameters
     */
    private function call($type, $url, $parameters = [])
    {
        $headers = ['json' => $parameters];

        try {
            $response = $this->client->request($type, ltrim($url, '/'), $headers);
        } catch (\GuzzleHttp\Exception\ClientException $e) {
            if ($e->getCode() == 401) {
                $response = $e->getResponse();
                $error = json_decode((string) $response->getBody());
                if ($error->error->message === 'ObjectDoesNotExist|Contact not found') {
                    throw new ContactNotFoundException($e);
                }
            } elseif ($e->getCode() === 429) {
                throw new RateLimitException($e);
            }

            throw $e;
        }
        
        if ($response->getStatusCode() == 200 || $response->getStatusCode() == 201) {
            $body = (string) $response->getBody();
        } else {
            throw \Exception('Versio error: '.$response->getStatusCode());
        }

        return json_decode($body, true);
    }

    public function get($url)
    {
        return $this->call('GET', $url);
    }

    public function delete($url)
    {
        return $this->call('DELETE', $url);
    }

    public function post($url, $data)
    {
        return $this->call('POST', $url, $data);
    }

    public function contact()
    {
        $contact = new Command\Contact();
        $contact->setVersio($this);

        return $contact;
    }

    public function domain()
    {
        $domain = new Command\Domain();
        $domain->setVersio($this);

        return $domain;
    }

    public function tld()
    {
        $tld = new Command\TLD();
        $tld->setVersio($this);

        return $tld;
    }
}
