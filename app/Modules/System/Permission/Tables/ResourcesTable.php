<?php
namespace Modules\System\Permission\Tables;


use Lib\DTE\Table;
use Modules\System\Permission\Editors\ResourcesEditor;
use Modules\System\Permission\Models\ModelResources;
use Modules\System\Permission\Tables\Resources\Buttons;
use Modules\System\Permission\Tables\Resources\Columns;
use Lib\DTE\Table\Columns\Type\ColumnId;

class ResourcesTable extends Table
{
    use Columns;
    use Buttons;

    public function init()
    {
        $this->setEditor(
            new ResourcesEditor('resources_editor')
        );

        $this->rowGroup->setDataSrc('module_id.display');

        $this->setDom('Brtip');

        // add bootstrap
        $this->assetsCollection->addCss( 'assets/datatables.net-bs4/css/dataTables.bootstrap4.min.css' );
        $this->assetsManager->addJs( 'assets/datatables.net-bs4/js/dataTables.bootstrap4.min.js' );

        $this->addOption( 'responsive', true );
        $this->addOption( 'direction', 'rtl' );

        $this->initInlineEditing();
    }

    public function initButtons()
    {
        $this->btnCreate();
        $this->btnEdit();
        $this->btnDelete();
    }

    public function initColumns()
    {
        $this->addColumn(new ColumnId());
        $this->columnTitle();
        $this->columnModule();
        $this->columnController();
        $this->columnAction();
    }

    public function initData()
    {
        $this->setData(ModelResources::getTableInformation());
    }

    public function initAjax()
    {
        // TODO: Implement initAjax() method.
    }

    private function initInlineEditing()
    {
        $this->assetsManager->addInlineJsBottom( /** @lang JavaScript */
            <<<TAG

{$this->getName()}.on('click', 'td i', function(e) {
  e.stopImmediatePropagation();
  {$this->getEditor('resources_editor')->getName()}.bubble($(this).parent());
});

TAG
);
    }
}