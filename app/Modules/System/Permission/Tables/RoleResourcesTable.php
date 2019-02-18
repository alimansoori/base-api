<?php
namespace Modules\System\Permission\Tables;

use Lib\DTE\Table;
use Modules\System\Permission\Editors\RoleResourcesEditor;
use Modules\System\Permission\Models\ModelRoleResourceMap;
use Modules\System\Permission\Tables\RoleResources\Buttons;
use Modules\System\Permission\Tables\RoleResources\Columns;

class RoleResourcesTable extends Table
{
    use Columns;
    use Buttons;

    private $roleId;

    public function __construct( $name, $userId )
    {
        parent::__construct( $name );
        $this->roleId = $userId;
    }

    public function init()
    {
        $this->setEditor(
            new RoleResourcesEditor('role_resources_editor')
        );

        $this->rowGroup->setDataSrc('module');

        $this->addOption('rowCallback', "||function ( row, data ) {
            $('input.editor-active', row).prop( 'checked', data.status == 1 );
        }||");

//        $this->setDom('Brtip');

        // add bootstrap
        $this->assetsCollection->addCss( 'assets/datatables.net-bs4/css/dataTables.bootstrap4.min.css' );
        $this->assetsManager->addJs( 'assets/datatables.net-bs4/js/dataTables.bootstrap4.min.js' );

        $this->addOption( 'responsive', true );
        $this->addOption( 'direction', 'rtl' );

        $this->changeCheckbox();
    }

    public function initButtons()
    {
//        $this->btnCreate();
//        $this->btnEdit();
//        $this->btnDelete();
    }

    public function initColumns()
    {
        $this->columnStatus();
        $this->columnTitle();
        $this->columnModule();
        $this->columnController();
        $this->columnAction();
    }

    public function initData()
    {
        $this->setData(ModelRoleResourceMap::getResourcesForRole($this->dispatcher->getParam('role_id')));
    }

    public function initAjax()
    {
        // TODO: Implement initAjax() method.
    }

    private function changeCheckbox()
    {
        $this->assetsManager->addInlineJsBottom( /** @lang JavaScript */
            <<<TAG

{$this->getName()}.on('change', 'input.editor-active', function(e) {
  {$this->getEditor('role_resources_editor')->getName()}
    .edit($(this).closest('tr'), false)
    .set('status', $(this).prop( 'checked' ) ? 1 : 0)
    .submit();
});

TAG
);
    }
}