<?php
namespace Lib\DTE\Table\Columns\Type;


use Lib\DTE\Table\Columns\Column;

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