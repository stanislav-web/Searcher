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
 */
class SearcherTest extends \PHPUnit_Framework_TestCase {

	/**
	 * Validator class object
	 * @var \Phalcon\Searcher\Searcher
	 */
	private $searcher;

	/**
	 * Initialize testing object
	 * @uses \Phalcon\Searcher\Searcher
	 */
	public function setUp() {
		$this->searcher = new Searcher();
	}

	/**
	 * Kill testing object
	 * @uses \Phalcon\Searcher\Searcher
	 */
	public function tearDown() {
		$this->searcher = null;
	}

	/**
	 * @covers \Phalcon\Searcher\Searcher::getFields
	 * @expectedException     \Phalcon\Searcher\Factories\ExceptionFactory
	 * @group Searcher
	 */
	public function testFailure()
	{
		// check assigned columns isn't empty
		$this->assertEmpty($this->searcher->getFields());
	}
}
 