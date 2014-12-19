<?php
namespace Test\Searcher;

use \Searcher\Builder;
use Searcher\Searcher;
use \Searcher\Searcher\Factories\ExceptionFactory;

use \Phalcon\DI as Di;

/**
 * Class BuilderTest
 *
 * @package Test\Searcher
 * @since   PHP >=5.5.12
 * @version 1.0
 * @author  Stanislav WEB | Lugansk <stanisov@gmail.com>
 *
 */
class BuilderTest extends \PHPUnit_Framework_TestCase
{

    /**
     * Builder class object
     *
     * @var Builder
     */
    private $builder;

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
        $this->reflection = new \ReflectionClass('Searcher\Builder');
    }

    /**
     * Kill testing object
     *
     * @uses Builder
     */
    public function tearDown()
    {
        $this->builder = null;
    }

    /**
     * Call protected/private method of a class.
     *
     * @param object &$object    Instantiated object that we will run method on.
     * @param string $methodName Method name to call
     * @param array  $parameters Array of parameters to pass into method.
     * @example <code>
     *                           $this->invokeMethod($user, 'cryptPassword', array('passwordToCrypt'));
     *                           </code>
     * @return mixed Method return.
     */
    protected function invokeMethod(&$object, $methodName, array $parameters = array())
    {
        $method = $this->reflection->getMethod($methodName);
        $method->setAccessible(true);
        return $method->invokeArgs($object, $parameters);
    }

    /**
     * Setup accessible any private (protected) property
     *
     * @param $name
     * @return \ReflectionMethod
     */
    protected function getProperty($name)
    {
        $prop = $this->reflection->getProperty($name);
        $prop->setAccessible(true);
        return $prop;
    }

    /**
     * @covers Searcher\Builder::__construct()
     */
    public function testConstructor()
    {

    }
}


 