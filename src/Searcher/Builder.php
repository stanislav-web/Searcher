<?php
namespace Phalcon\Searcher;

use Phalcon\Mvc\Model\Resultset\Simple as Resultset;

/**
 * Query builder class
 * @package Phalcon
 * @subpackage Phalcon\Searcher
 * @since PHP >=c
 * @version 1.0
 * @author Stanislav WEB | Lugansk <stanisov@gmail.com>
 * @copyright Stanilav WEB
 */
class Builder {

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
			 $_structure		=	[];

	/**
	 * Initialize internal params
	 * @param array $structure
	 * @param null $query
	 */
	public function __construct(array $structure, $query) {


		$this->_structure	=	$structure;
		$this->_query		=	$query;

		print_r($this->_structure); exit;
		return true;
	}
}