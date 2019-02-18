<?php
namespace Modules\System\Widgets\Tables;


use Lib\DTE\Table;
use Modules\System\Widgets\Editors\ModulesEditor;
use Modules\System\Widgets\Models\ModelModules;
use Modules\System\Widgets\Tables\Modules\Buttons;
use Modules\System\Widgets\Tables\Modules\Columns;

class ModulesTable extends Table
{
    use Columns;
    use Buttons;

    public function init()
    {

        $this->setDom('Blfrtip');

        $this->addEditor(new ModulesEditor('modules_editor'));

        $this->initInlineEditing();
        // add bootstrap
        $this->assetsCollection->addCss( 'assets/datatables.net-bs4/css/dataTables.bootstrap4.min.css' );
        $this->assetsManager->addJs( 'assets/datatables.net-bs4/js/dataTables.bootstrap4.min.js' );
    }

    public function initButtons()
    {
        $this->btnCreate();
        $this->btnEdit();
        $this->btnRemove();
    }

    public function initColumns()
    {
        $this->columnReorder();
        $this->columnName();
        $this->columnTitle();
        $this->columnDescription();
    }

    public function initData()
    {
        $this->setData(ModelModules::getModulesTableInformation());
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
  {$this->getEditor('modules_editor')->getName()}.bubble($(this).parent());
});

TAG
        );
    }
}