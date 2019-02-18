<?php

namespace Modules\CreateContent\Ad\Tables;


use Lib\Tables\Adapter\HierarchyTable;
use Lib\Tables\Buttons\Editor\ButtonCreate;
use Lib\Tables\Buttons\Editor\ButtonEdit;
use Lib\Tables\Buttons\Editor\ButtonRemove;
use Lib\Tables\Column;
use Lib\Translate\T;
use Modules\CreateContent\Ad\Editors\EditorAd;
use Modules\System\Native\Models\Language\ModelLanguage;

class TableAd extends HierarchyTable
{
    public function initEditors(): void
    {
        $this->addEditor(new EditorAd('ad_editor', true));
    }

    public function init(): void
    {
        $this->ajax->setUrl(
            $this->url->get([
                'for' => 'api_get_ad__'. ModelLanguage::getCurrentLanguage()
            ])
        );
        $this->setDom('Bfrtip');

        $this->addOption('ordering', false);
        $this->addOption('language', [
            'emptyTable' => T::_('empty_ad_table')
        ]);
//        $this->addOption('paging', false);
        $this->addOption('select', [
            'style' => 'single',
            'selector' => 'td:first-child'
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
        $this->addButton(new ButtonCreate(null, $this->getEditor('ad_editor')));
        $this->addButton(new ButtonEdit(null, $this->getEditor('ad_editor')));
        $this->addButton(new ButtonRemove(null, $this->getEditor('ad_editor')));
    }

    /* * * * * * * * * * * * * * * * * * * * * * * * * * */
    /*     Columns
    /* * * * * * * * * * * * * * * * * * * * * * * * * * */

    public function initColumns(): void
    {
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