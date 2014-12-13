<?php
namespace Phalcon\Searcher\Test;

use \Phalcon\Searcher\Validator;
use \Phalcon\Searcher\Factories\ExceptionFactory;

/**
 * Class ValidatorTest
 * @package Phalcon
 * @subpackage Phalcon\Searcher\Test
 * @since PHP >=5.5.12
 * @version 1.0
 * @author Stanislav WEB | Lugansk <stanisov@gmail.com>
 *
 * @backupGlobals disabled
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

	/**
	 * @expectedException     \Phalcon\Searcher\Factories\ExceptionFactory
	 * @group Validator
	 */
	public function testFailure()
	{
		// check assigned columns isn't empty
		$this->assertEmpty($this->validator->columns);

		// check assigned columns type
		$this->assertContainsOnly('int', $this->validator->columns);
	}
}
 