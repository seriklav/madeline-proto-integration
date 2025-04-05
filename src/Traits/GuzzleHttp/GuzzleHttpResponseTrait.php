<?php

declare(strict_types=1);

namespace Buyme\MadelineProtoIntegration\Traits\GuzzleHttp;

use GuzzleHttp\Exception\RequestException;

trait GuzzleHttpResponseTrait
{
    private function getRequestExceptionContent(RequestException $exception): array
    {
        $responseBody = $exception->getResponse()->getBody();
        $responseBody->rewind();
        $responseData = $responseBody->getContents();
        $responseBody->rewind();

        return (array)json_decode(strval($responseData), true);
    }
}
