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
     * Extract values from an object
     *
     * @return array
     */
    public function extract();
}