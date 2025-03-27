<?php

declare(strict_types=1);

namespace Buyme\MadelineProtoIntegration\Services\Http\V1\Auth;

use Buyme\MadelineProtoIntegration\Services\Http\AbstractBaseHttpClientService;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Session;
use Psr\Http\Message\ResponseInterface;

final readonly class AuthHttpClientService extends AbstractBaseHttpClientService
{
    public const AUTH_TOKEN_SESSION_KEY = 'auth_token';

    public function performRequest(string $method, string $uri, array $params = [], array $headers = []): array
    {
        $baseUri = trim(strval(config('madeline-proto-integration.url')), ' \\');

        $client = new Client(['base_uri' => $baseUri . '\\']);

        $requestUri = trim($uri, ' \\');

        $this->applyDefaultHeaders($headers);

        $requestOptions = [
            'headers' => $headers,
        ];

        $this->prepareParams($method, $params, $requestUri, $requestOptions);

        $response = $client->request($method, $requestUri, $requestOptions);

        return $this->getResponseContent($response);
    }

    private function getResponseContent(ResponseInterface $response): array
    {
        $content = $response->getBody()->getContents();
        $decodedContent = json_decode($content, true);

        return ($decodedContent) ?: [];
    }

    protected function applyDefaultHeaders(array &$headers): void
    {
        parent::applyDefaultHeaders($headers);

        $authToken = Session::get(AuthHttpClientService::AUTH_TOKEN_SESSION_KEY);

        if ($authToken) {
            $headers['Authorization'] = sprintf('Bearer:%s', $authToken);
        }
    }
}
