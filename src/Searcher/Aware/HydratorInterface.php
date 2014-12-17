<?php
namespace Searcher\Searcher\Aware;

/**
 * HydratorInterface. Implementing rules necessary functionality for result hydrators
 *
 * @package    Searcher
 * @subpackage Sweb\Searcher\Aware
 * @since      PHP >=5.5.12
 * @version    1.0
 * @author     Stanislav WEB | Lugansk <stanisov@gmail.com>
 * @copyright  Stanislav WEB
 */
interface HydratorInterface
{

    /**
     * Initialize
     *
     * @param  \Phalcon\Mvc\Model\Resultset\Simple $res
     * @return void
     */
    public function __construct(\Phalcon\Mvc\Model\Resultset\Simple $res);

    /**
     * Extract values from an object
     *
     * @param  callback|null $callback function to data
     * @return array
     */
    public function extract(callable $callback = null);
}
