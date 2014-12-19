<?php
namespace Test\Searcher\Hydrators;

use Searcher\Searcher\Hydrators\SerializeHydrator;

/**
 * Class SerializeHydratorTest
 *
 * @package   Test\Searcher\Hydrators
 * @subpackage   Test\Searcher\Hydrators\SerializeHydratorTest
 * @since     PHP >=5.5.12
 * @version   1.0
 * @author    Stanislav WEB | Lugansk <stanisov@gmail.com>
 * @copyright Stanislav WEB
 */
class SerializeHydratorTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Serialize class object
     *
     * @var Serialize
     */
    private $serializeHydrator;

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
        $this->reflection = new \ReflectionClass('Searcher\Searcher\Hydrators\SerializeHydrator');

        $res =  new \Phalcon\Mvc\Model\Resultset\Simple(['id', 'name', 'description'], 'Model', array());

        $this->serializeHydrator = new SerializeHydrator($res);
    }

    /**
     * Kill testing object
     */
    public function tearDown()
    {
        $this->serializeHydrator = null;
    }

    public function testClass()
    {
        // check method setMin
        $this->assertTrue(
            method_exists($this->serializeHydrator, 'extract'),
            '[-] Class SerializeHydrator must have method extract()'
        );
        $this->assertInstanceOf('\Searcher\Searcher\Aware\HydratorInterface', $this->serializeHydrator,
            '[-] Class SerializeHydrator must be implemented from HydratorInterface'
        );

        $reflectionProperty = $this->reflection->getProperty('result');
        $reflectionProperty->setAccessible(true);
        $result = $reflectionProperty->getValue($this->serializeHydrator);

        // check result property
        $this->assertInstanceOf('Phalcon\Mvc\Model\Resultset\Simple', $result,
            '[-] $result variable must return Phalcon\Mvc\Model\Resultset\Simple object'
        );

        // check extract

        $this->assertInternalType('string', $this->serializeHydrator->extract(),
            '[-] extract() method must return type string'
        );

        $this->assertNotNull($this->serializeHydrator->extract(function($res) {
            return $res;
            }),
            '[-] If your callback in use, it will make to throw any response apart from NULL'
        );
    }
}
