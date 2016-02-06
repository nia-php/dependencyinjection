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
namespace Nia\DependencyInjection\Factory;

use Nia\DependencyInjection\ContainerInterface;

/**
 * Interface for service factories.
 * Service factories are used to create new services for the dependency injection container.
 */
interface FactoryInterface
{

    /**
     * Creates a new service instance.
     *
     * @param ContainerInterface $container
     *            Implementation of ContainerInterface which wants to create a new service.
     * @return mixed The created service.
     */
    public function create(ContainerInterface $container);
}
