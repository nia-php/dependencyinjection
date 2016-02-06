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
namespace Test\Nia\DependencyInjection\Factory;

use PHPUnit_Framework_TestCase;
use Nia\DependencyInjection\Extender\ClosureExtender;
use Nia\DependencyInjection\Factory\FactoryInterface;

/**
 * Unit test for \Nia\DependencyInjection\Extender\ClosureExtender.
 */
class ClosureExtenderTest extends PHPUnit_Framework_TestCase
{

    /**
     * @covers \Nia\DependencyInjection\Extender\ClosureExtender::extend
     */
    public function testExtend()
    {
        $factory = $this->getMock(FactoryInterface::class);

        $extender = new ClosureExtender(function (FactoryInterface $factory) {
            return $factory;
        });

        $this->assertSame($factory, $extender->extend($factory));
    }
}
