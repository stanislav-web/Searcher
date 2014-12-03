<?php
namespace	Phalcon\Searcher\Exceptions;

/**
 * Class InvalidTypeException
 * @package Phalcon
 * @subpackage Phalcon\Searcher\Exceptions
 * @since PHP >=5.4
 * @version 1.0
 * @author Stanislav WEB | Lugansk <stanisov@gmail.com>
 * @copyright Stanilav WEB
 */
class InvalidTypeException extends \RuntimeException
{
	/**
	 * @param mixed $object
	 * @param string $method
	 * @param string $expected
	 * @param int $code
	 */
	public function __construct($object, $method, $expected, $code = 0) {

		$throwMessage	=	'Wrong Type: '.gettype($object).' in '.$method.'. Expected '.$expected.' >> '.$this->getLine();
        return parent::__construct($throwMessage, $code);

    }
}