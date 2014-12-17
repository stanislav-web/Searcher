<?php
namespace Searcher\Searcher\Aware;

/**
 * ExceptionInterface. Implementing rules necessary functionality for user's exceptions
 *
 * @package    Searcher
 * @subpackage Sweb\Searcher\Aware
 * @since      PHP >=5.5.12
 * @version    1.0
 * @author     Stanislav WEB | Lugansk <stanisov@gmail.com>
 * @copyright  Stanislav WEB
 */
interface ExceptionInterface
{

    /**
     * Rise error message for Column Exceptions
     *
     * @param array  $params   message params
     * @param int    $line     error line
     * @param string $filename file error
     * @return void
     */
    public function rise(array $params, $line, $filename);

    /**
     * Get error message
     *
     * @return string
     */
    public function getMessage();
}