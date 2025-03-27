<?php

declare(strict_types=1);

namespace Buyme\MadelineProtoIntegration\Contracts;

interface HttpClientServiceInterface
{
    public function performRequest(
        string $method,
        string $uri,
        array $params = [],
        array $headers = [],
    ): array;
}
