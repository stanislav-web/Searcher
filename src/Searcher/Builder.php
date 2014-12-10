<?php
namespace Phalcon\Searcher;

use Phalcon\Mvc\Model\Query\Builder as Build;
use Exception;

/**
 * Query builder class
 * @package Phalcon
 * @subpackage Phalcon\Searcher
 * @since PHP >=c
 * @version 1.0
 * @author Stanislav WEB | Lugansk <stanisov@gmail.com>
 * @copyright Stanislav WEB
 */
class Builder {

    /**
     * Query builder
     * @var Phalcon\Mvc\Model\Query\Builder
     */
    private	$_builder;

    /**
     * Client for preparing data
     * @var Phalcon\Searcher\Searcher
     */
    private	$_searcher;

    /**
     * Valid searcher data
     * @var array
     */
    private	$_data	=	[];

    /**
     * Initialize internal params
     * @param Searcher $searcher
     * @return null
     */
    public function __construct(Searcher $searcher) {
        $this->_searcher		=	$searcher;
        $this->_builder			=	new Build();
    }

    /**
     * Setup tables to Builder
     * @return null
     */
    public function setTables()
    {
        foreach($this->_data['tables'] as $alias => $model) {

            // set model => alias (real table name)
            $this->_builder->addFrom($model, $alias);

        }
        return null;
    }

    /**
     * Setup orders positions to Builder
     * @return null
     */
    public function setOrder()
    {
        // set order position if exist
        $order	=	[];
        foreach($this->_data['order'] as $alias => $params) {

            if(empty($params) === false) {
                foreach($params as 	$field => $sort)
                    $order[]	=	$alias.'.'.$field.' '.$sort;
            }

        }
        $this->_builder->orderBy($order);
        return null;
    }

    /**
     * Setup group positions to builder
     * @return null
     */
    public function setGroup()
    {
        // set order position if exist

        $gruop	=	[];
        foreach($this->_data['group'] as $alias => $params) {

            if(empty($params) === false) {
                foreach($params as 	$field)
                {
                    $gruop[]	=	$alias.'.'.current($field);
                }
            }

        }
        $this->_builder->groupBy($gruop);
        return null;
    }

    /**
     * Build query chain
     * @throws Exception
     * @return Builder|null
     */
    public function loop()
    {
        try {

            // get valid result
            $this->_data = $this->_searcher->getFields();

            if(empty($this->_data['tables']) === false)
                $this->setTables();
            if(empty($this->_data['order']) === false)
                $this->setOrder();
            if(empty($this->_data['group']) === false)
                $this->setGroup();
            return null;
        }
        catch(Exception $e) {
            echo $e->getMessage();
        }
    }

}