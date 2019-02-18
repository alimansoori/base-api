<?php
namespace Modules\System\Permission\Tables;


use Lib\DTE\Table;
use Modules\System\Permission\Editors\RolesEditor;
use Modules\System\Permission\Models\ModelRoles;
use Modules\System\Permission\Tables\Roles\Buttons;
use Modules\System\Permission\Tables\Roles\Columns;
use Lib\DTE\Table\Columns\Type\ColumnId;

class RolesTable extends Table
{
    use Columns;
    use Buttons;

    public function init()
    {
        $this->setEditor(
            new RolesEditor('roles_editor')
        );

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
        $this->btnCreateRole();
        $this->btnEditRole();
        $this->btnDeleteRole();
        $this->btnLinkToPermissions();
    }

    public function initColumns()
    {
        $this->addColumn(new ColumnId());
        $this->columnTitle();
        $this->columnRelatedModule();
        $this->columnStatus();
    }

    public function initData()
    {
        $this->setData(ModelRoles::getUsersTableInformation());
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
  {$this->getEditor('roles_editor')->getName()}.bubble($(this).parent());
});

TAG
);
    }
}