<?php

namespace Modules\CreateContent\Ad\Tables;


use Lib\Tables\Adapter\HierarchyTable;
use Lib\Tables\Buttons\Editor\ButtonCreate;
use Lib\Tables\Buttons\Editor\ButtonEdit;
use Lib\Tables\Buttons\Editor\ButtonRemove;
use Lib\Tables\Column;
use Lib\Translate\T;
use Modules\CreateContent\Ad\Editors\EditorAdImage;
use Modules\CreateContent\Ad\Editors\EditorAdImageEditButton;
use Modules\System\Native\Models\Language\ModelLanguage;

class TableAdImages extends HierarchyTable
{
    public function initEditors(): void
    {
        $this->addEditor(new EditorAdImage('ad_image_editor', true));
        $this->addEditor(new EditorAdImageEditButton('ad_image_edit_btn_editor', true));
    }

    public function init(): void
    {
        $this->ajax->setUrl(
            $this->url->get([
                'for' => 'api_get_ad_image__'. ModelLanguage::getCurrentLanguage()
            ])
        );
        $this->setDom('Bfrtip');

        $this->addOption('ordering', false);
        $this->addOption('language', [
            'emptyTable' => T::_('empty_ad_image_table')
        ]);
        $this->addOption('paging', false);
        $this->addOption('select', [
            'style' => 'single',
        ]);

        // style
        $this->addClassName('display');
        $this->addClassName('cell-border');

        $this->addOption('scrollX', true);
        $this->addOption('scrollCollapse', true);
    }

    /* * * * * * * * * * * * * * * * * * * * * * * * * * */
    /*     Buttons
    /* * * * * * * * * * * * * * * * * * * * * * * * * * */

    public function initButtons(): void
    {
        $this->addButton(new ButtonCreate(null, $this->getEditor('ad_image_editor')));
        $this->addButton(new ButtonEdit(null, $this->getEditor('ad_image_edit_btn_editor')));
        $this->addButton(new ButtonRemove(null, $this->getEditor('ad_image_editor')));
    }

    /* * * * * * * * * * * * * * * * * * * * * * * * * * */
    /*     Columns
    /* * * * * * * * * * * * * * * * * * * * * * * * * * */

    public function initColumns(): void
    {
        $this->columnImageId();
        $this->columnTitle();
        $this->columnCreator();
        $this->columnCreated();
        $this->columnModified();
    }

    public function columnTitle()
    {
        $column = new Column('title');
        $column->setTitle(T::_('title'));
        $column->setClassName('dt-center');
        $this->addColumn($column);
    }

    public function columnImageId()
    {
        $column = new Column('image_id');
        $column->setTitle(T::_('image'));
        $column->setClassName('dt-center');
        $column->setEditor($this->getEditor('ad_image_editor'));
        $column->setDefaultContent(T::_('no_image'));
        $column->setRender(<<<TAG
        return data ?
                '<img style="width: 200px;" src="'+{$column->getEditor()->getName()}.file( 'files', data ).web_path+'"/>' :
                null;
TAG
);
        $this->addColumn($column);
    }

    public function columnCreator()
    {
        $column = new Column('user_id');
        $column->setTitle(T::_('creator'));
        $column->setClassName('dt-center');
        $column->setWidth('100px');
        $column->setRender(<<<TAG
        if(type=='display'){return data.display;}
        if(type=='sort'){return data.display;}
        if(type=='filter'){return data.display;}
        return data._
TAG
        );
        $this->addColumn($column);
    }

    public function columnCreated()
    {
        $column = new Column('created');
        $column->setTitle(T::_('created'));
        $column->setClassName('dt-center');
        $column->setWidth('100px');
        $column->setRender(<<<TAG
        if(type=='display'){return data.display;}
        if(type=='sort'){return data._;}
        if(type=='filter'){return data.display;}
        return data._
TAG
        );
        $this->addColumn($column);
    }

    public function columnModified()
    {
        $column = new Column('modified');
        $column->setTitle(T::_('modified'));
        $column->setClassName('dt-center');
        $column->setWidth('100px');
        $column->setRender(<<<TAG
        if(type=='display'){return data.display;}
        if(type=='sort'){return data._;}
        if(type=='filter'){return data.display;}
        return data._
TAG
        );
        $this->addColumn($column);
    }

}