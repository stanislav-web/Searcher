<?php
namespace Phalcon\Searcher\Exceptions;

/**
 * Class DataTypeException
 * @package Phalcon
 * @subpackage Phalcon\Searcher\Exceptions
 * @since PHP >=5.5.12
 * @version 1.0
 * @author Stanislav WEB | Lugansk <stanisov@gmail.com>
 * @copyright Stanislav WEB
 */
class DataTypeException extends \RuntimeException {

	/**
	 * Getting datatype for some use
	 * @var null|string
	 */
	private $dataType	=	null;

	/**
	 * Rise error message for invalid data types
	 *
	 * @param mixed $value
	 * @param string $expected
	 *
	 * @return \RuntimeException
	 */
	public function __construct($value, $expected, $code = 0) {

		$this->dataType	=	gettype($value);
        return parent::__construct('Wrong Type: '.$this->dataType.' . Expected '.$expected.'. Line: '.$this->getLine(), $code);
    }

	/**
	 * toString overload
	 *
	 * @return string
	 */
	public function __toString() {
		return __CLASS__ . ": [{$this->code}]: {$this->message}\n";
	}
}