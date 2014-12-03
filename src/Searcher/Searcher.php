<?php
namespace Phalcon\Searcher;

use Phalcon\Mvc\Model,
	Phalcon\Searcher\Exceptions,
	Phalcon\Mvc\Model\Resultset\Simple as Resultset;

/**
 * Searcher daemon class
 * @package Phalcon
 * @subpackage Phalcon\Searcher
 * @since PHP >=5.4
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
		$_searchList	=	false,

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
		 * Results data
		 * @var mixed
		 */
		$_results	=	null;

	/**
	 * setSearchList(array $models) Set models to participate in search
	 *
	 * @param array $models
	 * @return Searcher
	 */
	public function setSearchList(array $models)
	{
		$this->_searchList	=	$models;
		return $this;
	}

	/**
	 * setQuery($query) Set query value
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
	 * useStrict($flag) Use Strict mode ?
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
	 * getSearchList() Get models to participate in search
	 *
	 * @return array
	 */
	public function getSearchList()
	{
		return $this->_searchList;
	}

	/**
	 * getSearchResult() Get founded results
	 * @return mixed
	 */
	public function getSearchResult()
	{
		return $this->_results;
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

		if(!is_array($this->_searchList))
			throw new Exceptions\InvalidTypeException($this->_searchList, __METHOD__, 'array', 2);

		// setup query if it true
		if(!is_null($query)) $this->setQuery($query);

		// validate fields by exist in those tables

		foreach($this->_searchList as $table => $fields) {

			// load model metaData
			$model 		=  	$this->_modelsManager->load($table, $this);
			$metaData 	= 	$model->getModelsMetaData();

			// check fields of table
			if(!empty($not = array_diff($fields, $metaData->getAttributes($model))))
				throw new Exceptions\FieldDoesNotExistException($table, $not, $metaData->getAttributes($model), 3);

			 $dataTypes = $metaData->getDataTypes($model);

			return  $dataTypes;
		}

		return $this;
	}
}
