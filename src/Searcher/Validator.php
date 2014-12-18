<?php
namespace Searcher;

use \Phalcon\Db\Column;
use \Phalcon\Mvc\Model\Manager;
use Searcher\Searcher\Factories\ExceptionFactory;

/**
 * Columns validator
 *
 * @package   Searcher
 * @since     PHP >=5.5.12
 * @version   1.0
 * @author    Stanislav WEB | Lugansk <stanisov@gmail.com>
 * @copyright Stanislav WEB
 */
class Validator
{

    /**
     * The minimum value for the search
     *
     * @var int
     */
    private $min = 3;

    /**
     * The maximum value for the search
     *
     * @var int
     */
    private $max = 128;

    /**
     * Available columns types
     *
     * @var array
     */
    public $columns = [
        Column::TYPE_INTEGER,
        Column::TYPE_VARCHAR,
        Column::TYPE_CHAR,
        Column::TYPE_TEXT,
        Column::TYPE_DATE,
        Column::TYPE_DATETIME,
    ];

    /**
     * Available sort types
     *
     * @var array
     */
    public $sort = [
        'asc',
        'desc',
        'ascending',
        'descending',
    ];

    /**
     * Cast of validate
     *
     * @var string
     */
    private $cast = '';

    /**
     * Verified tables & columns
     *
     * @var array
     */
    public $fields = [];

    /**
     * Verify transferred according to the rules
     *
     * @param  mixed  $data
     * @param  array  $callbacks
     * @param  string $cast
     * @return mixed
     */
    public function verify($data, array $callbacks = [], $cast = '')
    {

        if (empty($callbacks) === true) {
            return $this->fields[$cast] = $data;
        }

        // Create a Closure
        $isValid = function ($data) use ($callbacks, $cast) {

            if (empty($cast) === false) {
                $this->cast = $cast;
            }

            foreach ($callbacks as $callback) {
                if ($this->{$callback}($data) === false) {
                    return false;
                }
            }
        };

        // return boolean as such
        return $isValid($data);
    }

    /**
     * Set value length for the search min and max
     *
     * @param  array       $condition value
     * @return Validator
     */
    public function setLength(array $condition)
    {
        if (is_array($condition) === true)  {
            $this->{key($condition)} = (int) current($condition);
        }

        return $this;
    }

    /**
     * Verify by not null
     *
     * @param  string  $value
     * @return boolean
     */
    protected function isNotNull($value)
    {
        if (is_null($value) === true || empty($value) === true) {
            throw new ExceptionFactory('DataType', [$value, 'string']);
        }

        return true;
    }

    /**
     * Verify by array type
     *
     * @param  mixed            $value
     * @throws ExceptionFactory
     * @return boolean
     */
    protected function isArray($value)
    {
        if (is_array($value) === false) {
            throw new ExceptionFactory('DataType', [$value, 'array']);
        }

        return true;
    }

    /**
     * Verify by not empty value
     *
     * @param  mixed            $value
     * @throws ExceptionFactory
     * @return boolean
     */
    protected function isNotEmpty($value)
    {
        if (empty($value) === false) {
            return true;
        }
        else {
            throw new ExceptionFactory('Column', ['EMPTY_LIST', 'Search list will not contain empty value']);
        }

    }

    /**
     * Verify by length
     *
     * @param  string           $value
     * @throws ExceptionFactory
     * @return boolean
     */
    protected function isAcceptLength($value)
    {
        $value = strlen(utf8_decode($value));

        if ($value < $this->min) {
            throw new ExceptionFactory('InvalidLength', [$value, 'greater', $this->min]);
        }
        else if ($value > $this->max) {
            throw new ExceptionFactory('InvalidLength', [$value, 'less', $this->max]);
        }

        return true;
    }

    /**
     * Check if is model
     *
     * @param  string           $value
     * @throws ExceptionFactory
     * @return boolean
     */
    protected function isModel($value)
    {

        if (class_exists($value) === false) {
            throw new ExceptionFactory('Model', ['MODEL_DOES_NOT_EXISTS', $value]);
        }

        return true;
    }

    /**
     * Check if field exist in table
     *
     * @param  array            $value
     * @throws ExceptionFactory
     * @return boolean
     */
    protected function isExists(array $value)
    {

        // validate fields by exist in tables

        foreach ($value as $table => $fields) {

            // load model metaData

            if ($this->isModel($table) === true) {
                $model = (new Manager())->load($table, new $table);

                // check fields of table

                $this->validColumns($model->getModelsMetaData(), $fields, $table, $model);

                // setup clear used tables
                $columnDefines = (new $table)->getReadConnection()->describeColumns($model->getSource());

                // add using tables with model alias
                $this->fields['tables'][$model->getSource()] = $table;

                // checking columns & fields

                foreach ($columnDefines as $column) {

                    if (in_array($column->getName(), $fields) === true) {
                        $this->validTypes($column);

                        // add column to table collection
                        $this->fields[$this->cast][$model->getSource()][$column->getName()] = $column->getType();
                    }
                }
            }
        }

        return true;
    }

    /**
     * Check ordered fields
     *
     * @param  array            $ordered
     * @throws ExceptionFactory
     * @return boolean
     */
    protected function isOrdered(array $ordered)
    {

        // validate fields by exist in tables

        foreach ($ordered as $table => $sort) {

            // load model metaData

            if ($this->isModel($table) === true) {
                $model = (new Manager())->load($table, new $table);

                // check fields of table

                $this->validColumns($model->getModelsMetaData(), array_keys($sort), $table, $model);

                // check sort clause

                $sort = array_map('strtolower', $sort);

                if (empty($diff = array_diff(array_values($sort), $this->sort)) === false) {
                    throw new ExceptionFactory('Column', ['ORDER_TYPES_DOES_NOT_EXISTS', $diff]);
                }

                if (empty($diff = array_diff($sort, $this->sort)) === false) {
                    throw new ExceptionFactory('Column', ['ORDER_TYPES_DOES_NOT_EXISTS', $diff]);
                }

                $this->fields[$this->cast][$model->getSource()] = $sort;
            }
        }

        return true;
    }

    /**
     * Check if field type support in table
     *
     * @throws ExceptionFactory
     * @return boolean
     */
    protected function validTypes(Column $column)
    {

        if (in_array($column->getType(), $this->columns) === false) {
            throw new ExceptionFactory('Column', ['COLUMN_DOES_NOT_SUPPORT', $column->getType(), $column->getName()]);
        }

        return true;
    }

    /**
     * Validate table columns
     *
     * @param  Memory           $meta    column info
     * @param  array            $columns
     * @param  string           $table
     * @param  mixed            $model   selected model
     * @throws ExceptionFactory
     * @return boolean
     */
    protected function validColumns(Memory $meta, array $columns, $table, $model)
    {
        if (empty($not = array_diff($columns, $meta->getAttributes($model))) === false) {
            throw new ExceptionFactory('Column', ['COLUMN_DOES_NOT_EXISTS', $not, $table, $meta->getAttributes($model)]);
        }

        return true;

    }
}
