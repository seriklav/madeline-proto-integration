<?php

declare(strict_types=1);

namespace Buyme\MadelineProtoIntegration\Facades;

use Buyme\MadelineProtoIntegration\Services\MadelineProtoIntegration as BaseMadelineProtoIntegration;
use Illuminate\Support\Facades\Facade;

/**
 * @see BaseMadelineProtoIntegration
 */
class MadelineProtoIntegration extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'madeline-proto-integration';
    }
}
