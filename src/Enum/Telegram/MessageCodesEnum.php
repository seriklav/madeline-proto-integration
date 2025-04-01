<?php

declare(strict_types=1);

namespace Buyme\MadelineProtoIntegration\Enum\Telegram;

enum MessageCodesEnum: string
{
    case CONFIRMATION_CODE_REQUIRED = 'confirmation.code.required';

    case CONFIRMATION_2FA_REQUIRED = 'confirmation.2fa.required';
}
