<?php
namespace Test\Searcher\Hydrators;

use Searcher\Searcher\Hydrators\JsonHydrator;
use \Phalcon\DI as Di;
use \Phalcon\Mvc\Model\Resultset;
/**
 * Class JsonHydratorTest
 *
 * @package   Test\Searcher\Hydrators
 * @subpackage   Test\Searcher\Hydrators\JsonHydratorTest
 * @since     PHP >=5.5.12
 * @version   1.0
 * @author    Stanislav WEB | Lugansk <stanisov@gmail.com>
 * @copyright Stanislav WEB
 */
class JsonHydratorTest extends \PHPUnit_Framework_TestCase
{
    /**
     * \Phalcon\DI\FactoryDefault
     *
     * @var di
     */
    private $di;

    /**
     * Json class object
     *
     * @var Json
     */
    private $jsonHydrator;

    /**
     * ReflectionClass
     *
     * @var \ReflectionClass
     */
    private $reflection;

    /**
     *
     * @var \Phalcon\Mvc\Model\Resultset\Simple
     */
    private $result;

    /**
     * Initialize testing object
     *
     * @uses \ReflectionClass
     */
    public function setUp()
    {
        $this->di = new \Phalcon\DI\FactoryDefault();

        $this->reflection = new \ReflectionClass('Searcher\Searcher\Hydrators\JsonHydrator');

        $this->result =  new \Phalcon\Mvc\Model\Resultset\Simple(['id', 'name', 'description'], 'Model', array(1,2,3,4,5));

        $this->jsonHydrator = new JsonHydrator($this->result);
    }

    /**
     * Kill testing object
     */
    public function tearDown()
    {
        $this->jsonHydrator = null;
    }

    public function testDI()
    {
        $reflectionProperty = $this->reflection->getProperty('di');
        $reflectionProperty->setAccessible(true);
        $di = $reflectionProperty->getValue($this->jsonHydrator);

        $this->assertNull($di,
            "[-] \$di property  method must return null before set instance"
        );

        $this->jsonHydrator->setDi(new Di());

        $reflectionProperty = $this->reflection->getProperty('di');
        $reflectionProperty->setAccessible(true);
        $di = $reflectionProperty->getValue($this->jsonHydrator);

        // check assigned DI
        $this->assertInstanceOf('Phalcon\DI', $di,
            '[-] \$di property must return Phalcon\DI object'
        );

        $di = $this->jsonHydrator->getDi();

        // get assigned DI
        $this->assertInstanceOf('Phalcon\DI', $di,
            '[-] \$di property must return Phalcon\DI object'
        );
    }

    public function testClass()
    {
        // check method setMin
        $this->assertTrue(
            method_exists($this->jsonHydrator, 'extract'),
            '[-] Class JsonHydrator must have method extract()'
        );
        $this->assertInstanceOf('\Searcher\Searcher\Aware\HydratorInterface', $this->jsonHydrator,
            '[-] Class JsonHydrator must be implemented from HydratorInterface'
        );

        $reflectionProperty = $this->reflection->getProperty('result');
        $reflectionProperty->setAccessible(true);
        $result = $reflectionProperty->getValue($this->jsonHydrator);

        // check result property
        $this->assertInstanceOf('Phalcon\Mvc\Model\Resultset\Simple', $result,
            '[-] $result variable must return Phalcon\Mvc\Model\Resultset\Simple object'
        );

        try {

            // check extract
            $reflectionProperty = $this->reflection->getProperty('result');
            $reflectionProperty->setAccessible(true);
            $reflectionProperty->setValue($this->jsonHydrator, $this->result);

            //@TODO
            //var_dump($this->jsonHydrator->extract()); exit;
            //$this->assertInternalType('string', $this->jsonHydrator->extract(),
            //    '[-] extract() method must return type string'
            // );

            //$this->assertInternalType('array', $this->jsonHydrator->extract(function($res) {

            //        return $res;
            //    }),
            //    '[-] If your callback in use, it will make to throw any response as string'
            //);

            //$data = $this->jsonHydrator->extract();


        }
        catch(ExceptionFactory $e) {

            // Expected exception caught! Woohoo! Ignore it
            //echo $e->getMessage();
        }

    }
}
