<?php
namespace Modules\System\Menu\DTE\Tables\TableAdminMenu;


use Lib\DTE\Table\Buttons\Editor\ButtonCreate;
use Lib\DTE\Table\Buttons\Editor\ButtonEdit;
use Lib\DTE\Table\Buttons\Editor\ButtonRemove;
use Lib\Translate\T;

trait Buttons
{
    protected function btnCreate()
    {
        $btn = new ButtonCreate('btn_create');
        $btn->setText(T::_('create'));
        $btn->setEditor($this->getEditor('admin_menu_editor'));

        $this->addButton($btn);
    }
    protected function btnEdit()
    {
        $btn = new ButtonEdit('btn_edit');
        $btn->setText(T::_('edit'));
        $btn->setEditor($this->getEditor('admin_menu_editor'));

        $this->addButton($btn);
    }
    protected function btnRemove()
    {
        $btn = new ButtonRemove('btn_remove');
        $btn->setText(T::_('remove'));
        $btn->setEditor($this->getEditor('admin_menu_editor'));

        $this->addButton($btn);
    }
}