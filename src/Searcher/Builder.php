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
class Builder implements \Phalcon\DI\InjectionAwareInterface {

	protected $_di;

	/**
	 * Query builder
	 * @var \Phalcon\Mvc\Model\Query\Builder
	 */
	private	$builder;

	/**
	 * Client for preparing data
	 * @var \Phalcon\Searcher\Searcher
	 */
	private	$searcher;

	/**
	 * Valid searcher data
	 * @var array
	 */
	private	$_data	=	[];

	/**
	 * Initialize internal params
	 *
	 * @param \Phalcon\Searcher\Searcher $searcher
	 * @uses \Phalcon\Mvc\Model\Query\Builder
	 * @return null
	 */
	public function __construct(Searcher $searcher) {
		$this->searcher		=	$searcher;
		$this->builder			 = Di::getDefault()->get('modelsManager')->createBuilder();
	}

	public function setDi($di)
	{
		$this->_di = $di;
	}

	public function getDi()
	{
		return $this->_di;
	}

	/**
	 * Setup tables to Builder
	 *
	 * @return null
	 */
	public function setTables()
	{
		foreach($this->_data['tables'] as $alias => $model) {

			// set model => alias (real table name)
			$this->builder->addFrom($model, $alias);

		}
		return null;
	}

	/**
	 * Setup orders positions to Builder
	 *
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
		// set order position if exist

		$group	=	[];
		foreach($this->_data['group'] as $alias => $params) {

			$params = array_flip($params);

			if(empty($params) === false) {

				foreach($params as 	$field)
				{
					$group[]	=	$alias.'.'.$field;
				}

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
		if(is_array($this->_data['threshold']) === false)
			$this->_data['threshold']	=	['limit' => $this->_data['threshold']];
		else
		{
			if(count($this->_data['threshold']) > 1)
				$this->_data['threshold']	=	[
					'limit'		=> $this->_data['threshold'][1],
					'offset'	=> $this->_data['threshold'][0],
				];
			else
				$this->_data['threshold']	=	[
					'limit'		=> $this->_data['threshold'][0]
				];
		}

		$this->builder->limit(implode(',', array_reverse($this->_data['threshold'])));

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
		foreach($this->_data['where'] as $alias => $fields) {

			foreach($fields as $field => $type)
			{
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
	 * @param integer $type	type of column
	 * @param integer $index 	counter
	 * @return null
	 */
	public function expressionRun($table, $field, $type, $index)
	{
		if($type === Column::TYPE_TEXT) // match search
		{
			if($index > 0)
				$this->builder->orWhere("MATCH(".$table.".".$field.") AGAINST (':query:')", $this->searcher->query);
			else
				$this->builder->where("MATCH(".$table.".".$field.") AGAINST (':query:')", $this->searcher->query);

		}
		else // simple where search
		{
			if($index > 0)
				$this->builder->orWhere($table.".".$field." LIKE ':query:'", $this->searcher->query);
			else
				$this->builder->where($table.".".$field." LIKE ':query:'", $this->searcher->query);
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
			$this->_data = $this->searcher->getFields();

			foreach($this->_data as $key => $values) {
				// prepare tables
				if(empty($values) === false)
					$this->{'set'.ucfirst($key)}();
			}

			$res = $this->builder->getQuery()->execute();


			var_dump($res);
			var_dump($this->builder->getPhql());

			var_dump('Bind params', $this->builder->getQuery()->getBindParams());
			var_dump('Bind params types', $this->builder->getQuery()->getBindTypes());
			var_dump('Valid', $res->valid());
			var_dump('toArray',$res->toArray());
			var_dump('serialize',$res->serialize());
			var_dump('key',$res->key());
			var_dump('count',$res->count());
			var_dump('getType', $res->getType());
			var_dump('hydrate mode', $res->getHydrateMode());
			var_dump('Messages',$res->getMessages());

			exit;
			return $res;
		}
		catch(ExceptionFactory $e) {
			echo $e->getMessage();
		}
	}
}