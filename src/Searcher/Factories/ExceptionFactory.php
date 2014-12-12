<?php
namespace Phalcon\Searcher\Factories;

/**
 * Class ExceptionFactory
 * @package Phalcon\Searcher
 * @subpackage Phalcon\Searcher\Factories
 * @since PHP >=5.5.12
 * @version 1.0
 * @author Stanislav WEB | Lugansk <stanisov@gmail.com>
 * @copyright Stanislav WEB
 */
class ExceptionFactory extends \Exception {

	/**
	 * Rise error message for ColumnException
	 *
	 * @param string $key error key
	 * @param array $params message params
	 * @param array $line error line
	 * @return null
	 */
	public function __construct($key, array $params) {

		// Create a closure for callback class

		$onError = function($params) use ($key) {

			$error = "Phalcon\\Searcher\\Exceptions\\".ucfirst($key);
			return (new $error())->rise($params, $this->getLine(), $this->getFile())->getMessage();

		};

		// return exception message
		return parent::__construct($onError($params), $code = 0);
	}
}
  