<?php
namespace Phalcon\Searcher\Exceptions;

/**
 * Class FieldDoesNotExistException
 * @package Phalcon
 * @subpackage Phalcon\Searcher\Exceptions
 * @since PHP >=5.4
 * @version 1.0
 * @author Stanislav WEB | Lugansk <stanisov@gmail.com>
 * @copyright Stanilav WEB
 */
class FieldDoesNotExistException extends \LogicException
{
	/**
	 * @param string $object
	 * @param array $param
	 * @param array $supported
	 * @param int $code
	 */
	public function __construct($object, array $param, array $supported, $code = 0) {
		return parent::__construct('Field `'.implode('`, `', $param).'` not supported in '.$object.'. Only `'.implode('`, `', $supported).'` >> '.$this->getLine(), $code);
	}
}
  