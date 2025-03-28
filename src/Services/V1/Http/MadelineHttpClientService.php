<?php

declare(strict_types=1);

namespace Buyme\MadelineProtoIntegration\Services\V1\Http;

use Buyme\MadelineProtoIntegration\Services\V1\Auth\AuthService;
use Buyme\MadelineProtoIntegration\Services\V1\Auth\AuthTokenService;

readonly class MadelineHttpClientService extends HttpClientService
{
    public function __construct(
        private AuthTokenService $authTokenService,
        private AuthService $authService,
    ) {
        parent::__construct($this->authTokenService);
    }

    public function performRequest(string $method, string $uri, array $params = [], array $headers = []): array
    {
        $this->authService->autoLogin();

        return parent::performRequest($method, $uri, $params, $headers);
    }
}
