<?php
namespace Modules\CreateContent\Currency\Tables;


use Lib\Tables\Column\Type\ColumnReOrder;
use Lib\Tables\Adapter\HierarchyTable;
use Lib\Tables\Buttons\Editor\ButtonCreate;
use Lib\Tables\Buttons\Editor\ButtonEdit;
use Lib\Tables\Buttons\Editor\ButtonRemove;
use Lib\Tables\Column;
use Lib\Translate\T;
use Modules\CreateContent\Currency\Editors\CategoryEditor;
use Modules\System\Native\Models\Language\ModelLanguage;

class CategoryTable extends HierarchyTable
{
    public function initEditors(): void
    {
        $this->addEditor(
            new CategoryEditor('category_editor')
        );
    }

    public function init(): void
    {
//        $this->initFixedColumns();

        $this->addOption('select',[
            'style' => 'single'
        ]);

        $this->addOption('stateSave', true);
        $this->addOption('serverSide', true);

        $this->setDom('Bfrtip');
        $this->ajax->setUrl($this->url->get([
            'for' => 'api_get_currency_categories__'. ModelLanguage::getCurrentLanguage()
        ]));

        $this->setClassNames([
            'stripe', 'row-border', 'order-column'
        ]);
    }

    public function initColumns(): void
    {
        $this->columnPosition();
        $this->columnTitle();
    }

    private function columnPosition()
    {
        $column = new ColumnReOrder('position');
        $column->setTitle(T::_('row'));
        $column->setClassName('dt-center');
        $column->setEditor($this->getEditor('category_editor'));
        $column->setWidth('10px');
        $this->addColumn($column);
    }

    private function columnTitle()
    {
        $column = new Column('title');
        $column->setTitle(T::_('title'));
        $column->setClassName('dt-center');
        $this->addColumn($column);
    }

    public function initButtons(): void
    {
        $create = new ButtonCreate('btn_create');
        $create->setText(T::_('create'));
        $create->setEditor($this->getEditor('category_editor'));
        $this->addButton($create);

        $edit = new ButtonEdit('btn_edit');
        $edit->setText(T::_('edit'));
        $edit->setEditor($this->getEditor('category_editor'));
        $this->addButton($edit);

        $remove = new ButtonRemove('btn_remove');
        $remove->setText(T::_('remove'));
        $remove->setEditor($this->getEditor('category_editor'));
        $this->addButton($remove);
    }
}