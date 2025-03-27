<?php

declare(strict_types=1);

namespace Buyme\MadelineProtoIntegration\Services\Http;

use Buyme\MadelineProtoIntegration\Contracts\HttpClientServiceInterface;
use Buyme\MadelineProtoIntegration\Enum\Http\HttpRequestMethodsEnum;

abstract readonly class AbstractBaseHttpClientService implements HttpClientServiceInterface
{
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
    }
}
