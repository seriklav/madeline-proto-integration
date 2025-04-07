<?php

declare(strict_types=1);

namespace Buyme\MadelineProtoIntegration\Services\V1\Telegram\Auth;

use Buyme\MadelineProtoIntegration\Enum\Http\HttpRequestMethodsEnum;
use Buyme\MadelineProtoIntegration\Enum\Telegram\Endpoints\V1\Auth\TelegramAuthEndpointsEnum;
use Buyme\MadelineProtoIntegration\Enum\Telegram\MessageCodesEnum;
use Buyme\MadelineProtoIntegration\Exceptions\MadelineRequestException;
use Buyme\MadelineProtoIntegration\Services\V1\Http\MadelineHttpClientService;
use Buyme\MadelineProtoIntegration\Traits\GuzzleHttp\GuzzleHttpResponseTrait;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Arr;
use Throwable;

readonly class TelegramAuthService
{
    use GuzzleHttpResponseTrait;

    public function __construct(private MadelineHttpClientService $httpClientService)
    {
    }

    public function check(): bool
    {
        try {
            $response = $this->httpClientService->performRequest(
                HttpRequestMethodsEnum::METHOD_GET->value,
                TelegramAuthEndpointsEnum::CHECK_AUTH->value,
            );
        } catch (Throwable) {
            return false;
        }

        return boolval($response['data']['authenticated'] ?? false);
    }

    /**
     * @throws Throwable
     */
    public function startBotLogin(): MessageCodesEnum
    {
        try {
            $this->httpClientService->performRequest(
                HttpRequestMethodsEnum::METHOD_POST->value,
                TelegramAuthEndpointsEnum::START_BOT_LOGIN->value,
            );

            return MessageCodesEnum::SUCCESS;
        } catch (Throwable $th) {
            report($th);

            throw $th;
        }
    }

    /**
     * @throws Throwable
     */
    public function startUserLogin(): MessageCodesEnum
    {
        try {
            $this->httpClientService->performRequest(
                HttpRequestMethodsEnum::METHOD_POST->value,
                TelegramAuthEndpointsEnum::START_USER_LOGIN->value,
            );

            return MessageCodesEnum::SUCCESS;
        } catch (RequestException $exception) {
            $decodedContent = $this->getRequestExceptionContent($exception);
            $messageCode = strval(Arr::get($decodedContent, 'message_code'));

            if ($messageCode !== MessageCodesEnum::CONFIRMATION_CODE_REQUIRED->value) {
                throw new MadelineRequestException(
                    strval(Arr::get($decodedContent, 'message')),
                    $exception->getCode(),
                    $exception,
                    $messageCode
                );
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
    public function completeUserLogin(string $code): MessageCodesEnum
    {
        $requestParams = [
            'code' => $code,
        ];

        try {
            $this->httpClientService->performRequest(
                HttpRequestMethodsEnum::METHOD_POST->value,
                TelegramAuthEndpointsEnum::COMPLETE_USER_LOGIN->value,
                $requestParams,
            );

            return MessageCodesEnum::SUCCESS;
        } catch (RequestException $exception) {
            $decodedContent = $this->getRequestExceptionContent($exception);
            $messageCode = strval(Arr::get($decodedContent, 'message_code'));

            if ($messageCode !== MessageCodesEnum::CONFIRMATION_2FA_REQUIRED->value) {
                throw new MadelineRequestException(
                    strval(Arr::get($decodedContent, 'message')),
                    $exception->getCode(),
                    $exception,
                    $messageCode
                );
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
    public function complete2FaUserLogin(string $code): MessageCodesEnum
    {
        $requestParams = [
            'code' => $code,
        ];

        try {
            $this->httpClientService->performRequest(
                HttpRequestMethodsEnum::METHOD_POST->value,
                TelegramAuthEndpointsEnum::COMPLETE_2FA_USER_LOGIN->value,
                $requestParams,
            );

            return MessageCodesEnum::SUCCESS;
        } catch (Throwable $th) {
            report($th);

            throw $th;
        }
    }
}
