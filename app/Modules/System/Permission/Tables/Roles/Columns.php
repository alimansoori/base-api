<?php
namespace Modules\System\Permission\Tables\Roles;


use Lib\DTE\Table\Columns\Column;
use Lib\Translate\T;

trait Columns
{
    protected function columnTitle()
    {
        $col = new Column('title');
        $col->setTitle(T::_('title'));
        $col->setRenderEditPencil();
        $col->setClassName('dt-center');
        $this->addColumn($col);
    }

    protected function columnRelatedModule()
    {
        $col = new Column('related_module');
        $col->setTitle(T::_('related_module'));
        $col->setClassName('dt-center');
        $col->setRender( /** @lang JavaScript */
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
        $this->addColumn($col);
    }

    protected function columnStatus()
    {
        $column = new Column('status');
        $column->setRender( /** @lang JavaScript */
            "
if ( type === 'display' && row.status == 'inactive' ) {
    return '<i title=\"غیرفعال\" class=\"fas fa-exclamation-circle\"></i>';
}else if(type === 'display' && row.status == 'active') {
    return '<i title=\"فعال\" class=\"far fa-check-circle\"></i>';
}
    return data;
");
        $column->setTitle(T::_('status'));
        $column->setClassName('dt-center');
//        $column->setEditFields('status');
        $this->addColumn($column);
    }
}