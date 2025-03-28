<?php

declare(strict_types=1);

namespace Buyme\MadelineProtoIntegration\Services\V1\Http;

use Buyme\MadelineProtoIntegration\Contracts\HttpClientServiceInterface;
use Buyme\MadelineProtoIntegration\Enum\Http\HttpRequestMethodsEnum;
use Buyme\MadelineProtoIntegration\Services\V1\Auth\AuthTokenService;
use GuzzleHttp\Client;
use Psr\Http\Message\ResponseInterface;

readonly class HttpClientService implements HttpClientServiceInterface
{
    public function __construct(private AuthTokenService $authTokenService)
    {
    }

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

    protected function getResponseContent(ResponseInterface $response): array
    {
        $content = $response->getBody()->getContents();
        $decodedContent = json_decode($content, true);

        return ($decodedContent) ?: [];
    }

    protected function prepareParams(
        string $method,
        array $params,
        string &$requestUri,
        array &$requestOptions,
    ): void {
        if (in_array($method, [HttpRequestMethodsEnum::METHOD_POST, HttpRequestMethodsEnum::METHOD_PUT])) {
            $requestOptions['body'] = json_encode($params);

            return;
        }

        $queryParams = http_build_query($params);
        $requestUri .= '?' . $queryParams;
    }

    protected function applyDefaultHeaders(array &$headers): void
    {
        $headers['Content-Type'] = 'application/json';
        $headers['Accept'] = 'application/json';

        $authToken = $this->authTokenService->getAuthToken();

        if ($authToken) {
            $headers['Authorization'] = sprintf('Bearer %s', $authToken);
        }
    }
}
