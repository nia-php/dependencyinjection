<?php
/*
 * This file is part of the nia framework architecture.
 *
 * (c) Patrick Ullmann <patrick.ullmann@nat-software.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
declare(strict_types = 1);
namespace Nia\DependencyInjection;

use Nia\DependencyInjection\Factory\FactoryInterface;
use Nia\DependencyInjection\Provider\ProviderInterface;
use Nia\DependencyInjection\Extender\ExtenderInterface;
use OutOfBoundsException;
use RuntimeException;

/**
 * Default dependency injection container implementation.
 */
class Container implements ContainerInterface
{

    /**
     * Map with service factories accociated with service names.
     *
     * @var FactoryInterface
     */
    private $factories = [];

    /**
     *
     * {@inheritDoc}
     *
     * @see \Nia\DependencyInjection\ContainerInterface::registerProvider($provider)
     */
    public function registerProvider(ProviderInterface $provider): ContainerInterface
    {
        $provider->register($this);

        return $this;
    }

    /**
     *
     * {@inheritDoc}
     *
     * @see \Nia\DependencyInjection\ContainerInterface::registerService($serviceName, $factory)
     */
    public function registerService(string $serviceName, FactoryInterface $factory): ContainerInterface
    {
        if ($this->has($serviceName)) {
            throw new RuntimeException(sprintf('Service "%s" is already defined.', $serviceName));
        }

        $this->factories[$serviceName] = $factory;

        return $this;
    }

    /**
     *
     * {@inheritDoc}
     *
     * @see \Nia\DependencyInjection\ContainerInterface::extendService($serviceName, $extender)
     */
    public function extendService(string $serviceName, ExtenderInterface $extender): ContainerInterface
    {
        if (! $this->has($serviceName)) {
            throw new OutOfBoundsException(sprintf('Service "%s" is not defined.', $serviceName));
        }

        $this->factories[$serviceName] = $extender->extend($this->factories[$serviceName]);

        return $this;
    }

    /**
     *
     * {@inheritDoc}
     *
     * @see \Nia\DependencyInjection\ContainerInterface::has($serviceName)
     */
    public function has(string $serviceName): bool
    {
        return array_key_exists($serviceName, $this->factories);
    }

    /**
     *
     * {@inheritDoc}
     *
     * @see \Nia\DependencyInjection\ContainerInterface::get($serviceName)
     */
    public function get(string $serviceName)
    {
        if (! $this->has($serviceName)) {
            throw new OutOfBoundsException(sprintf('Service "%s" is not defined.', $serviceName));
        }

        return $this->factories[$serviceName]->create($this);
    }

    /**
     *
     * {@inheritDoc}
     *
     * @see \Nia\DependencyInjection\ContainerInterface::getServiceNames()
     */
    public function getServiceNames(): array
    {
        return array_keys($this->factories);
    }
}
