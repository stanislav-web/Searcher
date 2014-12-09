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
class ColumnException extends \RuntimeException
{

	/**
	 * Code for "not supported type for column"
	 * @const  COLUMN_DOES_NOT_SUPPORT  has code "1"
	 */
	const COLUMN_DOES_NOT_SUPPORT  	= 	0;

	/**
	 * Code for "not existing column"
	 * @const  COLUMN_DOES_NOT_EXISTS  has code "0"
	 */
	const COLUMN_DOES_NOT_EXISTS    = 	1;

	/**
	 * Code for "invalid user query length"
	 * @const  QUERY_INVALID_LENGTH  has code "2"
	 */
	const QUERY_INVALID_LENGTH		=	2;

	/**
	 * Code for "empty search list"
	 * @const  EMPTY_LIST  has code "3"
	 */
	const EMPTY_LIST				=	3;

	/**
	 * Code for "invalid input data type"
	 * @const  INVALID_DATA_TYPE  has code "4"
	 */
	const INVALID_DATA_TYPE			=	4;

	/**
	 * Code for "NULL is invalid"
	 * @const  NULL_ARGUMENT_PASSED  has code "5"
	 */
	const NULL_ARGUMENT_PASSED		=	5;

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
	public function __construct($value, array $params) {

		switch($value) {
			case self::COLUMN_DOES_NOT_SUPPORT:	// set message for not existing column
				$this->_throws	=	'The type {'.$params[0].'} of column `'.$params[1].'` does not supported. Line: '.$this->getLine();
			break;

			case self::COLUMN_DOES_NOT_EXISTS:	// set message for not supported column
				$this->_throws	=	'Column `'.implode('`, `', $params[0]).'` not exists in '.$params[1].'. Only `'.implode('`, `', $params[2]).'`. Line: '.$this->getLine();
			break;

			case self::QUERY_INVALID_LENGTH:	// set message for invalid user query length
				$this->_throws	=	'The length of '.$params[0].' is invalid! Must be '.$params[1].' then '.$params[2].'. Line: '.$this->getLine();
			break;

			case self::INVALID_DATA_TYPE:	// set message for invalid input data type
				$this->_throws	=	'Wrong Type: '.gettype($params[0]).' . Expected '.$params[1].'. Line: '.$this->getLine();
			break;

			case self::NULL_ARGUMENT_PASSED: // set message for NULL
				$this->_throws	=	'Wrong value NULL. Expected NOT NULL. Line: '.$this->getLine()	;
			break;

			case self::EMPTY_LIST:	// set message for empty search list
				$this->_throws	=	$params[0].'. Line: '.$this->getLine();
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
  