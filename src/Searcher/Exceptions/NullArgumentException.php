<?php
namespace Phalcon\Searcher\Exceptions;

/**
 * Class NullArgumentException
 * @package Phalcon
 * @subpackage Phalcon\Searcher\Exceptions
 * @since PHP >=5.5.12
 * @version 1.0
 * @author Stanislav WEB | Lugansk <stanisov@gmail.com>
 * @copyright Stanilav WEB
 */
class NullArgumentException extends \UnexpectedValueException
{
	/**
	 * Rise error message
	 *
	 * @param string $class
	 * @param string $method
	 * @return \UnexpectedValueException
	 */
	public function __construct($class, $method) {
		return parent::__construct('Wrong value NULL in : '.$class.'. '.$method.' Expected NOT NULL. Line '.$this->getLine(), $code);
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
  