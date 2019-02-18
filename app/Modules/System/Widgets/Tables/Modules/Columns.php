<?php
namespace Modules\System\Widgets\Tables\Modules;


use Lib\DTE\Table\Columns\Column;
use Lib\DTE\Table\Columns\Type\ColumnReOrder;
use Lib\Translate\T;

trait Columns
{
    protected function columnReorder()
    {
        $row = new ColumnReOrder( 'reorder' );
        $row->setEditor( $this->getEditor( 'modules_editor' ) );
        $row->setData( 'position' );
        $row->setTitle(T::_('row'));
        $row->setWidth('10px');
        $row->setClassName('dt-center');
        $this->addColumn( $row );
    }

    protected function columnName()
    {
        $name = new Column('name');
        $name->setTitle(T::_('name'));
        $name->setClassName('dt-center');
        $name->setRenderEditPencil();
        $this->addColumn($name);
    }

    protected function columnTitle()
    {
        $title = new Column('title');
        $title->setTitle(T::_('title'));
        $title->setClassName('dt-center');
        $title->setRender( /** @lang JavaScript */
            <<<TAG
            if (type == 'display')
                return data.display + '&nbsp;&nbsp;&nbsp;<i class="fas fa-pencil-alt"></i>';
            if (type == 'filter')
                return data.filter;
            if (type == 'sort')
                return data.sort;
            return data._;
TAG
, Column::RENDER_TYPE_FUNCTION);
        $this->addColumn($title);
    }

    protected function columnDescription()
    {
        $description = new Column('description');
        $description->setTitle(T::_('description'));
        $description->setClassName('dt-center');
        $description->setRender( /** @lang JavaScript */
            <<<TAG
            if (type == 'display')
                return data.display + '&nbsp;&nbsp;&nbsp;<i class="fas fa-pencil-alt"></i>';
            if (type == 'filter')
                return data.filter;
            if (type == 'sort')
                return data.sort;
            return data._;
TAG
            , Column::RENDER_TYPE_FUNCTION);
        $this->addColumn($description);
    }
}