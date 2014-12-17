<?php
namespace Searcher\Searcher\Exceptions;

use Searcher\Searcher\Aware\ExceptionInterface;

/**
 * Class Column
 *
 * @package    Searcher
 * @subpackage Searcher\Searcher\Exceptions
 * @since      PHP >=5.5.12
 * @version    1.0
 * @author     Stanislav WEB | Lugansk <stanisov@gmail.com>
 * @copyright  Stanislav WEB
 */
class Column implements ExceptionInterface
{

    /**
     * Invoke array
     *
     * @var array
     */
    private $invoke = [];

    /**
     * Message string
     *
     * @var string
     */
    private $message = '';

    /**
     * Rise error message for Column Exceptions
     *
     * @param array  $params   message params
     * @param int    $line     error line
     * @param string $filename file error
     * @return Column
     */
    public function rise(array $params, $line, $filename)
    {

        $this->invoke = [
            'COLUMN_DOES_NOT_SUPPORT' => function ($params, $filename, $line) {
                // set message for not supported column type
                $this->message = "The type {" . $params[1] . "} of column `" . $params[2] . "` does not supported. File: " . $filename . " Line: " . $line;
            },
            'COLUMN_DOES_NOT_EXISTS' => function ($params, $filename, $line) {
                // set message for not existing column
                $this->message = "Column `" . implode("`, `", $params[1]) . "` not exists in " . $params[2] . ". Only `" . implode("`, `", $params[3]) . "`. File: " . $filename . " Line: " . $line;

            },
            'ORDER_TYPES_DOES_NOT_EXISTS' => function ($params, $filename, $line) {
                // set message for not supported order type
                $this->message = "The order type(s) {" . implode(",", $params[1]) . "} does not supported in order clause. File: " . $filename . " Line: " . $line;

            },
            'EMPTY_LIST' => function ($params, $filename, $line) {
                // set message for empty search list
                $this->message = $params[1] . ". File: " . $filename . " Line: " . $line;
            }];

        $this->invoke[current($params)]($params, $filename, $line);

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
  