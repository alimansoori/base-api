<?php
namespace Lib\DTE\Editor\Fields\Type;


class Textarea extends Text
{
    public function __construct( $name )
    {
        parent::__construct( $name );
        $this->setType('textarea');
    }
}