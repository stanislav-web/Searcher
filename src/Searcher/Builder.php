<?php
namespace Phalcon\Searcher;

use Phalcon\Mvc\Model\Manager;
use	Phalcon\Mvc\Model\Query\Builder as Build;
use	Phalcon\Mvc\Model\Resultset\Simple as Resultset;

/**
 * Query builder class
 * @package Phalcon
 * @subpackage Phalcon\Searcher
 * @since PHP >=c
 * @version 1.0
 * @author Stanislav WEB | Lugansk <stanisov@gmail.com>
 * @copyright Stanislav WEB
 */
class Builder extends Manager {

	private

			/**
			 * Query builder
		 	 * @var Phalcon\Mvc\Model\Query\Builder
		 	 */
			$_builder,

			/**
	 		 * Client for preparing data
			 * @var Phalcon\Searcher\Searcher
			 */
			$_searcher;

	/**
	 * Initialize internal params
	 * @param Searcher $searcher
	 * @return null
	 */
	public function __construct(Searcher $searcher) {
		$this->_searcher		=	$searcher;
		$this->_builder			=	new Build();
	}

	/**
	 * Build looper
	 *
	 * @return Builder|null
	 */
	public function loop()
	{
		try {

			$collection = $this->_searcher->getFields();

			foreach($collection as $model => $attributes)
			{
				// set model => alias (real table name)
				$this->_builder->addFrom($model, key($attributes));
			}
			$this->_builder->orderBy(array('1', 'Robots.name'));
			print_r($this->_searcher->getFields());
		}
		catch(\Exception $e) {
			echo $e->getMessage();
		}
	}

}