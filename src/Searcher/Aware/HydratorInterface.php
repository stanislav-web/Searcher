<?php
namespace Phalcon\Searcher\Aware;

/**
 * HydratorInterface. Implementing rules necessary functionality for result hydrators
 * @package Phalcon Searcher
 * @subpackage Phalcon\Searcher\Aware
 * @since PHP >=5.5.12
 * @version 1.0
 * @author Stanislav WEB | Lugansk <stanisov@gmail.com>
 * @copyright Stanislav WEB
 */
interface HydratorInterface
{

    /**
     * Initialize
     * @param callback|null $callback function to data
     * @param \Phalcon\Mvc\Model\Resultset\Simple $res
     */
    public function __construct(\Phalcon\Mvc\Model\Resultset\Simple $res, $callback = null);

    /**
     * Extract values from an object
     *
     * @return array
     */
    public function extract();
}