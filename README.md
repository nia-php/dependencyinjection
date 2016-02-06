# nia - dependency injection component

Easy to use dependency injection handling.

## Installation

Require this package with Composer.

```bash
	composer require nia/dependencyinjection
```

## Notice
This component does not take use of annotations, config files nor other "black magic" for class instanciation - just plain reusable code. This component offers _only_ services and no parameters, because parameters can be encapsulated with map or configuration components.

## Tests
To run the unit test use the following command:

    $ cd /path/to/nia/component/
    $ phpunit --bootstrap=vendor/autoload.php tests/

## Sample: Register services
The following sample shows you how to register a non shared service. The service will be created on every service request.

```php
    $container = new Container();

    // register a non shared uuid generator - non shared because time() must be called every time.
    $container->registerService(UuidGeneratorInterface::class, new ClosureFactory(function(ContainerInterface $container) {
        return new TimeBasedUuidGenerator(time());
    }));

    // get the service and generate a new uuid.
    $uuid = $container->get(UuidGeneratorInterface::class)->generate();

```

## Sample: Register providers
The following sample shows you how to implement a provider interface and the usage of shared services. For a shared service you don't need the usage of the `static` keyword, just use the `Nia\DependencyInjection\Factory\SharedFactory` decorator.

```php
    class DatabaseProvider implements ProviderInterface
    {
        public function register(ContainerInterface $container) {
            // register a shared PDO connection.
            $container->registerService(PDO::class, new SharedFactory(new ClosureFactory(function(ContainerInterface $container){
                // [...]
                return new PDO($ds, $username, $password, $options);
            })));
        }
    }

    $container = new Container();
    $container->registerProvider(new DatabaseProvider());

    $pdo = $container->get(PDO::class);

```

## Sample: Extend a service factory.
In this sample you will see how to modify a service factory to a later time using the `Nia\DependencyInjection\Extender\ClosureExtender` implementation. For your own extender implementations you must implement the `Nia\DependencyInjection\Extender\ExtenderInterface` interface.

```php
    $container = new Container();

    // register a non shared logger implementation.
    $container->registerService(LoggerInterface::class, new ClosureFactory(function(ContainerInterface $container) {
                // [...]
                return new FileLogger($file);
    }));

    // [...]

    // modify the logger service factory - make it shared.
    $container->extendService(LoggerInterface::class, new ClosureExtender(function(FactoryInterface $factory) {
        return new SharedFactory($factory);
    }));

```
