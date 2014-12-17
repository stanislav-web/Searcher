<?php
namespace Searcher\Searcher\Exceptions;

use Searcher\Searcher\Aware\ExceptionInterface;

/**
 * Class Model
 *
 * @package    Searcher
 * @subpackage Searcher\Searcher\Exceptions
 * @since      PHP >=5.5.12
 * @version    1.0
 * @author     Stanislav WEB | Lugansk <stanisov@gmail.com>
 * @copyright  Stanislav WEB
 */
class Model implements ExceptionInterface
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
     * Rise error message for Model Exceptions
     *
     * @param array  $params   message params
     * @param int    $line     error line
     * @param string $filename file error
     * @return \Searcher\Searcher\Exceptions\Model
     */
    public function rise(array $params, $line, $filename)
    {

        $this->invoke = [
            'MODEL_DOES_NOT_EXISTS' => function ($params, $filename, $line) {
                // set message for not existing column
                $this->message = "Model `" . $params[1] . "` not exists. File: " . $filename . " Line: " . $line;

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
  