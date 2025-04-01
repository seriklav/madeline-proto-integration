<?php

declare(strict_types=1);

namespace Buyme\MadelineProtoIntegration\Enum\Telegram\Endpoints\V1\Message;

enum TelegramMessageEndpointsEnum: string
{
    case SEND_SIMPLE_MESSAGE = 'v1/telegram/messages/send-simple-message';
}
