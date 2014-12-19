<?php
namespace Test\Searcher\Factories;
use Searcher\Searcher\Factories;
use Searcher\Searcher\Aware\ExceptionInterface;

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
     * @covers Searcher\Searcher\Factories\ExceptionFactory::<public>
     * @covers Searcher\Searcher\Exceptions\Column::<public>
     * @covers Searcher\Searcher\Exceptions\DataType::<public>
     * @covers Searcher\Searcher\Exceptions\InvalidLength::<public>
     * @covers Searcher\Searcher\Exceptions\Model::<public>
     */
    public function testRelationshipClasses()
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
            $class = 'Searcher\Searcher\Exceptions\\'.$column;

            foreach($exceptions as $k => $e)
            {
                $v = (new Factories\ExceptionFactory($column, $e));
                $this->assertInternalType('string', $v->getMessage(),
                    "[-] The `".$column."` class must return string"
                );

                $this->assertNotEmpty($v->getMessage(), "[-] The `".$column."` class must return not empty message");

                $this->assertTrue(new $class instanceof ExceptionInterface,
                    "[-] The `".strval($v)."` must be of instance of Searcher\Searcher\Aware\ExceptionInterface"
                );
            }
        }
    }

}
