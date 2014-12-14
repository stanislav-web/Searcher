<?php
namespace Phalcon\Searcher\Exceptions;

use Phalcon\Searcher\Aware\ExceptionInterface;

/**
 * Class Column
 * @package Phalcon Searcher
 * @subpackage Phalcon\Searcher\Exceptions
 * @since PHP >=5.5.12
 * @version 1.0
 * @author Stanislav WEB | Lugansk <stanisov@gmail.com>
 * @copyright Stanislav WEB
 */
class Column implements ExceptionInterface {

	/**
	 * Invoke array
	 * @var string
	 */
	private $_invoke					=	[];

	/**
	 * Message string
	 * @var string
	 */
	private $_message					=	'';

	/**
	 * Rise error message for Column Exceptions
	 *
	 * @param array $params message params
	 * @param int $line error line
	 * @param string $filename file error
	 * @return Column
	 */
	public function rise(array $params, $line, $filename) {

		$this->_invoke = [
			'COLUMN_DOES_NOT_SUPPORT' 	=> function($params, $filename, $line) {
				// set message for not supported column type
				$this->_message = "The type {".$params[1]."} of column `".$params[2]."` does not supported. File: ".$filename." Line: ".$line;
			},
			'COLUMN_DOES_NOT_EXISTS' 		=> function($params, $filename, $line) {
				// set message for not existing column
				$this->_message = "Column `".implode("`, `", $params[1])."` not exists in ".$params[2].". Only `".implode("`, `", $params[3])."`. File: ".$filename." Line: ".$line;

			},
			'ORDER_TYPES_DOES_NOT_EXISTS' => function($params, $filename, $line) {
				// set message for not supported order type
				$this->_message = "The order type(s) {".implode(",", $params[1])."} does not supported in order clause. File: ".$filename." Line: ".$line;

			},
			'EMPTY_LIST' 					=> function($params, $filename, $line) {
				// set message for empty search list
				$this->_message = $params[1].". File: ".$filename." Line: ".$line;
			}];

		$this->_invoke[current($params)]($params, $filename, $line);

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
  