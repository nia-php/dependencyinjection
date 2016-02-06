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
use Closure;

/**
 * Service factory implementation using closures to create new services.
 */
class ClosureFactory implements FactoryInterface
{

    /**
     * The closure which is used to create the new service.
     *
     * @var Closure
     */
    private $closure = null;

    /**
     * Constructor.
     *
     * @param Closure $closure
     *            The closure which is used to create the new service. The first parameter of the closure will be the passed container instance.
     */
    public function __construct(Closure $closure)
    {
        $this->closure = $closure;
    }

    /**
     *
     * {@inheritDoc}
     *
     * @see \Nia\DependencyInjection\Factory\FactoryInterface::create($container)
     */
    public function create(ContainerInterface $container)
    {
        $closure = $this->closure;

        return $closure($container);
    }
}
