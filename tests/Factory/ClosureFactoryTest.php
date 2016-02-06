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
use Nia\DependencyInjection\Factory\ClosureFactory;
use Nia\DependencyInjection\ContainerInterface;

/**
 * Unit test for \Nia\DependencyInjection\Factory\ClosureFactory.
 */
class ClosureFactoryTest extends PHPUnit_Framework_TestCase
{

    /**
     * @covers \Nia\DependencyInjection\Factory\ClosureFactory::create
     */
    public function testCreate()
    {
        $factory = new ClosureFactory(function (ContainerInterface $container) {
            return new \stdClass();
        });

        $this->assertInstanceOf(\stdClass::class, $factory->create($this->getMock(ContainerInterface::class)));

        $instanceOne = $factory->create($this->getMock(ContainerInterface::class));
        $instanceTwo = $factory->create($this->getMock(ContainerInterface::class));

        $this->assertNotSame($instanceOne, $instanceTwo);
    }
}
