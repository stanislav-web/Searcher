<?php
namespace Searcher\Searcher\Hydrators;

use Searcher\Searcher\Aware\HydratorInterface;

/**
 * Hydrate result array from Query builder
 *
 * @package   Searcher
 * @package   Searcher\Searcher\Hydrators
 * @since     PHP >=5.5.12
 * @version   1.0
 * @author    Stanislav WEB | Lugansk <stanisov@gmail.com>
 * @copyright Stanislav WEB
 */
class ArrayHydrator implements HydratorInterface
{

    /**
     * Result data
     *
     * @var \Phalcon\Mvc\Model\Resultset\Simple $result
     */
    private $result;

    /**
     * Initialize result handler for array
     *
     * @param \Phalcon\Mvc\Model\Resultset\Simple $res
     */
    public function __construct(\Phalcon\Mvc\Model\Resultset\Simple $res)
    {
        $this->result = $res;
    }

    /**
     * Extract result data to array
     *
     * @param  callback|null $callback function to data
     * @return mixed
     */
    public function extract(callable $callback = null)
    {

        if ($callback === null) {
            $result = $this->result->toArray();
        }
        else {
            $result = $callback($this->result->toArray());
        }

        return $result;

    }
}
