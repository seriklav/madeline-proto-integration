<?php

declare(strict_types=1);

namespace Buyme\MadelineProtoIntegration\Providers;

use Illuminate\Support\ServiceProvider;

class MadelineProtoIntegrationServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->publishes([
            __DIR__ . '/../config/madeline-proto-integration.php' => config_path('madeline-proto-integration.php'),
        ], 'config');

    }

    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/madeline-proto-integration.php', 'madeline-proto-integration');
    }
}
