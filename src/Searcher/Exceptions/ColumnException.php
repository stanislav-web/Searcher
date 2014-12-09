<?php
namespace Phalcon\Searcher\Exceptions;

/**
 * Class ColumnException
 * @package Phalcon
 * @subpackage Phalcon\Searcher\Exceptions
 * @since PHP >=5.5.12
 * @version 1.0
 * @author Stanislav WEB | Lugansk <stanisov@gmail.com>
 * @copyright Stanilav WEB
 */
class ColumnException extends \LogicException
{

	/**
	 * Code for "not supported type for column"
	 * @const  COLUMN_DOES_NOT_SUPPORT  has code "1"
	 */
	const COLUMN_DOES_NOT_SUPPORT  = 0;

	/**
	 * Code for "not existing column"
	 * @const  COLUMN_DOES_NOT_EXISTS  has code "0"
	 */
	const COLUMN_DOES_NOT_EXISTS    = 1;

	private

		/**
		 * Throws message
		 * @var string
		 */
		$_throws	=	'';

	/**
	 * Rise error message for columns
	 *
	 * @param int $value
	 * @param array $param
	 * @param array $supported
	 *
	 * @return \LogicException
	 */
	public function __construct($value, array $params) { //$string, array $param, array $supported) {

		switch($value) {
			case self::COLUMN_DOES_NOT_SUPPORT:	// set message for not existing column
				$this->_throws	=	'The type {'.$params[0].'} of column `'.$params[1].'` does not supported. Line: '.$this->getLine();
			break;

			case self::COLUMN_DOES_NOT_EXISTS:	// set message for not supported column
				$this->_throws	=	'Column `'.implode('`, `', $params[0]).'` not exists in '.$params[1].'. Only `'.implode('`, `', $params[2]).'`. Line: '.$this->getLine();
			break;
		}
		return parent::__construct($this->_throws);
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
  