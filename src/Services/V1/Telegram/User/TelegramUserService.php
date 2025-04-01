<?php

declare(strict_types=1);

namespace Buyme\MadelineProtoIntegration\Services\V1\Telegram\User;

use Buyme\MadelineProtoIntegration\Enum\Http\HttpRequestMethodsEnum;
use Buyme\MadelineProtoIntegration\Enum\Telegram\Endpoints\V1\User\TelegramUserEndpointsEnum;
use Buyme\MadelineProtoIntegration\Services\V1\Http\MadelineHttpClientService;
use Throwable;

readonly class TelegramUserService
{
    public function __construct(private MadelineHttpClientService $httpClientService)
    {
    }

    /**
     * @throws Throwable
     */
    public function existsByUsername(string $username): bool
    {
        $requestParams = [
            'username' => $username,
        ];

        try {
            $response = $this->httpClientService->performRequest(
                HttpRequestMethodsEnum::METHOD_GET->value,
                TelegramUserEndpointsEnum::EXISTS_BY_USERNAME->value,
                $requestParams
            );

            return boolval($response['data']['exist'] ?? false);
        } catch (Throwable $th) {
            report($th);

            throw $th;
        }
    }
}
