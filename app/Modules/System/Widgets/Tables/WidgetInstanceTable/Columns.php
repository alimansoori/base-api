<?php

namespace Modules\System\Widgets\Tables\WidgetInstanceTable;


use Lib\DTE\Table\Buttons\Editor\ButtonCreate;
use Lib\DTE\Table\Buttons\Editor\ButtonEdit;
use Lib\DTE\Table\Buttons\Editor\ButtonRemove;
use Lib\DTE\Table\Columns\Column;
use Lib\DTE\Table\Columns\Type\ColumnReOrder;
use Lib\DTE\Table\Columns\Type\ColumnSelectCheckbox;
use Lib\DTE\Table\Select;
use Lib\Translate\T;

/**
 * @property Select select
 */
trait Columns
{
    protected function columnSlug()
    {
        $slug = new Column( 'slug' );
        $slug->setTitle( 'Slug' );
        $slug->setClassName( 'dt-center editable' );
        $slug->setRenderEditPencil();
        $this->addColumn( $slug );
    }

    protected function ColumnReorder()
    {
        if( !$this->routeExistInCurrentLanguageById( $this->request->get( 'route_id' ) ) )
        {
            $row = new Column( 'reorder' );
            $row->setClassName('dt-center');
            $row->setOrderable(false);
        }
        else
        {
            $row = new ColumnReOrder( 'reorder' );
            $row->setEditor( $this->getEditor( 'editorPageManager' ) );
        }
        $row->setData( 'position' );
        $row->setTitle(T::_('row'));
        $row->setWidth('10px');
        $this->addColumn( $row );
    }

    protected function ColumnSelectCheckbox()
    {
        $check = new ColumnSelectCheckbox( 'check' );
        $check->setTitle( 'Check' );
        $check->setWidth( '30px' );
        $check->setOrderable( false );
        $this->select->setSelectionFirstColumnOnly();
        $this->addColumn( $check );
    }

    protected function columnTitleMenu()
    {
        $titleMenu = new Column( 'title_menu' );
        $titleMenu->setTitle( T::_('page_title_in_menu') );
        $titleMenu->setClassName( 'dt-center editable' );
        $titleMenu->setRenderEditPencil();
        $this->addColumn( $titleMenu );
    }

    protected function columnParentId()
    {
        $col = new Column( 'parent_id' );
        $col->setTitle( T::_('parent') );
        $col->setClassName( 'dt-center' );
        $col->setRender( /** @lang JavaScript */
            <<<TAG
            if (type == 'display')
                return data.display;
            return data._;
TAG
            , Column::RENDER_TYPE_FUNCTION);
        $this->addColumn( $col );
    }

    protected function columnTitle()
    {
        $title = new Column( 'title' );
        $title->setTitle( T::_( 'title' ) );
        $title->setClassName( 'dt-center editable' );
        $title->setRender( /** @lang JavaScript */
            <<<TAG
            if (type == 'display')
                return data.display;
            if (type == 'sort')
                return data.display;
            if (type == 'filter')
                return data.display;
            return data._;
TAG
            , Column::RENDER_TYPE_FUNCTION);
        $this->addColumn( $title );
    }

    protected function columnWidgetId()
    {
        $col = new Column( 'widget_id' );
        $col->setTitle( T::_( 'widget_instance_of' ) );
        $col->setClassName( 'dt-center' );
        $col->setRender( /** @lang JavaScript */
            <<<TAG
            if (type == 'display')
                return data.display;
            if (type == 'sort')
                return data.display;
            if (type == 'filter')
                return data.display;
            return data._;
TAG
            , Column::RENDER_TYPE_FUNCTION);
        $this->addColumn( $col );
    }

    protected function columnModule()
    {
        $col = new Column( 'module_id' );
        $col->setTitle( T::_( 'module' ) );
        $col->setClassName( 'dt-center' );
        $col->setRender( /** @lang JavaScript */
            <<<TAG
            if (type == 'display')
                return data.display;
            if (type == 'sort')
                return data.display;
            if (type == 'filter')
                return data.display;
            return data._;
TAG
            , Column::RENDER_TYPE_FUNCTION);
        $this->addColumn( $col );
    }

    protected function columnPreview()
    {
        $preview = new Column('preview');
        $preview->setTitle(T::_('preview'));
        $preview->setClassName('dt-center');
        $preview->setWidth('5%');
        $preview->setRender( /** @lang JavaScript */
            "
return '<a href=\"'+row.preview_url+'\" target=\"_blank\"><i class=\"far fa-eye\"></i></a>';
");
        $this->addColumn($preview);
    }
}