# Laravel package for integration with MadelineProto 

This package helps integrate MadelineProto in existing BuymeUa project

## Installation

- You can install this package via composer using this command:

```bash
composer buyme/madeline-proto-integration
```

- The package will automatically register itself.

- You can publish the config file using the following command:

```bash
php artisan vendor:publish --provider="Buyme\MadelineProtoIntegration\Providers\MadelineProtoIntegrationServiceProvider"
```

This will create the package's config file called `madeline-proto-integration.php` in the `config` directory. These are the contents of the published config file:

## Testing

You can run the tests with:

```bash
vendor/bin/phpunit
```

## License

The MIT License (MIT). Please see the [License File](LICENSE.txt) for more information.
