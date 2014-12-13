<?php
namespace Phalcon\Searcher\Test;

use \Phalcon\Searcher\Validator;
/**
 * Class ValidatorTest
 * @package Phalcon
 * @subpackage Phalcon\Searcher\Test
 * @since PHP >=5.5.12
 * @version 1.0
 * @author Stanislav WEB | Lugansk <stanisov@gmail.com>
 * @copyright Stanilav WEB
 */
class ValidatorTest extends \PHPUnit_Framework_TestCase {

	/**
	 * Validator class object
	 * @var \Phalcon\Searcher\Validator
	 */
	private $validator;

	/**
	 * Initialize testing object
	 * @uses \Phalcon\Searcher\Validator
	 */
	public function setUp() {
		$this->validator = new Validator();
	}

	/**
	 * Kill testing object
	 * @uses \Phalcon\Searcher\Validator
	 */
	public function tearDown() {
		$this->validator = null;
	}

	public function testFailure()
	{
		$i = [];
		foreach($this->validator->columns as $index)
			$i[]    =   $index;

		// check assigned columns type
		$this->assertContainsOnly('int', $i);
	}
}
 