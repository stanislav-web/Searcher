<?php
namespace Phalcon\Searcher\Hydrators;

use Phalcon\Searcher\Aware\HydratorInterface;

/**
 * Hydrate result as serialized data from Query builder
 * @package Phalcon\Searcher
 * @package Phalcon\Searcher\Hydrators
 * @since PHP >=5.5.12
 * @version 1.0
 * @author Stanislav WEB | Lugansk <stanisov@gmail.com>
 * @copyright Stanislav WEB
 */
class SerializeHydrator implements HydratorInterface
{

    /**
     * Result data
     * @var mixed $result
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
            $this->result = $callback($res);
    }


    /**
     * Extract result data
     * @return array
     */
    public function extract()
    {
        return $this->result->serialize();
    }
} 