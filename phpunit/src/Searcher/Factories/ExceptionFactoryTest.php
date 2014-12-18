<?php
namespace Test\Searcher\Factories;
use Searcher\Searcher\Factories;

/**
 * Class ExceptionFactoryTest
 *
 * @package    Test\Searcher\Factories
 * @subpackage Searcher\Searcher\Factories
 * @since      PHP >=5.5.12
 * @version    1.0
 * @author     Stanislav WEB | Lugansk <stanisov@gmail.com>
 * @copyright  Stanislav WEB
 */
class ExceptionFactoryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Validator class object
     *
     * @var ExceptionFactory
     */
    private $exceptionFactory;

    /**
     * ReflectionClass
     *
     * @var \ReflectionClass
     */
    private $reflection;

    /**
     * Initialize testing object
     *
     * @uses ExceptionFactory
     * @uses \ReflectionClass
     */
    public function setUp()
    {
        $this->reflection = new \ReflectionClass('\Searcher\Searcher\Factories\ExceptionFactory');
    }


    /**
     * Kill testing object
     *
     * @uses Validator
     */
    public function tearDown()
    {
        $this->exceptionFactory = null;
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
     * @covers Searcher\Searcher\Factories\ExceptionFactory::<public>
     * @covers Searcher\Searcher\Exceptions\Column::<public>
     * @covers Searcher\Searcher\Exceptions\DataType::<public>
     * @covers Searcher\Searcher\Exceptions\InvalidLength::<public>
     * @covers Searcher\Searcher\Exceptions\Model::<public>
     */
    public function testConstructor()
    {
        // assigned factory classes
        $columns    =   [
            'Column'    => [
                ['EMPTY_LIST', 'true'],
                ['COLUMN_DOES_NOT_SUPPORT', 'first', 'second'],
                ['COLUMN_DOES_NOT_EXISTS', [1,2,3], 'second', [1,2,3]],
                ['ORDER_TYPES_DOES_NOT_EXISTS', [1,2,3]],
            ],
            'Model'  =>  [['MODEL_DOES_NOT_EXISTS', 'true']],
            'DataType'  => [['true', 'true']],
            'InvalidLength'  =>  [[1,2,3]],
        ];

        foreach($columns as $column => $exceptions)
        {
            foreach($exceptions as $k => $e)
            {
                    $v = (new Factories\ExceptionFactory($column, $e))->getMessage();
                    $this->assertInternalType('string', $v,
                        "[-] The `".$column."` class must return string"
                    );
            }
        }
    }
}
