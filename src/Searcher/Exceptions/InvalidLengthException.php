<?php
namespace Phalcon\Searcher\Exceptions;

/**
 * Class InvalidLengthException
 * @package Phalcon
 * @subpackage Phalcon\Searcher\Exceptions
 * @since PHP >=5.5.12
 * @version 1.0
 * @author Stanislav WEB | Lugansk <stanisov@gmail.com>
 * @copyright Stanislav WEB
 */
class InvalidLengthException extends \LengthException
{
	/**
	 * Rise error message for invalid length values
	 *
	 * @param string $string
	 * @param string $sign
	 * @param string $value
	 *
	 * @return \LengthException
	 */
	public function __construct($string, $sign, $value) {
        return parent::__construct('The length of '.$string.' is invalid! Must be '.$sign.' then '.$value.'. Line: '.$this->getLine());
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