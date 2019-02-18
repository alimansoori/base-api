<?php
namespace Modules\System\Permission\Tables\Roles;


use Lib\DTE\Table\Buttons\ButtonLinkToSelected;
use Lib\DTE\Table\Buttons\Editor\ButtonCreate;
use Lib\DTE\Table\Buttons\Editor\ButtonEdit;
use Lib\DTE\Table\Buttons\Editor\ButtonRemove;
use Lib\Translate\T;
use Modules\System\Native\Models\Language\ModelLanguage;

trait Buttons
{
    protected function btnLinkToPermissions()
    {
        $btn = new ButtonLinkToSelected(
            'btn_link_to_permissions',
            $this->url->get([
                'for' => 'role_resources__'. ModelLanguage::getCurrentLanguage()
            ])
        );
        $btn->setText(T::_('btn_link_to_permissions'));
        $btn->setEditor($this->getEditor('roles_editor'));

        $this->addButton($btn);
    }

    protected function btnCreateRole()
    {
        $btn = new ButtonCreate('btn_create_role');
        $btn->setText(T::_('btn_create_role'));
        $btn->setEditor($this->getEditor('roles_editor'));

        $this->addButton($btn);
    }

    protected function btnEditRole()
    {
        $btn = new ButtonEdit('btn_edit_role');
        $btn->setText(T::_('btn_edit_role'));
        $btn->setEditor( $this->getEditor( 'roles_editor' ) );
        $this->addButton( $btn );
    }

    protected function btnDeleteRole()
    {
        $btn = new ButtonRemove('btn_remove_role');
        $btn->setText(T::_('btn_remove_role'));
        $btn->setEditor($this->getEditor('roles_editor'));

        $this->addButton($btn);
    }
}