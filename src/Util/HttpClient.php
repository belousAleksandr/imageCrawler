<?php

declare(strict_types=1);

namespace App\Util;

use GuzzleHttp\Client;
use Psr\Http\Message\ResponseInterface;

class HttpClient
{
    public function request($uri, $method = 'GET'): ResponseInterface
    {
        $client = new Client();

        return $client->request($method, $uri);
    }
}