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
		 * The minimum value for the search
		 * @var int
		 */
		$_min		=	3,

		/**
		 * The maximum value for the search
		 * @var int
		 */
		$_max		=	128,

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
	 * Verify transferred according to the rules
	 *
	 * @param mixed $data
	 * @param array $callbacks
	 * @return mixed
	 */
	public function verify($data, array $callbacks) {

		// Create a Closure
		$isValid = function($data) use ($callbacks) {
			foreach($callbacks as $callback)
			{
				if($this->{$callback}($data) === false)
					return false;
			}
		};

		// return boolean as such
		return $isValid($data);
	}


	/**
	 * Set minimum value for the search
	 *
	 * @param int $min value
	 * @return Searcher
	 */
	public function setMin($min) {
		if(is_int($min) === false)
			$this->_min	=	(int)$min;
		else
			$this->_min	=	$min;
		return $this;
	}

	/**
	 * Set maximum value for the search
	 *
	 * @param int $max value
	 * @return Searcher
	 */
	public function setMax($max) {
		if(is_int($max) === false)
			$this->_max	=	(int)$max;
		else
			$this->_max	=	$max;
		return $this;
	}

	/**
	 * Verify by not null
	 *
	 * @param string $value
	 * @throws Exceptions\NullArgumentException
	 * @return boolean
	 */
	public function isNotNull($value) {
		if(is_null($value) === true)
			throw new Exceptions\NullArgumentException($value);
		return true;
	}

	/**
	 * Verify by array type
	 *
	 * @param mixed $value
	 * @throws Exceptions\InvalidTypeException
	 * @return boolean
	 */
	public function isArray($value) {
		if(is_array($value) === false)
			throw new Exceptions\InvalidTypeException($value, 'array');
		return true;
	}

	/**
	 * Verify by not empty value
	 *
	 * @param mixed $value
	 * @throws \Exception
	 * @return boolean
	 */
	public function isNotEmpty($value) {
		if(empty($value) === false)
			return true;
		else
			throw new \Exception('Search list does not configured');
	}

	/**
	 * Verify by min length
	 *
	 * @param string $value
	 * @throws Exceptions\InvalidLengthException
	 * @return boolean
	 */
	public function isNotFew($value) {
		if(strlen(utf8_decode($value)) < $this->_min)
			throw new Exceptions\InvalidLengthException($value, 'greater', $this->_min);
		return true;
	}

	/**
	 * Verify by max length
	 *
	 * @param string $value
	 * @throws Exceptions\InvalidLengthException
	 * @return boolean
	 */
	public function isNotMuch($value) {
		if(strlen(utf8_decode($value)) > $this->_max)
			throw new Exceptions\InvalidLengthException($value, 'less', $this->_max);
		return true;
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

		//$this->_explorer =	$explorer;
		//$this->_type	=	$this->_explorer->getType();

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