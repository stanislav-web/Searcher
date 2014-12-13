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
 *
 */
class ValidatorTest extends \PHPUnit_Framework_TestCase {

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
	public function setUp() {

		$this->validator = new Validator();
		$this->reflection = new \ReflectionClass('\Phalcon\Searcher\Validator');
	}

	/**
	 * Kill testing object
	 * @uses \Phalcon\Searcher\Validator
	 */
	public function tearDown() {
		$this->validator = null;
	}

	/**
	 * @group Validator
	 */
	public function testValidatorProperties()
	{
		// check Validator's properties
		foreach(['columns','_min', '_max', 'sort', '_cast', 'fields'] as $prop)
			$this->assertClassHasAttribute($prop, $this->reflection->getName(),
				"[-] The `$prop` property must be in ".$this->reflection->getName()
			);
	}

	/**
	 * @group Validator
	 */
	public function testValidatorColumns()
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

	/**
	 * @group Validator
	 */
	public function testValidatorSort()
	{
		// check assigned sort isn't empty
		$this->assertNotEmpty($this->validator->sort,
			"[-] The `sort` can not be empty"
		);

		// check assigned sort has type string
		$this->assertContainsOnly('string', $this->validator->sort,
			"[-] The `sort` property must have only (string) keys"
		);

		foreach($this->validator->sort as $k => $value)
		{
			$this->assertArrayHasKey($value, array_flip(['asc', 'desc', 'ascending','descending']),
				"[-] The [sort] array should not has value `".$value."`"
			);
		}

		// check count of sort types alowed to parse
		$this->assertCount(4, $this->validator->sort,
			"[-] The `sort` property counted must be equals to 4"
		);
	}
}


 