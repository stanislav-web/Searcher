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
	 		 * Client for preparing data
			 * @var Phalcon\Searcher\Searcher
			 */
			$_searcher;

	/**
	 * Initialize internal params
	 * @param Phalcon\Searcher\Searcher $searcher
	 * @return null
	 */
	public function __construct(Searcher $searcher) {
		$this->_searcher		=	$searcher;
	}

	/**
	 * Prepare build data for loop
	 *
	 * @return Builder|null
	 */
	private function _verifyFields()
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
			$this->_verifyFields();

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