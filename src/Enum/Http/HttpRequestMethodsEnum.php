<?php

declare(strict_types=1);

namespace Buyme\MadelineProtoIntegration\Enum\Http;

enum HttpRequestMethodsEnum: string
{
    case METHOD_GET = 'GET';

    case METHOD_POST = 'POST';

    case METHOD_PUT = 'PUT';

    case METHOD_PATCH = 'PATCH';

    case METHOD_DELETE = 'DELETE';
}
