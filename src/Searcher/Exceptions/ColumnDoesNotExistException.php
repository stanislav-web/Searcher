<?php
namespace Phalcon\Searcher\Exceptions;

/**
 * Class ColumnDoesNotExistException
 * @package Phalcon
 * @subpackage Phalcon\Searcher\Exceptions
 * @since PHP >=5.5.12
 * @version 1.0
 * @author Stanislav WEB | Lugansk <stanisov@gmail.com>
 * @copyright Stanilav WEB
 */
class ColumnDoesNotExistException extends \LogicException
{
	/**
	 * Rise error message
	 *
	 * @param string $object
	 * @param array $param
	 * @param array $supported
	 * @param int $code
	 * @return \LogicException
	 */
	public function __construct($object, array $param, array $supported, $code = 0) {
		return parent::__construct('Column `'.implode('`, `', $param).'` not supported in '.$object.'. Only `'.implode('`, `', $supported).'` >> '.$this->getLine(), $code);
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
  