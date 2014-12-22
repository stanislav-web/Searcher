<?php
namespace Test\Searcher\Models;

class Auto extends \Phalcon\Mvc\Model
{
    public $id;

    public $name;

    public $description;

    public function initialize()
    {
        $this->setSource("auto");
    }
}