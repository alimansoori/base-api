<?php
namespace Lib\Tables\Column\Type;


use Lib\Tables\Column;
use Lib\Translate\T;

class ColumnId extends Column
{
    public function __construct()
    {
        parent::__construct( 'id' );
        $this->setTitle(T::_('row_id'));
        $this->setWidth('10px');
        $this->setClassName('dt-center');
    }

}