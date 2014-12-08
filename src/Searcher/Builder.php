<?php
namespace Phalcon\Searcher;

use Phalcon\Mvc\Model\Manager,
	Phalcon\Searcher\Exceptions,
	Phalcon\Mvc\Model\Query\Builder as Build,
	Phalcon\Mvc\Model\Resultset\Simple as Resultset;

/**
 * Query builder class
 * @package Phalcon
 * @subpackage Phalcon\Searcher
 * @since PHP >=c
 * @version 1.0
 * @author Stanislav WEB | Lugansk <stanisov@gmail.com>
 * @copyright Stanilav WEB
 */
class Builder extends Manager {

	private
			/**
	 		 * Query value for DB
			 * @var string
			 */
			$_query		=	null,

			/**
		 	 * Query value for DB
		 	 * @var string
		 	 */
			$_structure		=	[],

			/**
			 * Query builder chained params
		 	 * @var array
		 	 */
			$_params			=	[];

	/**
	 * Initialize internal params
	 * @param array $structure
	 * @param null $query
	 * @return null
	 */
	public function __construct(array $structure, $query) {

		$this->_structure	=	$structure;
		$this->_query		=	$query;

	}

	/**
	 * Prepare build data for loop
	 *
	 * @return Builder|null
	 */
	private function _verify()
	{
		try {
			// need to return << true
			(new Validator())->verify($this->_structure, ['isArray', 'isNotEmpty']);
			return $this;
		}
		catch(Exception $e) {
			echo $e->getMessage();
		}
	}

	/**
	 * Build looper
	 *
	 * @return Builder|null
	 */
	public function loop()
	{
		try {
			// need to return << true
			$this->_verify();

			foreach($this->_structure as $model => $attributes)
			{
				// set model => alias (real table name)
				$this->_params['models'][]		=	[$model => key($attributes)];
			}

			//$queryBuilder = new Phalcon\Mvc\Model\Query\Builder($params);

		}
		catch(Exception $e) {
			echo $e->getMessage();
		}
	}

}