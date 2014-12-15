<?php
namespace Phalcon\Searcher\Exceptions;

use Phalcon\Searcher\Aware\ExceptionInterface;

/**
 * Class DataType
 * @package Phalcon Searcher
 * @subpackage Phalcon\Searcher\Exceptions
 * @since PHP >=5.5.12
 * @version 1.0
 * @author Stanislav WEB | Lugansk <stanisov@gmail.com>
 * @copyright Stanislav WEB
 */
class DataType implements ExceptionInterface {

	/**
	 * Getting data type for some use
	 * @var null|string
	 */
	private $dataType	=	null;

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

		$this->dataType	=	gettype($params[0]);
		$this->_message	=	"Wrong Type: ".$this->dataType." . Expected ".$params[1].". File: ".$filename." Line: ".$line;

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