<?php
namespace Test\Searcher\Aware;

use \Searcher\Searcher\Aware;
use \Searcher\Searcher\Hydrators;

/**
 * Class InterfacesTest
 * @package Test\Searcher\Aware
 * @since PHP >=5.5.12
 * @version 1.0
 * @author Stanislav WEB | Lugansk <stanisov@gmail.com>
 */
class InterfacesTest extends \PHPUnit_Framework_TestCase
{

    /**
     * Mock object sniffer
     * @var Mock_Interface
     */
    private $mock;

    /**
     * Call protected/private method of a class.
     *
     * @param object &$object Instantiated object that we will run method on.
     * @param string $methodName Method name to call
     * @param array $parameters Array of parameters to pass into method.
     * @example <code>
     *              $this->invokeMethod($user, 'cryptPassword', array('passwordToCrypt'));
     *          </code>
     * @return mixed Method return.
     */
    protected function invokeMethod(&$object, $methodName, array $parameters = array())
    {
        $method = $this->reflection->getMethod($methodName);
        $method->setAccessible(true);
        return $method->invokeArgs($object, $parameters);
    }

    /**
     * @covers \Searcher\Searcher\Aware\ExceptionInterface
     * @covers \Searcher\Searcher\Aware\HydratorInterface
     */
    public function testInstance()
    {
        $this->mock = $this->getMock('\Searcher\Searcher\Aware\ExceptionInterface');

        // check interface's compatible
        $this->assertTrue($this->mock instanceof Aware\ExceptionInterface,
            '[-] Interface ExceptionInterface is not instantiable'
        );

        $this->mock = $this->getMock('\Searcher\Searcher\Aware\HydratorInterface');
        $this->assertTrue($this->mock instanceof Aware\HydratorInterface,
            '[-] Interface HydratorInterface is not instantiable'
        );

        // check interface's instance to their objects

        $this->assertInstanceOf('\Searcher\Searcher\Aware\HydratorInterface', new Hydrators\JsonHydrator(new \Phalcon\Mvc\Model\Resultset\Simple([], null, [])),
            '[-] Class JsonHydrator() is not instantiable of interface HydratorInterface'
        );

        $this->assertInstanceOf('\Searcher\Searcher\Aware\HydratorInterface', new Hydrators\ArrayHydrator(new \Phalcon\Mvc\Model\Resultset\Simple([], null, [])),
            '[-] Class ArrayHydrator() is not instantiable of interface HydratorInterface'
        );

        $this->assertInstanceOf('\Searcher\Searcher\Aware\HydratorInterface', new Hydrators\SerializeHydrator(new \Phalcon\Mvc\Model\Resultset\Simple([], null, [])),
            '[-] Class SerializeHydrator() is not instantiable of interface HydratorInterface'
        );
    }
} 