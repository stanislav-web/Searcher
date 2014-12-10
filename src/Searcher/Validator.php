<?php
namespace Phalcon\Searcher;

use Phalcon\Db\Column;
use	Phalcon\Mvc\Model\Manager;
use	Phalcon\Searcher\Exceptions;

/**
 * Columns validator
 * @package Phalcon
 * @subpackage Phalcon\Searcher
 * @since PHP >=c
 * @version 1.0
 * @author Stanislav WEB | Lugansk <stanisov@gmail.com>
 * @copyright Stanislav WEB
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
		$_columns	=	[
			Column::TYPE_INTEGER,
			Column::TYPE_VARCHAR,
			Column::TYPE_CHAR,
			Column::TYPE_TEXT,
			Column::TYPE_DATE,
			Column::TYPE_DATETIME,
		],

		/**
		 * Cast of validate
		 * @var string
		 */
		$_cast	=	'';

	public
		/**
		 * Verified tables & columns
		 * @var array
		 */
		$fields	=	[];

	/**
	 * Verify transferred according to the rules
	 *
	 * @param mixed $data
	 * @param array $callbacks
	 * @param string $cast
	 * @return mixed
	 */
	public function verify($data, array $callbacks, $cast = '') {

		// Create a Closure
		$isValid = function($data) use ($callbacks, $cast) {

			if(empty($cast) === false)
				$this->_cast	=	$cast;

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
	 * @return Validator
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
	 * @return Validator
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
			throw new Exceptions\NullArgumentException();
		return true;
	}

	/**
	 * Verify by array type
	 *
	 * @param mixed $value
	 * @throws Exceptions\DataTypeException
	 * @return boolean
	 */
	public function isArray($value) {
		if(is_array($value) === false)
			throw new Exceptions\DataTypeException($value, 'array');
		return true;
	}

	/**
	 * Verify by not empty value
	 *
	 * @param mixed $value
	 * @throws Exceptions\ColumnException
	 * @return boolean
	 */
	public function isNotEmpty($value) {
		if(empty($value) === false)
			return true;
		else
			throw new Exceptions\ColumnException(Exceptions\ColumnException::EMPTY_LIST, ['Search list has empty value']);
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
	 * @param array $value
	 * @throws Exceptions\ColumnException
	 * @return boolean
	 */
	public function isExists(array $value) {

		// validate fields by exist in tables

		foreach($value as $table => $fields) {

			// load model metaData
			$model 		=  	(new Manager())->load($table, new $table);

			$metaData 	= 	$model->getModelsMetaData();

			// check fields of table

			if(empty($not = array_diff($fields, $metaData->getAttributes($model))) === false)
				throw new Exceptions\ColumnException(Exceptions\ColumnException::COLUMN_DOES_NOT_EXISTS, [
					$not, $table, $metaData->getAttributes($model)]);

			// setup clear used tables
			$columnDefines = (new $table)->getReadConnection()->describeColumns($model->getSource());

			// add using tables with model alias
			$this->fields['tables'][$model->getSource()]		=	$table;

			// checking columns & fields

			foreach($columnDefines as $column) {

				if(in_array($column->getName(), $fields) === true) {
					$this->validTypes($column);

					// add column to table collection
					$this->fields[$this->_cast][$model->getSource()][]	=	[
						$column->getType() => $column->getName()
					];
				}
			}
		}
		return true;
	}


	/**
	 * Check ordered fields
	 *
	 * @param array $ordered
	 * @throws Exceptions\ColumnException
	 * @return boolean
	 */
	public function isOrdered(array $ordered) {

		// validate fields by exist in tables

		foreach($ordered as $table => $orders) {

			// load model metaData
			$model 		=  	(new Manager())->load($table, new $table);

			$metaData 	= 	$model->getModelsMetaData();

			// check fields of table

			if(empty($not = array_diff(array_keys($orders), $metaData->getAttributes($model))) === false)
				throw new Exceptions\ColumnException(Exceptions\ColumnException::COLUMN_DOES_NOT_EXISTS, [
					$not, $table, $metaData->getAttributes($model)]);

			$this->fields[$this->_cast][$model->getSource()]	=	$orders;
		}
		return true;
	}

	/**
	 * Check if field type support in table
	 *
	 * @param string $value
	 * @throws Exceptions\ColumnException
	 * @return boolean|null
	 */
	public function validTypes(Column $column) {

		if(in_array($column->getType(), $this->_columns) === false) {

			throw new Exceptions\ColumnException(Exceptions\ColumnException::COLUMN_DOES_NOT_SUPPORT, [
				$column->getName(), $column->getType()]);
		}
		return true;
	}
}