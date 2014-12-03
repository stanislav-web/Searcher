<?php
namespace Phalcon\Searcher\Exceptions;

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
	 * @param string $objectName
	 * @param int $object
	 * @param \Exception $expected
	 * @param int $code
	 */
	public function __construct($objectName, $object, $expected, $code = 0)
	{
        return parent::__construct('Wrong Type: '.gettype($objectName).' in '.$object.'. Expected '.$expected, $code);
    }
}