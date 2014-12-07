<?php
namespace Phalcon\Searcher\Exceptions;

/**
 * Class ColumnTypeException
 * @package Phalcon
 * @subpackage Phalcon\Searcher\Exceptions
 * @since PHP >=5.5.12
 * @version 1.0
 * @author Stanislav WEB | Lugansk <stanisov@gmail.com>
 * @copyright Stanilav WEB
 */
class ColumnTypeException extends \LogicException
{
	/**
	 * Rise error message for unavailable column types
	 *
	 * @param string $column
	 * @param int $type
	 *
	 * @return \LogicException
	 */
	public function __construct($column, $type) {
		return parent::__construct('The type {'.$type.'} of column `'.$column.'` does not supported. Line: '.$this->getLine());
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
  