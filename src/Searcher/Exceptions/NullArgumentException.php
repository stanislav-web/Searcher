<?php
namespace Phalcon\Searcher\Exceptions;

/**
 * Class NullArgumentException
 * @package Phalcon
 * @subpackage Phalcon\Searcher\Exceptions
 * @since PHP >=5.4
 * @version 1.0
 * @author Stanislav WEB | Lugansk <stanisov@gmail.com>
 * @copyright Stanilav WEB
 */
class NullArgumentException extends \UnexpectedValueException
{
	/**
	 * @param string $class
	 * @param string $method
	 * @param int $code
	 */
	public function __construct($class, $method, $code = 0) {
		return parent::__construct('Wrong value NULL in : '.$class.'. '.$method.' Expected NOT NULL >> '.$this->getLine(), $code);
	}
}
  