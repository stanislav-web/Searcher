<?php
namespace Phalcon\Searcher;

use Phalcon\Exception;
use Phalcon\Mvc\Model,
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
		 * Validator
		 * @var Phalcon\Searcher\Validator
		 */
		$_validator,

		/**
		 * Query value for DB
		 * @var string
		 */
		$_query		=	null,

		/**
		 * Strict flag
		 * @var boolean
		 */
		$_exact	=	false,

		/**
		 * Available search criteria
		 * @var array
		 */
		$_list		=	[],

		/**
		 * Verified tables
		 * @var mixed
		 */
		$_tables	=	[];

	/**
	 * Initialize classes
	 * @return null
	 */
	public function initialize() {
		$this->_validator	=	new Validator();
	}

	/**
	 * Set minimum value for the search
	 *
	 * @param int $min value
	 * @return Searcher
	 */
	public function setMin($min)
	{
		$this->_validator->setMin($min);
		return $this;
	}

	/**
	 * Set maximum value for the search
	 *
	 * @param int $max value
	 * @return Searcher
	 */
	public function setMax($max)
	{
		$this->_validator->setMax($max);
		return $this;
	}

	/**
	 * Prepare models to participate in search
	 *
	 * @param array $models
	 * @return Searcher
	 */
	public function setList(array $models) {
		try {
			// need to return << true
			$this->_validator->verify($models,['isArray', 'isNotEmpty']);
			$this->_list	=	$models;
			return $this;
		}
		catch(Exception $e) {
			echo $e->getMessage();
		}
	}

	/**
	 * Use Strict mode ?
	 *
	 * @param boolean $flag
	 * @return Searcher
	 */
	public function setExcact($flag)
	{
		$this->_exact	=	$flag;
		return $this;
	}

	/**
	 * Prepare query value
	 *
	 * @param string $query
	 * @return Searcher
	 */
	public function setQuery($query)
	{
		try {
			// need to return << true
			$this->_validator->verify($query,['isNotNull', 'isNotFew', 'isNotMuch']);

			if(false === $this->_strict)
				$this->_query = [':query:' => '%'.strlen($query).'%'];
			else
				$this->_query = [':query:' => $query];
			return $this;
		}
		catch(Exception $e) {
			echo $e->getMessage();
		}
	}

	/**
	 * Set tables without namespaces
	 *
	 * @param array
	 * @return array
	 */
	public function setTables(array $table)
	{
		return
			$this->_tables[key($table)]	=	array_values($table)[0];
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
	 * Search procedure started
	 *
	 * @param null $query
	 * @return array
	 */
	public function run()
	{
		try {


			exit('ITS OKAY');
		}
		catch(Exception $e) {
			echo $e->getMessage();
		}
		// validate fields by exist in those tables

		foreach($this->_list as $table => $fields) {

			// load model metaData
			$model 		=  	$this->_modelsManager->load($table, $this);
			$metaData 	= 	$model->getModelsMetaData();

			// check fields of table
			if(!empty($not = array_diff($fields, $metaData->getAttributes($model))) === true)
				throw new Exceptions\ColumnDoesNotExistException($table, $not, $metaData->getAttributes($model), 3);

			// setup clear used tables
			$this->setTables([$model->getSource() => $table]);
			$columnDefines = $this->getReadConnection()->describeColumns($model->getSource());

			// checking columns
			foreach($columnDefines as $n => $column)
			{
				if(in_array($column->getName(), $fields) === true)
				{
					$col = new Validator($column);
					if($col->isValid() === false)
						throw new Exceptions\ColumnTypeException($col->getName(), $col->getType());
				}
			}
		}

		//@todo under develop
		return true;
	}
}
