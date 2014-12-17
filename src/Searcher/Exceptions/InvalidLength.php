<?php
namespace Searcher\Searcher\Exceptions;

use Searcher\Searcher\Aware\ExceptionInterface;

/**
 * Class InvalidLength
 *
 * @package    Searcher
 * @subpackage Searcher\Searcher\Exceptions
 * @since      PHP >=5.5.12
 * @version    1.0
 * @author     Stanislav WEB | Lugansk <stanisov@gmail.com>
 * @copyright  Stanislav WEB
 */
class InvalidLength implements ExceptionInterface
{

    /**
     * Message string
     *
     * @var string
     */
    private $message = '';

    /**
     * Rise error message for Length Exceptions
     *
     * @param  array                                       $params   message params
     * @param  int                                         $line     error line
     * @param  string                                      $filename file error
     * @return \Searcher\Searcher\Exceptions\InvalidLength
     */
    public function rise(array $params, $line, $filename)
    {

        $this->message = "The length of \"" . $params[0] . "\" is invalid! Must be " . $params[1] . " then " . $params[2] . ". File: " . $filename . " Line: " . $line;

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
