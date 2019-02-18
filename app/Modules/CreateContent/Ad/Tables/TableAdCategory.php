<?php

namespace Modules\CreateContent\Ad\Tables;


use Lib\Tables\Adapter\TreeViewTable;
use Lib\Tables\Buttons\Editor\ButtonCreate;
use Lib\Tables\Buttons\Editor\ButtonEdit;
use Lib\Tables\Buttons\Editor\ButtonRemove;
use Lib\Tables\Column;
use Lib\Translate\T;
use Modules\CreateContent\Ad\Editors\EditorCategory;
use Modules\System\Native\Models\Language\ModelLanguage;

class TableAdCategory extends TreeViewTable
{
    public function initEditors(): void
    {
        $this->addEditor(new EditorCategory('category_editor'));
    }

    public function init(): void
    {
        $this->ajax->setUrl(
            $this->url->get([
                'for' => 'api_get_ad_category__'. ModelLanguage::getCurrentLanguage()
            ])
        );
        $this->setDom('Blfrtip');

        $this->addOption('ordering', false);
        $this->addOption('paging', false);
        $this->addOption('select', [
            'style' => 'single',
            'selector' => 'td.selectable'
        ]);

        // style
        $this->addClassName('display');
    }

    /* * * * * * * * * * * * * * * * * * * * * * * * * * */
    /*     Buttons
    /* * * * * * * * * * * * * * * * * * * * * * * * * * */

    public function initButtons(): void
    {
        $this->addButton(new ButtonCreate(null, $this->getEditor('category_editor')));
        $this->addButton(new ButtonEdit(null, $this->getEditor('category_editor')));
        $this->addButton(new ButtonRemove(null, $this->getEditor('category_editor')));
    }

    /* * * * * * * * * * * * * * * * * * * * * * * * * * */
    /*     Columns
    /* * * * * * * * * * * * * * * * * * * * * * * * * * */

    public function initColumns(): void
    {
        $this->columnTitle();
        $this->columnParentId();
    }

    public function columnTitle()
    {
        $column = new Column('title');
        $column->setTitle(T::_('title'));
        $column->setClassName('dt-center selectable');
        $this->addColumn($column);
    }

    public function columnParentId()
    {
        $column = new Column('parent_id');
        $column->setVisible(false);
        $this->addColumn($column);
    }
}