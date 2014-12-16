<?php
namespace Searcher\Searcher\Factories;

/**
 * Class ExceptionFactory
 * @package Searcher
 * @subpackage Searcher\Searcher\Factories
 * @since PHP >=5.5.12
 * @version 1.0
 * @author Stanislav WEB | Lugansk <stanisov@gmail.com>
 * @copyright Stanislav WEB
 */
class ExceptionFactory extends \Exception
{

    /**
     * Rise error message for ColumnException
     *
     * @param string $key error key
     * @param array $params message params
     * @uses \Exception
     * @return null
     */
    public function __construct($key, array $params)
    {

        // Create a closure for callback class

        $onError = function ($params) use ($key) {

            $error = "Searcher\\Searcher\\Exceptions\\" . ucfirst($key);
            return (new $error())->rise($params, $this->getLine(), $this->getFile())->getMessage();

        };

        // return exception message
        return parent::__construct($onError($params));
    }
}
  