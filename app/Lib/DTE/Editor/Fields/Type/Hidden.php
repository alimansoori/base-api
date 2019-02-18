<?php
namespace Lib\DTE\Editor\Fields\Type;


use Lib\DTE\Editor\Fields\Field;

class Hidden extends Field
{
    public function __construct( $name )
    {
        parent::__construct( $name );
        $this->setType('hidden');
    }

}