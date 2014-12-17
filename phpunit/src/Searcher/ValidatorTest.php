<?php
namespace Test\Searcher;

use Searcher\Searcher;
use Searcher\Searcher\Factories\ExceptionFactory;
use \Searcher\Validator;

/**
 * Class ValidatorTest
 *
 * @package Test\Searcher
 * @since   PHP >=5.5.12
 * @version 1.0
 * @author  Stanislav WEB | Lugansk <stanisov@gmail.com>
 *
 */
class ValidatorTest extends \PHPUnit_Framework_TestCase
{

    /**
     * Validator class object
     *
     * @var Validator
     */
    private $validator;

    /**
     * ReflectionClass
     *
     * @var \ReflectionClass
     */
    private $reflection;

    /**
     * Initialize testing object
     *
     * @uses Validator
     * @uses \ReflectionClass
     */
    public function setUp()
    {
        $this->validator = new Validator();
        $this->reflection = new \ReflectionClass('\Searcher\Validator');
    }

    /**
     * Kill testing object
     *
     * @uses Validator
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
     * @covers Searcher\Validator::setMin
     * @covers Searcher\Validator::setMax
     */
    public function testLimits()
    {
        // check method setMin
        $this->assertTrue(
            method_exists($this->validator, 'setMin'),
            '[-] Class Validator must have method setMin()'
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

    /**
     * @covers Searcher\Validator::isNotNull
     */
    public function testIsNotNull()
    {
        $this->assertTrue(
            method_exists($this->validator, 'isNotNull'),
            '[-] Class Validator must have method isNotNull()'
        );

        $isNotNull = $this->invokeMethod($this->validator, 'isNotNull', ['data']);

        $this->assertNotNull($isNotNull,
            "[-] isNotNull method should return non empty data"
        );

        $this->assertTrue($isNotNull,
            "[-] isNotNull method should return true if not has an exception"
        );
    }

    /**
     * @covers Searcher\Validator::isArray
     */
    public function testIsArray()
    {
        $this->assertTrue(
            method_exists($this->validator, 'isArray'),
            '[-] Class Validator must have method isArray()'
        );

        $isArray = $this->invokeMethod($this->validator, 'isArray', ['data' => ['test']]);

        $this->assertTrue($isArray,
            "[-] isArray method should return true if not has an exception"
        );
    }

    /**
     * @covers Searcher\Validator::isNotEmpty
     */
    public function testIsNotEmpty()
    {
        $this->assertTrue(
            method_exists($this->validator, 'isNotEmpty'),
            '[-] Class Validator must have method isNotEmpty()'
        );

        $isNotEmpty = $this->invokeMethod($this->validator, 'isNotEmpty', ['data' => ['']]);

        $this->assertTrue($isNotEmpty,
            "[-] isNotEmpty method should return true if not has an exception"
        );
    }

    /**
     * @covers Searcher\Validator::isAcceptLength
     */
    public function testIsAcceptLength()
    {
        $this->assertTrue(
            method_exists($this->validator, 'isAcceptLength'),
            '[-] Class Validator must have method isAcceptLength()'
        );

        // get default property value
        $reflectionProperty = $this->reflection->getProperty('min');
        $reflectionProperty->setAccessible(true);
        $min = $reflectionProperty->getValue($this->validator);

        // generate min string length
        $string = substr(bin2hex(sha1(microtime())), 0, $min);

        // set minimum string length
        (new Searcher())->setMin(mb_strlen($string));

        // call check isAcceptLength
        $isAcceptLength = $this->invokeMethod($this->validator, 'isAcceptLength', [$string]);

        // check size of min
        $this->assertEquals($min, mb_strlen($string),
            "[-] isAcceptLength compare property `min` must be equal to " . mb_strlen($string));

        // check return
        $this->assertTrue($isAcceptLength,
            "[-] isAcceptLength method should return true while gretter than `min` property"
        );

        // get default property value
        $reflectionProperty = $this->reflection->getProperty('max');
        $reflectionProperty->setAccessible(true);
        $max = $reflectionProperty->getValue($this->validator);

        // generate max string length
        $string = substr(base64_encode(uniqid(sha1(microtime()), true) . uniqid(sha1(microtime()), true)), 0, $max);

        // set maximum string length
        (new Searcher())->setMax(mb_strlen($string));

        // call check isAcceptLength
        $isAcceptLength = $this->invokeMethod($this->validator, 'isAcceptLength', [$string]);

        // check size of min
        $this->assertEquals($max, mb_strlen($string),
            "[-] isAcceptLength compare property `max` must be equal to " . mb_strlen($string));

        // check return
        $this->assertTrue($isAcceptLength,
            "[-] isAcceptLength method should return true while less than `max` property"
        );


    }

    /**
     * @covers Searcher\Validator::isModel
     */
    public function testIsModel()
    {
        $this->assertTrue(
            method_exists($this->validator, 'isModel'),
            '[-] Class Validator must have method isModel()'
        );
    }
}


 