<?php
namespace Modules\CreateContent\Currency\Tables;


use Lib\Tables\Adapter\HierarchyTable;
use Lib\Tables\Buttons\Editor\ButtonCreate;
use Lib\Tables\Buttons\Editor\ButtonEdit;
use Lib\Tables\Buttons\Editor\ButtonRemove;
use Lib\Tables\Column;
use Lib\Translate\T;
use Modules\CreateContent\Currency\Editors\PriceEditor;
use Modules\System\Native\Models\Language\ModelLanguage;

class PriceTable extends HierarchyTable
{
    public function initEditors(): void
    {
        $this->addEditor(
            new PriceEditor('price_editor', true)
        );
    }

    public function init(): void
    {
        $this->addOption('select', [
            'style' => 'single'
        ]);

        $this->addOption('serverSide', true);

        $this->setDom('Blfrtip');
        $this->ajax->setUrl($this->url->get([
            'for' => 'api_get_prices__'. ModelLanguage::getCurrentLanguage()
        ]));

        $this->setClassNames([
            'stripe', 'row-border', 'order-column'
        ]);
    }

    /* * * * * * * * * * * * * * * * * * * * * * * * * */
    /* Columns
    /* * * * * * * * * * * * * * * * * * * * * * * * * */

    public function initColumns(): void
    {
        $this->columnPrice();
        $this->columnCreatedAt();
        $this->columnCreated();
    }

    private function columnPrice()
    {
        $column = new Column('price');
        $column->setTitle(T::_('price'));
        $column->setOrderable(false);
        $column->setClassName('dt-center');
        $this->addColumn($column);
    }

    private function columnCreated()
    {
        $column = new Column('created');
        $column->setTitle(T::_('created'));
        $column->setOrderable(false);
        $column->setClassName('dt-center');
        $column->setRender(
            <<<TAG
            if (type == 'display')
            {
                return data.display;
            }
            return data._;
TAG

        );
        $this->addColumn($column);
    }

    private function columnCreatedAt()
    {
        $column = new Column('created_at');
        $column->setTitle(T::_('created_at'));
        $column->setOrderable(false);
        $column->setClassName('dt-center');
        $this->addColumn($column);
    }

    public function initButtons(): void
    {
        $create = new ButtonCreate('btn_create');
        $create->setText(T::_('create'));
        $create->setEditor($this->getEditor('price_editor'));
        $this->addButton($create);

        $edit = new ButtonEdit('btn_edit');
        $edit->setText(T::_('edit'));
        $edit->setEditor($this->getEditor('price_editor'));
        $this->addButton($edit);

        $remove = new ButtonRemove('btn_remove');
        $remove->setText(T::_('remove'));
        $remove->setEditor($this->getEditor('price_editor'));
        $this->addButton($remove);
    }
}