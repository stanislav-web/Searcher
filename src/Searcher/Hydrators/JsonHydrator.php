<?php
namespace Searcher\Searcher\Hydrators;

use Searcher\Searcher\Aware\HydratorInterface;
use \Phalcon\DI as Di;

/**
 * Hydrate result json from Query builder
 * @package Searcher
 * @package Searcher\Searcher\Hydrators
 * @since PHP >=5.5.12
 * @version 1.0
 * @author Stanislav WEB | Lugansk <stanisov@gmail.com>
 * @copyright Stanislav WEB
 */
class JsonHydrator implements HydratorInterface, \Phalcon\DI\InjectionAwareInterface
{

    /**
     * Dependency Injector
     * @var Di|\Phalcon\DiInterface $di
     */
    protected $di;

    /**
     * Set DI container
     * @param \Phalcon\DiInterface $di
     */
    public function setDi($di)
    {
        $this->di = $di;
    }

    /**
     * Get DI container
     * @return Di|\Phalcon\DiInterface
     */
    public function getDi()
    {
        return $this->di;
    }

    /**
     * Result data
     * @var \Phalcon\Mvc\Model\Resultset\Simple $result
     */
    private $result;

    /**
     * Result data
     * @var string $result
     */
    private $response;

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
     * Extract to json
     * @param callback|null $call function
     * @return array|void
     */
    public function extract(callable $call = null)
    {
        $this->response = Di::getDefault()->get('response');
        $this->response->setContent(json_encode($this->result->toArray()));
        $this->response->send();
    }
} 