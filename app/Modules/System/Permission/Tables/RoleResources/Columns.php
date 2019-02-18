<?php
namespace Modules\System\Permission\Tables\RoleResources;


use Lib\DTE\Table\Columns\Column;
use Lib\Translate\T;

trait Columns
{
    protected function columnStatus()
    {
        $col = new Column('status');
        $col->setTitle(T::_('status'));
        $col->setClassName('dt-center');
        $col->setRender( /** @lang JavaScript */
            <<<TAG
        if ( type === 'display' ) {
            return '<input type="checkbox" class="editor-active">';
        }
        return data;
TAG
,  Column::RENDER_TYPE_FUNCTION);
        $this->addColumn($col);
    }

    protected function columnTitle()
    {
        $col = new Column('title');
        $col->setTitle(T::_('title'));
        $col->setClassName('dt-center');
        $this->addColumn($col);
    }

    protected function columnModule()
    {
        $col = new Column('module');
        $col->setTitle(T::_('module'));
        $col->setClassName('dt-center');
        $this->addColumn($col);
    }
}