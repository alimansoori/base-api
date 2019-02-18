<?php
namespace Modules\System\Permission\Tables\Resources;


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
        $btn->setEditor($this->getEditor('resources_editor'));

        $this->addButton($btn);
    }

    protected function btnEdit()
    {
        $btn = new ButtonEdit('btn_edit');
        $btn->setText(T::_('edit'));
        $btn->setEditor( $this->getEditor( 'resources_editor' ) );
        $this->addButton( $btn );
    }

    protected function btnDelete()
    {
        $btn = new ButtonRemove('btn_remove');
        $btn->setText(T::_('remove'));
        $btn->setEditor($this->getEditor('resources_editor'));

        $this->addButton($btn);
    }
}