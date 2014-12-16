<?php
namespace Phalcon\Searcher\Test;

use \Phalcon\Searcher\Searcher;
/**
 * Class SearcherTest
 * @package Phalcon
 * @subpackage Phalcon\Searcher\Test
 * @since PHP >=5.5.12
 * @version 1.0
 * @author Stanislav WEB | Lugansk <stanisov@gmail.com>
 *
 */
class SearcherTest extends \PHPUnit_Framework_TestCase
{

    /**
     * Searcher class object
     * @var \Phalcon\Searcher\Searcher
     */
    private $searcher;

    /**
     * ReflectionClass
     * @var \ReflectionClass
     */
    private $reflection;

    /**
     * Initialize testing object
     * @uses \Phalcon\Searcher\Searcher
     * @uses \ReflectionClass
     */
    public function setUp()
    {

        $this->searcher = new Searcher();
        $this->reflection = new \ReflectionClass('\Phalcon\Searcher\Searcher');
    }

    /**
     * Kill testing object
     * @uses \Phalcon\Searcher\Searcher
     */
    public function tearDown()
    {
        $this->searcher = null;
    }

    /**
     * Call protected/private method of a class.
     *
     * @param object &$object    Instantiated object that we will run method on.
     * @param string $methodName Method name to call
     * @param array  $parameters Array of parameters to pass into method.
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
     * Setup accessible any private (protected) property
     * @param $name
     * @return \ReflectionMethod
     */
    protected function getProperty($name)
    {
        $prop = $this->reflection->getProperty($name);
        $prop->setAccessible(true);
        return $prop;
    }

    public function testProperties()
    {
        // check Searcher's properties
        foreach (['query', 'exact', 'validator'] as $prop)
            $this->assertClassHasAttribute($prop, $this->reflection->getName(),
                "[-] The `$prop` property must be in " . $this->reflection->getName()
            );

        //check default properties

        $this->assertAttributeEquals(array(), 'query', $this->searcher,
            "[-] The `query` property must have array() as default in " . $this->reflection->getName());
        $this->assertAttributeEquals(false, 'exact', $this->searcher,
            "[-] The `exact` property must have false as default in " . $this->reflection->getName());
        $this->assertAttributeEquals(new \Phalcon\Searcher\Validator(), 'validator', $this->searcher,
            "[-] The `_validator` property must don't have default value in " . $this->reflection->getName());
    }

    /**
     * @covers \Phalcon\Searcher\Searcher::__construct()
     * @group Searcher properties
     */
    public function testConstructor()
    {
        // Get mock, without the constructor being called
        $mock = $this->getMockBuilder($this->reflection->getName())
            ->disableOriginalConstructor()
            ->getMock();

        // set expectations for constructor calls
        $mock->expects($this->any())->method('validator')
            ->with(
                $this->equalTo(new \Phalcon\Searcher\Validator())
            );

        // now call the constructor
        $constructor = $this->reflection->getConstructor();
        $constructor->invoke($mock);
    }

    /**
     * @covers \Phalcon\Searcher\Searcher::setExact
     */
    public function testExact()
    {
        // check method setExact
        $this->assertTrue(
            method_exists($this->searcher, 'setExact'),
            '[-] Class Searcher have method setExact()'
        );

        // calling method
        $this->searcher->setExact(true);

        // check passed param
        $this->assertContainsOnly('boolean', [$this->searcher->exact],
            "[-] The `setExact` will passed boolean param in " . $this->reflection->getName()
        );

        // check equal returning objects
        $this->assertSame($this->searcher->setExact(true), $this->searcher,
            "[-] The `setExact` will return self and passed boolean param in " . $this->reflection->getName());
    }
}


 