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
namespace Nia\DependencyInjection\Extender;

use Nia\DependencyInjection\Factory\FactoryInterface;
use Closure;

/**
 * Service factory extender using a closure.
 */
class ClosureExtender implements ExtenderInterface
{

    /**
     * The closure which extends a factory.
     *
     * @var Closure
     */
    private $closure = null;

    /**
     * Constructor.
     *
     * @param Closure $closure
     *            The closure which extends a factory.
     */
    public function __construct(Closure $closure)
    {
        $this->closure = $closure;
    }

    /**
     *
     * {@inheritDoc}
     *
     * @see \Nia\DependencyInjection\Extender\ExtenderInterface::extend($factory)
     */
    public function extend(FactoryInterface $factory): FactoryInterface
    {
        $closure = $this->closure;

        return $closure($factory);
    }
}
