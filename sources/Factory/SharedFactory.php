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
 * Decorator to prevent service factories to create new instances on each creation call.
 */
class SharedFactory implements FactoryInterface
{

    /**
     * The decorated factory which is used to create the new service.
     *
     * @var FactoryInterface
     */
    private $factory = null;

    /**
     * The created service stored in an array to determine if the service factory returned 'null' for a service creation.
     *
     * @var mixed[]
     */
    private $service = [];

    /**
     * Constructor.
     *
     * @param FactoryInterface $factory
     *            A service factory which is used to create the new service.
     */
    public function __construct(FactoryInterface $factory)
    {
        $this->factory = $factory;
    }

    /**
     *
     * {@inheritDoc}
     *
     * @see \Nia\DependencyInjection\Factory\FactoryInterface::create($container)
     */
    public function create(ContainerInterface $container)
    {
        if (! $this->service) {
            $this->service = [
                $this->factory->create($container)
            ];
        }

        return $this->service[0];
    }
}
