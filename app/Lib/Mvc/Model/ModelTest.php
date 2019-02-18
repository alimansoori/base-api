<?php
namespace Lib\Mvc\Model;


use Lib\Mvc\Model;

class ModelTest extends Model
{
    public $id;
    public $place_id;
    public $name;

    protected function init()
    {
        $this->setSource('test');
        $this->setDbRef(true);
    }

}