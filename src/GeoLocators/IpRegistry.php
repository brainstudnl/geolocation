<?php

namespace Brainstud\UnlimitedGeolocation\GeoLocators;

use Brainstud\UnlimitedGeolocation\Geolocation;
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

    public function getGeolocation(string $ip): ?Geolocation
    {
        if (! ($baseUrl = config('unlimited-geolocation.ip-registry.base_url'))
            || ! ($apiKey = config('unlimited-geolocation.ip-registry.key'))
        ) {
            return null;
        }

        try {
            $res = $this->client->request('GET', "$baseUrl/$ip?key=$apiKey");
            $data = json_decode($res->getBody()->getContents());

            return Geolocation::fromIpRegistry($data);
        } catch (RequestException $e) {
            if ($e->hasResponse() && $e->getResponse()->getStatusCode() === 400) {
                return null;
            }

            throw $e;
        }
    }
}
