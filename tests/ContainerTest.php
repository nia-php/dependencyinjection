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
namespace Test\Nia\DependencyInjection;

use PHPUnit_Framework_TestCase;
use Nia\DependencyInjection\Container;
use Nia\DependencyInjection\ContainerInterface;
use Nia\DependencyInjection\Provider\ProviderInterface;
use Nia\DependencyInjection\Factory\ClosureFactory;
use Nia\DependencyInjection\Factory\FactoryInterface;
use Nia\DependencyInjection\Factory\SharedFactory;
use Nia\DependencyInjection\Extender\ClosureExtender;
use Nia\DependencyInjection\Extender\ExtenderInterface;

/**
 * Unit test for \Nia\DependencyInjection\Container.
 */
class ContainerTest extends PHPUnit_Framework_TestCase
{

    /** @var ContainerInterface */
    private $container = null;

    protected function setUp()
    {
        $this->container = new Container();
    }

    protected function tearDown()
    {
        $this->container = null;
    }

    /**
     * @covers \Nia\DependencyInjection\Container::registerProvider
     */
    public function testRegisterProvider()
    {
        $provider = new class() implements ProviderInterface {

            public function register(ContainerInterface $container)
            {
                $container->registerService('foo', new ClosureFactory(function (ContainerInterface $container) {}));
            }
        };

        $this->assertSame(false, $this->container->has('foo'));
        $this->assertSame($this->container, $this->container->registerProvider($provider));
        $this->assertSame(true, $this->container->has('foo'));
    }

    /**
     * @covers \Nia\DependencyInjection\Container::registerService
     */
    public function testRegisterService()
    {
        $this->container = new Container();
        $this->assertSame($this->container, $this->container->registerService(\stdClass::class, new ClosureFactory(function (ContainerInterface $container) {
            return new \stdClass();
        })));

        $instanceOne = $this->container->get(\stdClass::class);
        $instanceTwo = $this->container->get(\stdClass::class);

        $this->assertInstanceOf(\stdClass::class, $instanceOne);
        $this->assertInstanceOf(\stdClass::class, $instanceTwo);

        $this->assertNotSame($instanceOne, $instanceTwo);
    }

    /**
     * @covers \Nia\DependencyInjection\Container::registerService
     */
    public function testRegisterServiceException()
    {
        $this->setExpectedException(\RuntimeException::class, 'Service "stdClass" is already defined.');

        $factory = new ClosureFactory(function (ContainerInterface $container) {
            return new \stdClass();
        });

        $this->container = new Container();
        $this->container->registerService(\stdClass::class, $factory);
        $this->container->registerService(\stdClass::class, $factory);
    }

    /**
     * @covers \Nia\DependencyInjection\Container::extendService
     */
    public function testExtendService()
    {
        $this->container = new Container();
        // create non-shared service
        $this->container->registerService(\stdClass::class, new ClosureFactory(function (ContainerInterface $container) {
            return new \stdClass();
        }));

        $instanceOne = $this->container->get(\stdClass::class);
        $instanceTwo = $this->container->get(\stdClass::class);

        $this->assertInstanceOf(\stdClass::class, $instanceOne);
        $this->assertInstanceOf(\stdClass::class, $instanceTwo);

        $this->assertNotSame($instanceOne, $instanceTwo);

        // make the service shared.
        $this->assertSame($this->container, $this->container->extendService(\stdClass::class, new ClosureExtender(function (FactoryInterface $factory) {
            return new SharedFactory($factory);
        })));

        $instanceThree = $this->container->get(\stdClass::class);
        $instanceFour = $this->container->get(\stdClass::class);

        $this->assertInstanceOf(\stdClass::class, $instanceThree);
        $this->assertInstanceOf(\stdClass::class, $instanceFour);

        $this->assertSame($instanceThree, $instanceFour);
    }

    /**
     * @covers \Nia\DependencyInjection\Container::extendService
     */
    public function testExtendServiceException()
    {
        $this->setExpectedException(\OutOfBoundsException::class, 'Service "stdClass" is not defined.');

        $this->container = new Container();
        $this->container->extendService(\stdClass::class, $this->getMock(ExtenderInterface::class));
    }

    /**
     * @covers \Nia\DependencyInjection\Container::has
     */
    public function testHas()
    {
        $this->container = new Container();

        $this->assertSame(false, $this->container->has(\stdClass::class));

        $this->container->registerService(\stdClass::class, $this->getMock(FactoryInterface::class));

        $this->assertSame(true, $this->container->has(\stdClass::class));
    }

    /**
     * @covers \Nia\DependencyInjection\Container::get
     */
    public function testGet()
    {
        $this->container = new Container();
        $this->container->registerService(\stdClass::class, new ClosureFactory(function (ContainerInterface $container) {
            return new \stdClass();
        }));

        $this->assertInstanceOf(\stdClass::class, $this->container->get(\stdClass::class));
    }

    /**
     * @covers \Nia\DependencyInjection\Container::get
     */
    public function testGetException()
    {
        $this->setExpectedException(\OutOfBoundsException::class, 'Service "stdClass" is not defined.');

        $this->container = new Container();
        $this->container->get(\stdClass::class);
    }

    /**
     * @covers \Nia\DependencyInjection\Container::getServiceNames
     */
    public function testGetServiceNames()
    {
        $this->container = new Container();

        $this->assertSame([], $this->container->getServiceNames());

        $this->container->registerService('foo', new ClosureFactory(function (ContainerInterface $container) {
            return new \stdClass();
        }));

        $this->assertSame([
            'foo'
        ], $this->container->getServiceNames());

        $this->container->registerService('bar', new ClosureFactory(function (ContainerInterface $container) {
            return new \stdClass();
        }));

        $this->assertSame([
            'foo',
            'bar'
        ], $this->container->getServiceNames());
    }
}
