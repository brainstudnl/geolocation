<?php

namespace Brainstud\Geolocation\GeoLocators;

use Brainstud\Geolocation\Location;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

/**
 * Implementation of the IpRegistry geo-locator.
 */
class IpRegistry implements GeoLocatorContract
{
    private Client $client;

    public function __construct()
    {
        $this->client = new Client();
    }

    public function getLocation(string $ip): ?Location
    {
        if (! ($baseUrl = config('geolocation.ip-registry.base_url'))
            || ! ($apiKey = config('geolocation.ip-registry.key'))
        ) {
            return null;
        }

        try {
            $res = $this->client->request('GET', "$baseUrl/$ip?key=$apiKey");
            $data = json_decode($res->getBody()->getContents());

            return Location::fromIpRegistry($data);
        } catch (RequestException $e) {
            if ($e->hasResponse() && $e->getResponse()->getStatusCode() === 400) {
                return null;
            }

            throw $e;
        }
    }
}
