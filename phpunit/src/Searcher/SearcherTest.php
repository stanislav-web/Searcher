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
 * @copyright Stanilav WEB
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
}
 