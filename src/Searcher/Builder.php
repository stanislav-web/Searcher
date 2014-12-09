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
		 * Prepared data to chain
		 * @var Phalcon\Searcher\Searcher
		 */
		$_searcher,

		/**
		 * Query builder
		 * @var Phalcon\Mvc\Model\Query\Builder
		 */
		$_builder;

	/**
	 * Initialize internal params
	 * @param Phalcon\Searcher\Searcher $searcher
	 * @return null
	 */
	public function __construct(Searcher $searcher) {
		$this->_searcher	=  $searcher;
		$this->_builder		=  new Build();
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
			foreach($this->_searcher->getCollection() as $model => $attributes)
			{
				// set model => alias (real table name)
				$this->_builder->addFrom($model, key($attributes));
				if(empty($attributes) === false)
				{
					var_dump('Params', $attributes);
				}
			}

			var_dump('Builder', $this->_builder); exit;

			//$queryBuilder = new Phalcon\Mvc\Model\Query\Builder($params);

		}
		catch(Exception $e) {
			echo $e->getMessage();
		}
	}
}