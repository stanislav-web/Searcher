<?php
namespace Phalcon\Searcher;
use Phalcon\Searcher\Exceptions;

/**
 * User's exceptions class
 * @package Phalcon
 * @subpackage Phalcon\Searcher
 * @since PHP >=5.5.12
 * @version 1.0
 * @author Stanislav WEB | Lugansk <stanisov@gmail.com>
 * @copyright Stanilav WEB
 */
class Exception {

	/**
	 * @param $arg
	 * @param $class
	 * @param $method
	 * @return bool
	 */
	public function isNull($arg, $class, $method) {
		if(is_null($arg) === true)
			throw new Exceptions\NullArgumentException($class, $method);
		return false;
	}

	/**
	 * @param $arg
	 * @param $method
	 * @param $necessary
	 * @return bool
	 */
	public function isArray($arg, $method, $necessary) {
		if(is_array($arg) === false)
			throw new Exceptions\InvalidTypeException($arg, $method, $necessary);
		return true;
	}

	/**
	 * Empty is null, false, 0 equals
	 * @param $arg
	 * @param $method
	 * @param $necessary
	 * @return bool
	 */
	public function isEmpty($arg, $method, $necessary) {
		if(empty(trim($arg)) === true)
			throw new Exceptions\InvalidTypeException($arg, $method, $necessary);
		return false;
	}
} 