<?php

namespace Modules\System\PageManager\DTE\Table\PageManager;


use Lib\DTE\Table\Buttons\Editor\ButtonCreate;
use Lib\DTE\Table\Buttons\Editor\ButtonEdit;
use Lib\DTE\Table\Buttons\Editor\ButtonRemove;
use Lib\DTE\Table\Columns\Column;
use Lib\DTE\Table\Columns\Type\ColumnReOrder;
use Lib\DTE\Table\Columns\Type\ColumnSelectCheckbox;
use Lib\DTE\Table\Select;
use Lib\Translate\T;
use Modules\System\PageManager\Models\Routes\ModelRoutes;

/**
 * @property Select select
 */
trait TTablePageManager
{
    protected function columnSlug()
    {
        $slug = new Column( 'slug' );
        $slug->setTitle( 'Slug' );
        $slug->setClassName( 'dt-center editable' );
        $slug->setRenderEditPencil();
        $this->addColumn( $slug );
    }
    protected function columnRoute()
    {
        $col = new Column( 'route' );
        $col->setTitle( T::_('route') );
        $col->setClassName( 'dt-center editable' );
        $this->addColumn( $col );
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
        $col->setClassName( 'dt-center editable' );
        $col->setRender( /** @lang JavaScript */
            <<<TAG
            if (type == 'display')
                return data.display + '&nbsp;&nbsp;&nbsp;<i class="fas fa-pencil-alt"></i>';
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
        $title->setRenderEditPencil();
        $this->addColumn( $title );
    }

    protected function columnCreator()
    {
        $col = new Column( 'creator_id' );
        $col->setTitle( T::_( 'creator' ) );
        $col->setClassName( 'dt-center' );
        $col->setRender( /** @lang JavaScript */
            <<<TAG
            if (type == 'display')
                return data.display;
            if (type == 'sort')
                return data.sort;
            if (type == 'filter')
                return data.filter;
            return data._;
TAG
            , Column::RENDER_TYPE_FUNCTION);
        $this->addColumn( $col );
    }

    protected function columnCreated()
    {
        $col = new Column( 'created' );
        $col->setTitle( T::_( 'created' ) );
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

    protected function columnPreview()
    {
        $preview = new Column('preview');
        $preview->setTitle(T::_('preview'));
        $preview->setClassName('dt-center');
        $preview->setWidth('5%');
        $preview->setRender( /** @lang JavaScript */
            "
return '<a href=\"'+row.url+'\" target=\"_blank\"><i class=\"far fa-eye\"></i></a>';
");
        $this->addColumn($preview);
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

    protected function buttonCreate()
    {
        $create = new ButtonCreate('create');
        $create->setText(T::_('create'));
        $create->setEditor( $this->getEditor( 'page_manager_editor' ) );
        $this->addButton( $create );
    }

    protected function buttonEdit()
    {
        $edit = new ButtonEdit('btn_edit');
        $edit->setText(T::_('edit'));
        $edit->setEditor( $this->getEditor( 'page_manager_editor' ) );
        $this->addButton( $edit );
    }

    protected function buttonRemove()
    {
        $remove = new ButtonRemove('btn_remove');
        $remove->setText(T::_('remove'));
        $remove->setEditor( $this->getEditor( 'page_manager_editor' ) );
        $this->addButton( $remove );
    }

    protected function btnDesignPage()
    {
        $btn = new ButtonEdit('btn_design_page');
        $btn->setText(T::_('design_page'));
        $btn->setEditor( $this->getEditor( 'page_design_for_widgets_editor' ) );
        $this->addButton( $btn );
    }
}