<?php
namespace Modules\System\Permission\Tables;


use Lib\DTE\Table;
use Modules\System\Permission\Editors\UserRolesEditor;
use Modules\System\Permission\Tables\RoleResources\Buttons;
use Modules\System\Permission\Tables\RoleResources\Columns;
use Modules\System\Users\Models\UserRoleMap\ModelUserRoleMap;

class UserRolesTable extends Table
{
    use Columns;
    use Buttons;

    private $userId;

    public function __construct( $name, $userId )
    {
        parent::__construct( $name );
        $this->userId = $userId;
    }

    public function init()
    {
        $this->setEditor(
            new UserRolesEditor('user_roles_editor', $this->userId)
        );

//        $this->rowGroup->setDataSrc('module');

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
    }

    public function initColumns()
    {
        $this->columnStatus();
        $this->columnTitle();
        $this->columnModule();
    }

    public function initData()
    {
        $this->setData(ModelUserRoleMap::getRolesForUser($this->dispatcher->getParam('user_id')));
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
  {$this->getEditor('user_roles_editor')->getName()}
    .edit($(this).closest('tr'), false)
    .set('status', $(this).prop( 'checked' ) ? 1 : 0)
    .submit();
});
TAG
);
    }
}