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
	 * Rise error message for non existing columns
	 *
	 * @param string $string
	 * @param array $param
	 * @param array $supported
	 *
	 * @return \LogicException
	 */
	public function __construct($string, array $param, array $supported) {
		return parent::__construct('Column `'.implode('`, `', $param).'` not supported in '.$string.'. Only `'.implode('`, `', $supported).'`. Line: '.$this->getLine());
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
  