<?php
namespace Lib\Editors\Fields\Type;


use Lib\Editors\Fields\Field;

class Hidden extends Field
{
    public function __construct( $name )
    {
        parent::__construct( $name );
        $this->setType('hidden');
    }

}