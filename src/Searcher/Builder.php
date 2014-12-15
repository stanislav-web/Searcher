<?php
namespace Phalcon\Searcher;

use Phalcon\Searcher\Factories\ExceptionFactory;
use \Phalcon\Db\Column;
use \Phalcon\DI as Di;

/**
 * Query builder class
 * @package Phalcon\Searcher
 * @since PHP >=5.5.12
 * @version 1.0
 * @author Stanislav WEB | Lugansk <stanisov@gmail.com>
 * @copyright Stanislav WEB
 */
class Builder implements \Phalcon\DI\InjectionAwareInterface
{
    /**
     * Dependency Injector
     * @var Di|\Phalcon\DiInterface $di
     */
    protected $di;

    /**
     * Query builder
     * @var \Phalcon\Mvc\Model\Query\Builder
     */
    private $builder;

    /**
     * Client for preparing data
     * @var \Phalcon\Searcher\Searcher
     */
    private $searcher;

    /**
     * Valid searcher data
     * @var array
     */
    private $data = [];

    /**
     * Initialize internal params
     *
     * @param \Phalcon\Searcher\Searcher $searcher
     * @uses \Phalcon\Mvc\Model\Query\Builder
     * @return null
     */
    public function __construct(Searcher $searcher)
    {
        $this->searcher = $searcher;
        $this->builder = Di::getDefault()->get('modelsManager')->createBuilder();
    }

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
     * Setup tables to Builder
     *
     * @return null
     */
    public function setTables()
    {
        foreach ($this->data['tables'] as $alias => $model) {

            // set model => alias (real table name)
            $this->builder->addFrom($model, $alias);

        }
        return null;
    }

    /**
     * Setup orders positions to Builder
     *
     * @param boolean $asArray
     * @return null
     */
    public function setOrder($asArray = false)
    {
        // set order position if exist
        $order = [];
        foreach ($this->data['order'] as $alias => $params) {

            if(true === $asArray)
                $this->builder->orderBy(array_flip($order));
            else
            {
                if (empty($params) === false) {
                    foreach ($params as $field => $sort)
                        $order[] = $alias . '.' . $field . ' ' . $sort;
                }
            }
        }
        $this->builder->orderBy($order);
        return null;
    }

    /**
     * Setup group positions to builder
     *
     * @return null
     */
    public function setGroup()
    {
        // set group position if exist

        $group = [];

        foreach ($this->data['group'] as $table => $params) {

            $params = array_flip($params);

            if (empty($params) === false) {

                foreach ($params as $field)
                    $group[] = $table . '.' . $field;
            }
        }
        $this->builder->groupBy($group);
        return null;
    }

    /**
     * Setup limit (offset)
     *
     * @return null
     */
    public function setThreshold()
    {
        if (is_array($this->data['threshold']) === false)
            $this->data['threshold'] = ['limit' => $this->data['threshold']];
        else {
            if (count($this->data['threshold']) > 1)
                $this->data['threshold'] = [
                    'limit' => $this->data['threshold'][1],
                    'offset' => $this->data['threshold'][0],
                ];
            else
                $this->data['threshold'] = [
                    'limit' => $this->data['threshold'][0]
                ];
        }

        $this->builder->limit(implode(',', array_reverse($this->data['threshold'])));

        return null;
    }

    /**
     * Setup where filter
     *
     * @return null
     */
    public function setWhere()
    {
        // checking of Exact flag
        $index = 0;
        foreach ($this->data['where'] as $alias => $fields) {

            foreach ($fields as $field => $type) {
                // call expression handler
                $this->expressionRun($alias, $field, $type, $index);
                ++$index;
            }
        }
        return null;
    }

    /**
     * Where condition customizer
     *
     * @param string $table
     * @param string $field
     * @param integer $type type of column
     * @param integer $index counter
     * @return null
     */
    public function expressionRun($table, $field, $type, $index)
    {
        if ($type === Column::TYPE_TEXT) // match search
        {
            if ($index > 0)
                $this->builder->orWhere("MATCH(" . $table . "." . $field . ") AGAINST (:query:)", $this->searcher->query);
            else
                $this->builder->where("MATCH(" . $table . "." . $field . ") AGAINST (:query:)", $this->searcher->query);

        } else {
            // simple where search
            if ($index > 0)
                $this->builder->orWhere($table . "." . $field . " LIKE :query:", $this->searcher->query);
            else
                $this->builder->where($table . "." . $field . " LIKE :query:", $this->searcher->query);
        }
        return null;
    }

    /**
     * Build query chain
     *
     * @throws ExceptionFactory {$error}
     * @return Builder|null
     */
    public function loop()
    {
        try {

            // get valid result
            $this->data = $this->searcher->getFields();

            foreach ($this->data as $key => $values) {
                // start build interface
                if (empty($values) === false)
                    $this->{'set' . ucfirst($key)}();
            }

            $res = $this->builder->getQuery()->execute();

            if ($res->valid()) {
                return $res;
            }
            return null;
        } catch (ExceptionFactory $e) {
            echo $e->getMessage();
        }
    }
}