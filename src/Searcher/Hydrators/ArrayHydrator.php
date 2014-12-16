<?php
namespace Searcher\Searcher\Hydrators;

use Searcher\Searcher\Aware\HydratorInterface;

/**
 * Hydrate result array from Query builder
 * @package Searcher
 * @package Searcher\Searcher\Hydrators
 * @since PHP >=5.5.12
 * @version 1.0
 * @author Stanislav WEB | Lugansk <stanisov@gmail.com>
 * @copyright Stanislav WEB
 */
class ArrayHydrator implements HydratorInterface
{

    /**
     * Result data
     * @var \Phalcon\Mvc\Model\Resultset\Simple $result
     */
    private $result;

    /**
     * @param \Phalcon\Mvc\Model\Resultset\Simple $res
     * @param callback|null $callback function to data
     */
    public function __construct(\Phalcon\Mvc\Model\Resultset\Simple $res, $callback = null)
    {
        if (null === $callback)
            $this->result = $res;
        else
            $this->result = call_user_func($callback($res));
    }

    /**
     * Extract result data
     * @param callback|null $call function
     * @return mixed
     */
    public function extract(callable $call = null)
    {
        $result = $this->result->toArray();
        if(null === $call)
            return $result;
        else
            return call_user_func($call, $result);
    }
} 