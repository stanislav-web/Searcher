<?php
namespace Phalcon\Searcher\Test;

use \Phalcon\Searcher\Builder;
use \Phalcon\Searcher\Searcher;

/**
 * Class BuilderTest
 * @package Phalcon
 * @subpackage Phalcon\Searcher\Test
 * @since PHP >=5.5.12
 * @version 1.0
 * @author Stanislav WEB | Lugansk <stanisov@gmail.com>
 */
class BuilderTest extends \PHPUnit_Framework_TestCase {

	/**
	 * Validator class object
	 * @var \Phalcon\Searcher\Builder
	 */
	private $builder;

	/**
	 * Initialize testing object
	 * @uses \Phalcon\Searcher\Builder
	 */
	public function setUp() {
		$this->builder = new Builder(new Searcher());
	}

	/**
	 * Kill testing object
	 * @uses \Phalcon\Searcher\Builder
	 */
	public function tearDown() {
		$this->builder = null;
	}
}
 