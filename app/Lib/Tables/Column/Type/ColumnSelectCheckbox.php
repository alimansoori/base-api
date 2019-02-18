<?php
namespace Lib\Tables\Column\Type;


use Lib\Tables\Column;

class ColumnSelectCheckbox extends Column
{
    public function __construct( $name )
    {
        parent::__construct( $name );
        $this->setData(null);
        $this->setDefaultContent('');
        $this->setClassName('select-checkbox');
        $this->setOrderable(false);
    }

}