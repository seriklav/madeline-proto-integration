<?php

declare(strict_types=1);

namespace Buyme\MadelineProtoIntegration\Services\Http\V1\Auth;

use Buyme\MadelineProtoIntegration\Enum\Http\HttpRequestMethodsEnum;
use Illuminate\Support\Facades\Session;
use Throwable;

final readonly class AuthHttpService
{
    public function __construct(private AuthHttpClientService $authHttpClientService)
    {
    }

    public function check(): bool
    {
        $requestEndpoint = 'v1/auth/check';

        try {
            $response = $this->authHttpClientService->performRequest(HttpRequestMethodsEnum::METHOD_GET->value, $requestEndpoint);
        } catch (Throwable $th) {
            return false;
        }

        return boolval($response['data']['authenticated'] ?? false);
    }

    public function login(): bool
    {
        $requestEndpoint = 'v1/auth/login';

        $params = [
          'login' => config('madeline-proto-integration.auth.login'),
          'password' => config('madeline-proto-integration.auth.password'),
        ];

        try {
            $response = $this->authHttpClientService->performRequest(
                HttpRequestMethodsEnum::METHOD_POST->value,
                $requestEndpoint,
                $params
            );

            $token = $response['data']['token'] ?? null;

            if ($token) {
                Session::put(AuthHttpClientService::AUTH_TOKEN_SESSION_KEY , $token);
            }

            return !is_null($token);
        } catch (Throwable $th) {
            return false;
        }
    }
}
