<?php
namespace Phalcon\Searcher;

use Phalcon\Db\Column,
	Phalcon\Searcher\Exceptions;

/**
 * Columns validator for this module
 * @package Phalcon
 * @subpackage Phalcon\Searcher
 * @since PHP >=c
 * @version 1.0
 * @author Stanislav WEB | Lugansk <stanisov@gmail.com>
 * @copyright Stanilav WEB
 */
class Validator {

	private

		/**
		 * Available columns types
		 * @var array
		 */
		$_defined	=	[
			'varchar',
			'char',
			'text',
			'date',
			'datetime',
		],

		/**
		 * Column explorer
		 * @var Column
		 */
	 	$_explorer,

		/**
		 * Define current column type
		 * @var int
		 */
	 	$_type		=	0,

		/**
		 * Define current column name
		 * @var string
		 */
	 	$_name		=	'';

	/**
	 * Initialize field
	 *
	 * @param Column $explorer
	 * @return null
	 */
	public function __construct(Column $explorer) {
		$this->_explorer =	$explorer;
		$this->_type	=	$this->_explorer->getType();
	}

	/**
	 * Get field name
	 *
	 * @return mixed
	 */
	public function getName() {
		return $this->_explorer->getName();
	}

	/**
	 * Get field type
	 *
	 * @return int
	 */
	public function getType() {
		return $this->_type;
	}

	/**
	 * Check field's type by defined criteria
	 *
	 * @return bool
	 */
	public function isValid() {
		foreach($this->_defined as $i => $type)
		{
			if($this->{'is'.ucfirst($type)}() === true)
				return true;
		}
		return false;
	}

	/**
	 * Is it varchar field ?
	 *
	 * @return bool
	 */
	public function isVarchar()
	{
		if($this->_type === Column::TYPE_VARCHAR)
			return true;
	}

	/**
	 * Is it char field ?
	 *
	 * @return bool
	 */
	public function isChar()
	{
		if($this->_type === Column::TYPE_CHAR)
			return true;
	}

	/**
	 * Is it text field ?
	 *
	 * @return bool
	 */
	public function isText()
	{
		if($this->_type === Column::TYPE_TEXT)
			return true;
	}

	/**
	 * Is it date field ?
	 *
	 * @return bool
	 */
	public function isDate()
	{
		if($this->_type === Column::TYPE_DATE)
			return true;
	}

	/**
	 * Is it datetime field ?
	 *
	 * @return bool
	 */
	public function isDatetime()
	{
		if($$this->_type === Column::TYPE_DATETIME)
			return true;
	}
}