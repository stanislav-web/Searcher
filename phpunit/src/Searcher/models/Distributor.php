<?php
namespace Test\Searcher\Models;

class Distributor extends \Phalcon\Mvc\Model
{
    public $id;

    public $name;

    public $description;

    public function initialize()
    {
        $this->setSource("distributor");
    }
}