<?php

declare(strict_types=1);

namespace Buyme\MadelineProtoIntegration\Enum\Telegram\Endpoints\V1\Auth;

enum TelegramAuthEndpointsEnum: string
{
    case CHECK_AUTH = 'v1/telegram/auth/check';

    case START_USER_LOGIN = 'v1/telegram/auth/user/start';

    case COMPLETE_USER_LOGIN = 'v1/telegram/auth/user/complete';

    case COMPLETE_2FA_USER_LOGIN = 'v1/telegram/auth/user/complete-2fa';

    case START_BOT_LOGIN = 'v1/telegram/auth/bot/start';
}
