<?php
namespace Phalcon\Phpunit\Searcher;

use \Phalcon\Searcher\Validator;

/**
 * Class ValidatorTest
 * @package Phalcon
 * @subpackage Phalcon\Searcher\Test
 * @since PHP >=5.5.12
 * @version 1.0
 * @author Stanislav WEB | Lugansk <stanisov@gmail.com>
 *
 */
class ValidatorTest extends \PHPUnit_Framework_TestCase
{

    /**
     * Validator class object
     * @var \Phalcon\Searcher\Validator
     */
    private $validator;

    /**
     * ReflectionClass
     * @var \ReflectionClass
     */
    private $reflection;

    /**
     * Initialize testing object
     * @uses \Phalcon\Searcher\Validator
     * @uses \ReflectionClass
     */
    public function setUp()
    {
        $this->validator = new Validator();
        $this->reflection = new \ReflectionClass('\Phalcon\Searcher\Validator');
    }

    /**
     * Kill testing object
     * @uses \Phalcon\Searcher\Validator
     */
    public function tearDown()
    {
        $this->validator = null;
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
        // check Validator's properties
        foreach (['columns', 'min', 'max', 'sort', 'cast', 'fields'] as $prop)
            $this->assertClassHasAttribute($prop, $this->reflection->getName(),
                "[-] The `$prop` property must be in " . $this->reflection->getName()
            );

        //check default properties

        $this->assertAttributeEquals('3', 'min', $this->validator,
            "[-] The `_min` property must have 3 as default in " . $this->reflection->getName());
        $this->assertAttributeEquals('128', 'max', $this->validator,
            "[-] The `_max` property must have 128 as default in " . $this->reflection->getName());
        $this->assertAttributeEquals('', 'cast', $this->validator,
            "[-] The `cast` property must have '' as default in " . $this->reflection->getName());
        $this->assertAttributeEquals(array(), 'fields', $this->validator,
            "[-] The `fields` property must have empty array as default in " . $this->reflection->getName());

    }

    public function testColumns()
    {
        $this->expectOutputString(''); // tell PHPUnit to expect '' as output

        // check assigned columns isn't empty
        $this->assertNotEmpty($this->validator->columns,
            "[-] The `columns` can not be empty"
        );

        // check assigned columns has type integer
        $this->assertContainsOnly('int', $this->validator->columns,
            "[-] The `columns` property must have only (int) keys"
        );

        // check count of types alowed to parse
        $this->assertCount(6, $this->validator->columns,
            "[-] The `columns` property counted must be equals to 6"
        );
    }

    public function testSort()
    {
        // check assigned sort isn't empty
        $this->assertNotEmpty($this->validator->sort,
            "[-] The `sort` can not be empty"
        );

        // check assigned sort has type string
        $this->assertContainsOnly('string', $this->validator->sort,
            "[-] The `sort` property must have only (string) keys"
        );

        foreach ($this->validator->sort as $k => $value) {
            $this->assertArrayHasKey($value, array_flip(['asc', 'desc', 'ascending', 'descending']),
                "[-] The [sort] array should not has value `" . $value . "`"
            );
        }

        // check count of sort types allowed to parse
        $this->assertCount(4, $this->validator->sort,
            "[-] The `sort` property counted must be equals to 4"
        );
    }

    /**
     * @covers \Phalcon\Searcher\Validator::setMin
     * @covers \Phalcon\Searcher\Validator::setMax
     */
    public function testLimits()
    {
        // check method setMin
        $this->assertTrue(
            method_exists($this->validator, 'setMin'),
            '[-] Class Validator have method setMin()'
        );

        // check method exists setMax
        $this->assertTrue(
            method_exists($this->validator, 'setMax'),
            '[-] Class Validator must have method setMax()'
        );

        // check return of setMin
        $this->assertSame($this->validator, $this->invokeMethod($this->validator, 'setMin', [3]),
            "[-] setMin method should return object Validator"
        );

        // check return of setMax
        $this->assertSame($this->validator, $this->invokeMethod($this->validator, 'setMax', [128]),
            "[-] setMax method should return object Validator"
        );
    }
}


 