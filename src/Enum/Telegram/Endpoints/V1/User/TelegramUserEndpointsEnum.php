<?php

declare(strict_types=1);

namespace Buyme\MadelineProtoIntegration\Enum\Telegram\Endpoints\V1\User;

enum TelegramUserEndpointsEnum: string
{
    case EXISTS_BY_USERNAME = 'v1/telegram/users/exists/by-username';
}
