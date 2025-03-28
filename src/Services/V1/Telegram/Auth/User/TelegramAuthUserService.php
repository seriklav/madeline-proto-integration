<?php

declare(strict_types=1);

namespace Buyme\MadelineProtoIntegration\Services\V1\Telegram\Auth\User;

use Buyme\MadelineProtoIntegration\Enum\Http\HttpRequestMethodsEnum;
use Buyme\MadelineProtoIntegration\Enum\Telegram\MessageCodesEnum;
use Buyme\MadelineProtoIntegration\Services\V1\Http\MadelineHttpClientService;
use Illuminate\Support\Arr;
use Throwable;
use GuzzleHttp\Exception\RequestException;

readonly class TelegramAuthUserService
{
    public function __construct(private MadelineHttpClientService $httpClientService)
    {
    }

    /**
     * @throws Throwable
     */
    public function startUserLogin(): ?MessageCodesEnum
    {
        $requestEndpoint = 'v1/telegram/auth/user/start';

        try {
            $this->httpClientService->performRequest(HttpRequestMethodsEnum::METHOD_POST->value, $requestEndpoint);

            return null;
        } catch (RequestException $exception) {
            $responseData = $exception->getResponse()->getBody()->getContents();
            $decodedContent = (array) json_decode(strval($responseData), true);
            $messageCode = strval(Arr::get($decodedContent, 'message_code'));

            if ($messageCode !== MessageCodesEnum::CONFIRMATION_CODE_REQUIRED->value) {
                throw $exception;
            }

            return MessageCodesEnum::CONFIRMATION_CODE_REQUIRED;
        } catch (Throwable $th) {
            report($th);

            throw $th;
        }
    }
}
