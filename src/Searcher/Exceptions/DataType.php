<?php
namespace Searcher\Searcher\Exceptions;

use Searcher\Searcher\Aware\ExceptionInterface;

/**
 * Class DataType
 *
 * @package    Searcher
 * @subpackage Searcher\Searcher\Exceptions
 * @since      PHP >=5.5.12
 * @version    1.0
 * @author     Stanislav WEB | Lugansk <stanisov@gmail.com>
 * @copyright  Stanislav WEB
 */
class DataType implements ExceptionInterface
{

    /**
     * Getting data type for some use
     *
     * @var null|string
     */
    private $dataType = null;

    /**
     * Message string
     *
     * @var string
     */
    private $message = '';

    /**
     * Rise error message for Column Exceptions
     *
     * @param  array                                  $params   message params
     * @param  int                                    $line     error line
     * @param  string                                 $filename file error
     * @return \Searcher\Searcher\Exceptions\DataType
     */
    public function rise(array $params, $line, $filename)
    {

        $this->dataType = gettype($params[0]);
        $this->message = "Wrong Type: " . $this->dataType . " . Expected " . $params[1] . ". File: " . $filename . " Line: " . $line;

        return $this;
    }

    /**
     * Get error message
     *
     * @return string
     */
    public function getMessage()
    {
        return $this->message;
    }
}
