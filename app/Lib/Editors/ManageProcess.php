<?php
namespace Lib\Editors;

use Lib\DTE\Asset\Assets;
use Lib\DTE\Editor\Fields\Field;

/**
 * @property Events events
 * @method   \Lib\Tables\Adapter|null getTable()
 * @property    Assets assetsManager
 * @property    Ajax ajaxCreate
 * @property    Ajax ajaxEdit
 * @property    Ajax ajaxRemove
 */
trait ManageProcess
{
    public function beforeProcess(): void
    {
        $this->init();
        $this->initAjax();
        $this->processFields();

        $this->ajaxCreate->process();
        $this->ajaxEdit->process();
        $this->ajaxRemove->process();

        // Events
        $this->events->submitSuccess("if (json['redirect']) {window.location.href=json['redirect'];}");

        if ($this->getTable())
        {
            $this->events->submitSuccess("if (json['reload']) { {$this->getTable()->getName()}.ajax.reload(); }");
        }
        $this->events->process();
        // End events
    }

    public function process()
    {
        $this->setCustomAssets();
        $this->beforeProcess();
        $this->processAssets();

        return $this;
    }

    protected function processFields()
    {
        $this->initFields();

        // make fields after init
        /** @var Field $field */
        foreach($this->getFields() as $field)
        {
            $field->init();
            $this->options['fields'][] = $field->toArray();
        }
    }

    public function setCustomAssets()
    {
        $this->assetsManager->addCss('dt/css/editor.dataTables.css');
        $this->assetsManager->addJs('dt/js/dataTables.editor.min.js');
    }
}