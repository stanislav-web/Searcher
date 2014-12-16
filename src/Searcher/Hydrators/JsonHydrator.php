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
     * Initialize result handler
     *
     * @param \Phalcon\Mvc\Model\Resultset\Simple $res
     */
    public function __construct(\Phalcon\Mvc\Model\Resultset\Simple $res)
    {
        $this->result = $res;
    }

    /**
     * Extract result data to json
     *
     * @param callback|null $callback function to data
     * @return mixed
     */
    public function extract(callable $callback = null)
    {
        $this->response = Di::getDefault()->get('response');

        if ($callback === null)
            $this->response->setContent(json_encode($this->result->toArray()));

        else $this->response->setContent($callback(
            json_encode($this->result->toArray())
        ));

        $this->response->send();

    }
} 