<?php
namespace Modules\System\Widgets\DTE\Editor;


use Lib\Mvc\Model\Widgets\ModelWidgets;
use Modules\System\Widgets\DTE\Editor\Widgets\TFields;
use Lib\DTE\Editor;

class EditorWidgets extends Editor
{
    use TFields;

    public function init()
    {
        $this->assetsManager->addInlineJsBottom( /** @lang JavaScript */
            "
$('#tableWidgets').on('click', 'tbody td:not(:first-child)', function (e) {
        editorWidgets.bubble( this );
    });
");
    }

    public function initFields()
    {
        $this->fieldWidget();
        $this->fieldRoutes();
        $this->fieldPlace();
        $this->fieldPosition();
        $this->fieldWidth();
        $this->fieldDisplay();
    }

    public function initAjax()
    {
    }

    public function createAction()
    {
        foreach($this->getDataAfterValidate() as $data)
        {
            $widget = new ModelWidgets();
            $widget->setFieldsByData($data);

            if(!$widget->save())
            {
                $this->appendMessages($widget->getMessages());
                continue;
            }
            $widget->sortByPosition();
        }
    }

    public function editAction()
    {
        foreach($this->getDataAfterValidate() as $keyId => $data)
        {
            $id = str_replace('row_', '', $keyId);
            /** @var ModelWidgets $widget */
            $widget = ModelWidgets::findFirst($id);
            if(!$widget)
                continue;
            $widget->setFieldsByData($data);
            if(!$widget->update())
            {
                $this->appendMessages($widget->getMessages());
            }
        }
    }

    public function removeAction()
    {
        foreach($this->getDataAfterValidate() as $keyId => $data)
        {
            $id = str_replace('row_', '', $keyId);
            /** @var ModelWidgets $widget */
            $widget = ModelWidgets::findFirst($id);
            if(!$widget)
                continue;

            if(!$widget->delete())
            {
                $this->appendMessages($widget->getMessages());
            }
        }
    }

}