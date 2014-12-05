<?php
namespace Phalcon\Searcher;

use Phalcon\Mvc\Model,
	Phalcon\Searcher\Exceptions,
	Phalcon\Mvc\Model\Resultset\Simple as Resultset;

/**
 * Searcher daemon class
 * @package Phalcon
 * @subpackage Phalcon\Searcher
 * @since PHP >=5.5.12
 * @version 1.0
 * @author Stanislav WEB | Lugansk <stanisov@gmail.com>
 * @copyright Stanilav WEB
 */
class Searcher extends Model {

	private

		/**
		 * Available search criteria
		 * @var array
		 */
		$_list	=	false,

		/**
		 * Query value for DB
		 * @var string
		 */
		$_query		=	null,

		/**
		 * Strict flag
		 * @var boolean
		 */
		$_strict	=	false,

		/**
		 * Verified tables
		 * @var mixed
		 */
		$_tables	=	[];

	/**
	 * setList(array $models) Set models to participate in search
	 *
	 * @param array $models
	 * @return Searcher
	 */
	public function setList(array $models)
	{
		$this->_list	=	$models;
		return $this;
	}

	/**
	 * Set query value
	 *
	 * @param string $query
	 * @return Searcher
	 */
	public function setQuery($query)
	{
		if(false === $this->_strict)
			$this->_query = [':query:' => '%'.$query.'%'];
		else
			$this->_query = [':query:' => $query];

		return $this;
	}

	/**
	 * Use Strict mode ?
	 *
	 * @param boolean $type
	 * @return Searcher
	 */
	public function useStrict($flag)
	{
		$this->_strict	=	$flag;
		return $this;
	}

	/**
	 * Get models to participate in search
	 *
	 * @return array
	 */
	public function getList()
	{
		return $this->_list;
	}

	/**
	 * Set tables without namespaces
	 *
	 * @return mixed
	 */
	public function setTables(array $table)
	{
		return $this->_tables[key($table)]	=	array_values($table)[0];
	}

	/**
	 * Search procedure started
	 *
	 * @param null $query
	 * @return array
	 */
	public function run($query = null)
	{
		if(is_null($this->_query))
			throw new Exceptions\NullArgumentException(__METHOD__, __LINE__, 1);

		if(!is_array($this->_list))
			throw new Exceptions\InvalidTypeException($this->_list, __METHOD__, 'array', 2);

		if(empty($this->_list))
			throw new \Exception('Search list does not configured', 4);

		// setup query if it true
		if(!is_null($query)) $this->setQuery($query);

		// validate fields by exist in those tables

		foreach($this->_list as $table => $fields) {

			// load model metaData
			$model 		=  	$this->_modelsManager->load($table, $this);
			$metaData 	= 	$model->getModelsMetaData();

			// check fields of table
			if(!empty($not = array_diff($fields, $metaData->getAttributes($model))))
				throw new Exceptions\ColumnDoesNotExistException($table, $not, $metaData->getAttributes($model), 3);

			// setup clear used tables
			$this->setTables([$model->getSource() => $table]);
			$columnDefines = $this->getReadConnection()->describeColumns($model->getSource());

			// checking columns
			foreach($columnDefines as $n => $column)
			{
				if(in_array($column->getName(), $fields))
				{
					$col = new Validator($column);
					if($col->isValid() === false)
						throw new Exceptions\ColumnTypeException($col->getName(), $col->getType());
				}
			}
		}

		//@todo under develop
		return $dataTypes;
	}
}
