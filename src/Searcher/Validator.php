<?php
namespace Phalcon\Searcher;

use Phalcon\Db\Column,
	Phalcon\Mvc\Model\Manager,
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
		 * Verified tables
		 * @var array
		 */
		$_etables	=	[],

		/**
		 * Available columns types
		 * @var array
		 */
		$_column	=	[
			'varchar',
			'char',
			'text',
			'date',
			'datetime',
		];

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
	 * Check if field exist in table
	 *
	 * @param string $value
	 * @throws Exceptions\InvalidLengthException
	 * @return boolean
	 */
	public function isExists($value) {

		// validate fields by exist in tables

		foreach($value as $table => $fields) {

			// load model metaData
			$model 		=  	(new Manager())->load($table, new $table);

			$metaData 	= 	$model->getModelsMetaData();

			// check fields of table

			if(!empty($not = array_diff($fields, $metaData->getAttributes($model))) === true)
				throw new Exceptions\ColumnDoesNotExistException($table, $not, $metaData->getAttributes($model));

			// setup clear used tables
			$this->_etables[$model->getSource()]	=	$table;
			$columnDefines = (new $table)->getReadConnection()->describeColumns($model->getSource());

			// checking columns & fields

			foreach($columnDefines as $n => $column) {

				if(in_array($column->getName(), $fields) === true) {
					$this->validTypes($column);
				}
			}
		}
		return true;
	}

	/**
	 * Check if field exist in table
	 *
	 * @param string $value
	 * @throws Exceptions\InvalidLengthException
	 * @return boolean
	 */
	public function validTypes(Column $column) {

		foreach($this->_column as $type) {

			if($this->{'is'.ucfirst($type)}($column->getType()) === false)
				throw new Exceptions\ColumnTypeException($column->getName(), $column->getType());
		}
		return true;
	}

	/**
	 * Is it varchar field ?
	 *
	 * @param int $type for column
	 * @return bool
	 */
	public function isVarchar($type) {
		if((int)$type === Column::TYPE_VARCHAR)
			return true;
	}

	/**
	 * Is it char field ?
	 *
	 * @param int $type for column
	 * @return bool
	 */
	public function isChar($type) {
		if((int)$type === Column::TYPE_CHAR)
			return true;
	}

	/**
	 * Is it text field ?
	 * @param int $type for column
	 *
	 * @return bool
	 */
	public function isText($type) {
		if((int)$type === Column::TYPE_TEXT)
			return true;
	}

	/**
	 * Is it date field ?
	 *
	 * @param int $type for column
	 * @return bool
	 */
	public function isDate($type) {
		if((int)$type === Column::TYPE_DATE)
			return true;
	}

	/**
	 * Is it datetime field ?

	 * @param int $type for column
	 * @return bool
	 */
	public function isDatetime($type) {
		if((int)$type === Column::TYPE_DATETIME)
			return true;
	}

	/**
	 * Return verified tables to main class
	 *
	 * @return array
	 */
	public function getTables() {
		return $this->_etables;
	}
}