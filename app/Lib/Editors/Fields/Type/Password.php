<?php
namespace Lib\Editors\Fields\Type;


class Password extends Text
{
    public function __construct( $name )
    {
        parent::__construct( $name );
        $this->setType('password');
    }
}