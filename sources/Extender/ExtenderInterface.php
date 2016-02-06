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

/**
 * Interface for all service extender implementations.
 * Extenders are used to extend service factories.
 */
interface ExtenderInterface
{

    /**
     * Extends the passed factory and returns the extended factory.
     *
     * @param FactoryInterface $factory
     *            The factory to extend.
     * @return FactoryInterface The extended factory.
     */
    public function extend(FactoryInterface $factory): FactoryInterface;
}
