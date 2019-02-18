<?php
namespace Modules\System\Permission\Tables\Resources;


use Lib\DTE\Table\Columns\Column;
use Lib\Translate\T;

trait Columns
{
    protected function columnTitle()
    {
        $col = new Column('title');
        $col->setTitle(T::_('title'));
        $col->setClassName('dt-center');
        $this->addColumn($col);
    }

    protected function columnModule()
    {
        $col = new Column('module_id');
        $col->setTitle(T::_('module'));
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

    protected function columnController()
    {
        $col = new Column('controller');
        $col->setTitle(T::_('controller'));
        $col->setClassName('dt-center');
        $col->setRenderEditPencil();
        $this->addColumn($col);
    }

    protected function columnAction()
    {
        $col = new Column('action');
        $col->setTitle(T::_('action'));
        $col->setClassName('dt-center');
        $col->setRenderEditPencil();
        $this->addColumn($col);
    }
}