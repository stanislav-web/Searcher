<?php
namespace Phalcon\Searcher\Factories\Test;

use \Phalcon\Searcher\Factories\ExceptionFactory;
/**
 * Class ColumnTest
 * @package Test
 * @subpackage Phalcon\Searcher\Factories\Test
 * @since PHP >=5.5.12
 * @version 1.0
 * @author Stanislav WEB | Lugansk <stanisov@gmail.com>
 * @copyright Stanilav WEB
*/
class ExceptionFactoryTest extends \PHPUnit_Framework_TestCase {

	/**
	 * Validator class object
	 * @var \Phalcon\Searcher\Factories\ExceptionFactory
	 */
	private $exceptionFactory;


	/**
	 * Kill testing object
	 * @uses \Phalcon\Searcher\Factories\ExceptionFactory
	 */
	public function tearDown() {
		$this->exceptionFactory = null;
	}
}
  