<?php
namespace Phalcon\Searcher;
use Phalcon\Searcher\Exceptions;
/**
 * Searcher daemon class
 * @package Phalcon
 * @subpackage Phalcon\Searcher
 * @since PHP >=5.5.12
 * @version 1.0
 * @author Stanislav WEB | Lugansk <stanisov@gmail.com>
 * @copyright Stanilav WEB
 */
class Searcher {

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
		 * Fields getting from DB
		 * @var array
		 */
		$_fields		=	[],


		/**
		 * Strict flag
		 * @var boolean
		 */
		$_exact	=	false;

	/**
	 * Initialize class
	 * @return null
	 */
	public function __construct() {
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
	 * @return Searcher|null
	 */
	public function setFields(array $models) {

		try {
			// need to return << true
			$this->_validator->verify($models,['isArray', 'isNotEmpty', 'isExists']);
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
	 * @return Searcher|null
	 */
	public function setExact($flag)
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

			if(false === $this->_exact)
				$this->_query = [':query:' => '%'.strlen($query).'%'];
			else
				$this->_query = [':query:' => $query];
			return $this;
		}
		catch(Exceptions $e) {
			echo $e->getMessage();
		}
	}

	/**
	 * Get qualified valid tables & fields
	 *
	 * @return Validator
	 */
	public function getQualified() {
		return $this->_validator->collection;
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

			$builder = (new Builder($this->getQualified(), $this->_query))->loop();

		}
		catch(Exceptions $e) {
			echo $e->getMessage();
		}
	}
}
