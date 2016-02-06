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
use OutOfBoundsException;
use RuntimeException;
use Nia\DependencyInjection\Extender\ExtenderInterface;

/**
 * Interface for all dependency injection container implementations.
 */
interface ContainerInterface
{

    /**
     * Registers a service provider.
     *
     * @param ProviderInterface $provider
     *            The provider to register.
     * @return ContainerInterface Reference to this instance.
     */
    public function registerProvider(ProviderInterface $provider): ContainerInterface;

    /**
     * Registers a service factory.
     *
     * @param string $serviceName
     *            Name of the service to register.
     * @param FactoryInterface $factory
     *            The used service factory for creation of the service.
     * @throws RuntimeException If the service name is already registred.
     * @return ContainerInterface Reference to this instance.
     */
    public function registerService(string $serviceName, FactoryInterface $factory): ContainerInterface;

    /**
     * Extends a service factory.
     *
     * @param string $serviceName
     *            Name of the service to register.
     * @param ExtenderInterface $extender
     *            The used service extender.
     * @throws RuntimeException If the service name is not registred.
     * @return ContainerInterface Reference to this instance.
     */
    public function extendService(string $serviceName, ExtenderInterface $extender): ContainerInterface;

    /**
     * Checks if a service is registred.
     *
     * @param string $serviceName
     *            Name of the service to check.
     * @return bool Returns 'true' if a service with the passed service name is registred, otherwise 'false' will be returned.
     */
    public function has(string $serviceName): bool;

    /**
     * Returns the requested service.
     *
     * @param string $serviceName
     *            Name of the service to return.
     * @throws OutOfBoundsException If the service is not registred.
     * @return mixed The requested service.
     */
    public function get(string $serviceName);

    /**
     * Returns a list with all registred services.
     *
     * @return string[] List with all registred services.
     */
    public function getServiceNames(): array;
}
