<?php
namespace Lib\DTE;


use Lib\DTE\Asset\Assets;
use Lib\DTE\Table\TEditor;
use Lib\Mvc\User\Component;

abstract class BaseTable extends Component
{
    use TEditor;

    protected $name;

    /** @var Assets $assetsManager */
    public $assetsManager;

    public function __construct($name)
    {
        $this->setName($name);
    }

    public function setName( $name )
    {
        $this->name = $name;
    }

    public function getName()
    {
        return $this->name;
    }
}