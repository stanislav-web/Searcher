<?php
namespace Test\Searcher\Hydrators;

use Searcher\Searcher\Hydrators\ArrayHydrator;

/**
 * Class ArrayHydratorTest
 *
 * @package   Test\Searcher\Hydrators
 * @subpackage   Test\Searcher\Hydrators\ArrayHydratorTest
 * @since     PHP >=5.5.12
 * @version   1.0
 * @author    Stanislav WEB | Lugansk <stanisov@gmail.com>
 * @copyright Stanislav WEB
 */
class ArrayHydratorTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Array class object
     *
     * @var Array
     */
    private $arrayHydrator;

    /**
     * ReflectionClass
     *
     * @var \ReflectionClass
     */
    private $reflection;

    /**
     * Initialize testing object
     *
     * @uses Builder
     * @uses \ReflectionClass
     */
    public function setUp()
    {
        $this->reflection = new \ReflectionClass('Searcher\Searcher\Hydrators\ArrayHydrator');

        $res =  new \Phalcon\Mvc\Model\Resultset\Simple(['id', 'name', 'description'], 'Model', array());

        $this->arrayHydrator = new ArrayHydrator($res);
    }

    /**
     * Kill testing object
     */
    public function tearDown()
    {
        $this->arrayHydrator = null;
    }

    public function testClass()
    {
        // check method setMin
        $this->assertTrue(
            method_exists($this->arrayHydrator, 'extract'),
            '[-] Class ArrayHydrator must have method extract()'
        );
        $this->assertInstanceOf('\Searcher\Searcher\Aware\HydratorInterface', $this->arrayHydrator,
            '[-] Class ArrayHydrator must be implemented from HydratorInterface'
        );

        $reflectionProperty = $this->reflection->getProperty('result');
        $reflectionProperty->setAccessible(true);
        $result = $reflectionProperty->getValue($this->arrayHydrator);

        // check result property
        $this->assertInstanceOf('Phalcon\Mvc\Model\Resultset\Simple', $result,
            '[-] $result variable must return Phalcon\Mvc\Model\Resultset\Simple object'
        );

        // check extract
        $this->assertInternalType('array', $this->arrayHydrator->extract(),
            '[-] extract() method must return type array'
        );

        $this->assertNotNull($this->arrayHydrator->extract(function($res) {
            return $res;
            }),
            '[-] If your callback in use, it will make to throw any response apart from NULL'
        );
    }
}
