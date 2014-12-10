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
 * @copyright Stanislav WEB
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
	 * Use Strict mode ?
	 *
	 * @param boolean $flag
	 * @example <code>
	 *          $s->setExact(true) // false , as 'query' or '%query%'
	 *          </code>
	 * @return Searcher|null
	 */
	public function setExact($flag) {
		$this->_exact	=	$flag;
		return $this;
	}

	/**
	 * Prepare models to participate in search

	 * @param array $models
	 * @example <code>
	 *          $s->setFields([
	 *          	'Model/Table1'	=>	[
	 *          		'title',
	 *          		'text'
	 *          	],
	 *         	 	'Model/Table2'	=>	[
	 *          		'name',
	 *          		'mark'
	 *          	]....
	 *          ])
	 *          </code>
	 * @return Searcher|null
	 */
	public function setFields(array $models) {

		try {
			// need to return << true
			$this->_validator->verify($models, [
				'isArray', 'isNotEmpty', 'isExists'
			], 'where');

			return $this;
		}
		catch(Exceptions $e) {
			echo $e->getMessage();
		}
	}

	/**
	 * Order results
	 *
	 * @param array $order
	 * @example <code>
	 *          $s->setOrder(['Model/Table1' => ['id DESC']])
	 *          $s->setOrder([
	 *          	'Model/Table1' => ['id DESC']
	 *          	'Model/Table2' => ['title ASC']
	 *          ])
	 *          </code>
	 * @throws \Phalcon\Exception
	 * @return Searcher|null
	 */
	public function setOrder(array $order) {

		try {
			// need to return << true
			$this->_validator->verify($order, [
				'isArray', 'isNotEmpty', 'isOrdered'
			], 'order');
			return $this;
		}
		catch(Exceptions $e) {
			echo $e->getMessage();
		}
	}

	/**
	 * Group results
	 *
	 * @param array $group
	 * @example <code>
	 *          $s->setGroup(['Model/Table1' => ['id']])
	 *          $s->setGroup([
	 *          	'Model/Table1' => ['id', 'title']
	 *          	'Model/Table2' => ['id', 'description']
	 *          ])
	 *          </code>
	 * @throws \Phalcon\Exception
	 * @return Searcher|null
	 */
	public function setGroup(array $group) {

		try {
			// need to return << true
			$this->_validator->verify($group, [
				'isArray', 'isNotEmpty', 'isExists'
			], 'group');

			return $this;
		}
		catch(Exceptions $e) {
			echo $e->getMessage();
		}
	}

	/**
	 * Prepare query value

	 * @param string $query
	 * @example <code>
	 *          $s->setQuery('what i want to find')
	 *          </code>
	 * @throws \Phalcon\Exception
	 * @return Searcher|null
	 */
	public function setQuery($query) {

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
	 * @throws \Phalcon\Exception
	 * @return array
	 */
	public function getFields() {
		return $this->_validator->fields;
	}

	/**
	 * Search procedure started
	 *
	 * @param null $query


	 * @return Builder|null
	 */
	final public function run()
	{
		try {

			$builder = (new Builder($this))->loop();
			return $builder;
		}
		catch(Exceptions $e) {
			echo $e->getMessage();
		}
	}
}
