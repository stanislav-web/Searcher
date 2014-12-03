<?php
namespace Phalcon\Searcher;

use \Phalcon\Mvc\Model,
	Phalcon\Searcher\Exceptions;

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
		$_searchList	=	[],

		/**
		 * Query value for DB
		 * @var string
		 */
		$_query		=	null,

		/**
		 * Strict flag
		 * @var boolean
		 */
		$_strict	=	false;

	/**
	 * setSearchList($models) Set models to participate in search
	 *
	 * @param mixed $models
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
		$this->_query	=	$query;
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
	 * @return mixed
	 */
	public function getResult()
	{
		if(null == $this->_query)
			throw new Exceptions\NullArgumentException(__METHOD__, __LINE__);

		if(!is_array($this->_searchList))
			throw new Exceptions\InvalidTypeException($this->_searchList, __METHOD__, 'array', __LINE__);

		//$this->modelsList[] =  $this->_modelsManager->load('\Models\Currency', $this);
		//$this->modelsList[] =  $this->_modelsManager->getNamespaceAliases();

		var_dump($this->getSearchList()); exit;

		return $this;
	}
}