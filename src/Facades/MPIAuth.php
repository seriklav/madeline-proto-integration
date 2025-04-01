<?php

declare(strict_types=1);

namespace Buyme\MadelineProtoIntegration\Facades;

use Buyme\MadelineProtoIntegration\Services\V1\Telegram\Auth\User\TelegramAuthUserService;
use Illuminate\Support\Facades\Facade;

/**
 * @mixin TelegramAuthUserService
 */
class MPIAuth extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'mpi-auth';
    }
}
