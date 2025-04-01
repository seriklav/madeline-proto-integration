<?php

declare(strict_types=1);

namespace Buyme\MadelineProtoIntegration\Services\V1\Telegram\Auth\User;

use Buyme\MadelineProtoIntegration\Enum\Http\HttpRequestMethodsEnum;
use Buyme\MadelineProtoIntegration\Enum\Telegram\Endpoints\V1\Auth\TelegramAuthEnum;
use Buyme\MadelineProtoIntegration\Enum\Telegram\MessageCodesEnum;
use Buyme\MadelineProtoIntegration\Services\V1\Http\MadelineHttpClientService;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Arr;
use Throwable;

readonly class TelegramAuthUserService
{
    public function __construct(private MadelineHttpClientService $httpClientService)
    {
    }

    /**
     * @throws Throwable
     */
    public function startBotLogin(): void
    {
        try {
            $this->httpClientService->performRequest(
                HttpRequestMethodsEnum::METHOD_POST->value,
                TelegramAuthEnum::START_BOT_LOGIN->value,
            );

            return;
        } catch (Throwable $th) {
            report($th);

            throw $th;
        }
    }

    /**
     * @throws Throwable
     */
    public function startUserLogin(): ?MessageCodesEnum
    {
        try {
            $this->httpClientService->performRequest(
                HttpRequestMethodsEnum::METHOD_POST->value,
                TelegramAuthEnum::START_USER_LOGIN->value,
            );

            return null;
        } catch (RequestException $exception) {
            $responseData = $exception->getResponse()->getBody()->getContents();
            $decodedContent = (array)json_decode(strval($responseData), true);
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

    /**
     * @throws Throwable
     */
    public function completeUserLogin(string $code): ?MessageCodesEnum
    {
        $requestParams = [
            'code' => $code,
        ];

        try {
            $this->httpClientService->performRequest(
                HttpRequestMethodsEnum::METHOD_POST->value,
                TelegramAuthEnum::COMPLETE_USER_LOGIN->value,
                $requestParams,
            );

            return null;
        } catch (RequestException $exception) {
            $responseData = $exception->getResponse()->getBody()->getContents();
            $decodedContent = (array)json_decode(strval($responseData), true);
            $messageCode = strval(Arr::get($decodedContent, 'message_code'));

            if ($messageCode !== MessageCodesEnum::CONFIRMATION_2FA_REQUIRED->value) {
                throw $exception;
            }

            return MessageCodesEnum::CONFIRMATION_2FA_REQUIRED;
        } catch (Throwable $th) {
            report($th);

            throw $th;
        }
    }

    /**
     * @throws Throwable
     */
    public function complete2FaUserLogin(string $code): void
    {
        $requestParams = [
            'code' => $code,
        ];

        try {
            $this->httpClientService->performRequest(
                HttpRequestMethodsEnum::METHOD_POST->value,
                TelegramAuthEnum::COMPLETE_2FA_USER_LOGIN->value,
                $requestParams,
            );
        } catch (Throwable $th) {
            report($th);

            throw $th;
        }
    }
}
