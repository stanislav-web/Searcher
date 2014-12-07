<?php
namespace Phalcon\Searcher\Exceptions;

/**
 * Class InvalidTypeException
 * @package Phalcon
 * @subpackage Phalcon\Searcher\Exceptions
 * @since PHP >=5.5.12
 * @version 1.0
 * @author Stanislav WEB | Lugansk <stanisov@gmail.com>
 * @copyright Stanilav WEB
 */
class InvalidTypeException extends \RuntimeException
{
	/**
	 * Rise error message for invalid types
	 *
	 * @param mixed $value
	 * @param string $expected
	 *
	 * @return \RuntimeException
	 */
	public function __construct($value, $expected) {
        return parent::__construct('Wrong Type: '.gettype($value).' . Expected '.$expected.'. Line: '.$this->getLine());
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