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
namespace Nia\DependencyInjection\Provider;

use Nia\DependencyInjection\ContainerInterface;

/**
 * Interface for service provider implementations.
 * Service providers are used to register one or more services on a dependency injection container.
 */
interface ProviderInterface
{

    /**
     * Registers one or more services on the passed container.
     *
     * @param ContainerInterface $container
     *            Implementation of ContainerInterface to fill up with new services.
     */
    public function register(ContainerInterface $container);
}
