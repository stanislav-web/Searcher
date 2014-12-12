<?php
namespace Phalcon\Searcher\Exceptions;

/**
 * Class Column
 * @package Phalcon Searcher
 * @subpackage Phalcon\Searcher\Exceptions
 * @since PHP >=5.5.12
 * @version 1.0
 * @author Stanislav WEB | Lugansk <stanisov@gmail.com>
 * @copyright Stanislav WEB
 */
class Column {

	/**
	 * Rise error types
	 * @var array $params
	 */
	public $params	=	[
		'COLUMN_DOES_NOT_SUPPORT'		=>	1,
		'COLUMN_DOES_NOT_EXISTS'		=>	2,
		'ORDER_TYPES_DOES_NOT_EXISTS'	=>	3,
		'EMPTY_LIST'					=>	4,
	];

	/**
	 * Message string
	 * @var string
	 */
	private $_message					=	'';

	/**
	 * Setup message output
	 *
	 * @param string $message
	 * @return null
	 */
	public function setMessage($message) {
		$this->_message	=	$message;
	}

	/**
	 * Rise error message for ColumnException
	 *
	 * @param array $params message params
	 * @param int $line error line
	 * @param string $filename file error
	 * @return Column
	 */
	public function rise(array $params, $line, $filename) {

		switch(current($params)) {

			case 'COLUMN_DOES_NOT_SUPPORT':	// set message for not supported column type
				$this->setMessage("The type {".$params[1]."} of column `".$params[2]."` does not supported. File: ".$filename." Line: ".$line);
			break;

			case 'COLUMN_DOES_NOT_EXISTS':	// set message for not existing column
				$this->setMessage("Column `".implode("`, `", $params[1])."` not exists in ".$params[2].". Only `".implode("`, `", $params[3])."`. File: ".$filename." Line: ".$line);
			break;

			case 'ORDER_TYPES_DOES_NOT_EXISTS':	// set message for not supported order type

				$this->setMessage("The order type(s) {".implode(",", $params[1])."} does not supported in order clause. File: ".$filename." Line: ".$line);
			break;

			case 'EMPTY_LIST':	// set message for empty search list
				$this->setMessage($params[1].". File: ".$filename." Line: ".$line);
			break;
		}

		return $this;
	}

	/**
	 * Get error message
	 *
	 * @return string
	 */
	public function getMessage() {
		return $this->_message;
	}
}
  