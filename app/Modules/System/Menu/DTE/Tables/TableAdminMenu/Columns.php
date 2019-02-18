<?php
namespace Modules\System\Menu\DTE\Tables\TableAdminMenu;


use Lib\DTE\Table\Columns\Column;
use Lib\DTE\Table\Columns\Type\ColumnReOrder;
use Lib\Translate\T;
use Modules\System\Native\Models\Language\ModelLanguage;

trait Columns
{
    protected function columnReorder()
    {
        $col = new Column('position');
        $col->setTitle(T::_('row'));
        $col->setClassName('dt-center');
        $col->setWidth('10px');
        $col->setOrderable(false);

        if (ModelLanguage::getCurrentLanguage() == 'fa' || ModelLanguage::getCurrentLanguage() == 'ar')
        {
            $col->setRender(<<<TAG
        if(row.parent_id && type == 'display') {
            return '<span style="display: inline-flex">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'+data+'</span>';
        }
        return data;
TAG
            );
        }
        else
        {
            $col->setRender(<<<TAG
        if(row.parent_id && type == 'display') {
            return '<span style="display: inline-flex">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'+data+'</span>';
        }
        return data;
TAG
            );
        }

        $this->addColumn($col);
    }

    protected function columnTitle()
    {
        $col = new Column('title');
        $col->setTitle(T::_('title'));
        $col->setClassName('dt-center');

        $col->setRender(<<<TAG
        if(type = 'display'){
            return data.display;
        }
        if(type = 'sort'){
            return data.display;
        }
        if(type = 'filter'){
            return data.display;
        }
        return data._;
TAG
        );

        $this->addColumn($col);
    }

    protected function columnCategory()
    {
        $col = new Column('category_id');
        $col->setTitle(T::_('manage'));
        $col->setClassName('dt-center');

        $col->setRender(<<<TAG
        if(type = 'display'){
            return data.display;
        }
        if(type = 'sort'){
            return data.display;
        }
        if(type = 'filter'){
            return data.display;
        }
        return data._;
TAG
        );

        $this->addColumn($col);
    }

    protected function columnParent()
    {
        $col = new Column('parent');
        $col->setTitle(T::_('parent'));
        $col->setClassName('dt-center');

        $col->setRender(<<<TAG
        if(type = 'display'){
            return data.display;
        }
        if(type = 'sort'){
            return data.display;
        }
        if(type = 'filter'){
            return data.display;
        }
        return data._;
TAG
            , Column::RENDER_TYPE_FUNCTION);

        $this->addColumn($col);
    }

    protected function columnLink()
    {
        $col = new Column('link');
        $col->setTitle(T::_('link'));
        $col->setClassName('dt-center');
        $col->setOrderable(false);
        $col->setWidth('10px');
        $col->setRender(<<<TAG
        if ( type === 'display') {
            return '<a title="Preview" href="'+data.display+'" target="_blank"><i class="far fa-eye"></i></a>';
        }
        return data._;
TAG
);

        $this->addColumn($col);
    }

    protected function columnIcon()
    {
        $col = new Column('icon');
        $col->setTitle(T::_('icon'));
        $col->setClassName('dt-center');
        $col->setOrderable(false);
        $col->setWidth('10px');

        $col->setRender(<<<TAG
        if ( type === 'display') {
            return '<i class="'+data+'"></i>';
        }
        return data;
TAG
);

        $this->addColumn($col);
    }
}