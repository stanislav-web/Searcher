<?php
namespace Phalcon\Searcher;

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
			$this->_validator->verify($models,['isArray', 'isNotEmpty', 'isExists']);
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
	 * Get models to participate in search
	 *
	 * @return array
	 */
	public function getList() {
		return $this->_list;
	}

	/**
	 * Get real table's names
	 *
	 * @return array
	 */
	public function getTables() {
		return $this->_validator->getTables();
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

			var_dump($this->getTables());

			//@todo prepare to query builder
			return true;

		}
		catch(Exception $e) {
			echo $e->getMessage();
		}
	}
}
