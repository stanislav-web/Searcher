<?php
namespace Searcher\Searcher\Hydrators;

use Searcher\Searcher\Aware\HydratorInterface;

/**
 * Hydrate result as serialized data from Query builder
 *
 * @package   Searcher
 * @package   Searcher\Searcher\Hydrators
 * @since     PHP >=5.5.12
 * @version   1.0
 * @author    Stanislav WEB | Lugansk <stanisov@gmail.com>
 * @copyright Stanislav WEB
 */
class SerializeHydrator implements HydratorInterface
{

    /**
     * Result data
     *
     * @var \Phalcon\Mvc\Model\Resultset\Simple $result
     */
    private $result;

    /**
     * Initialize result handler for serialized data
     *
     * @param \Phalcon\Mvc\Model\Resultset\Simple $res
     */
    public function __construct(\Phalcon\Mvc\Model\Resultset\Simple $res)
    {
        $this->result = $res;
    }

    /**
     * Extract result data to serialize string
     *
     * @return array
     */
    public function extract(callable $callback = null)
    {

        if ($callback === null)
            $result = $this->result->serialize();
        else
            $result = $callback($this->result->serialize());

        return $result;

    }

}
