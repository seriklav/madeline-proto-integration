<?php

declare(strict_types=1);

namespace Buyme\MadelineProtoIntegration\Exceptions\Auth;

use Symfony\Component\HttpFoundation\Response;
use Exception;

class MadelineNotLoggedInException extends Exception
{
    protected $code = Response::HTTP_UNAUTHORIZED;
}
