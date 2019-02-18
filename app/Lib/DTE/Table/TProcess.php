<?php
namespace Lib\DTE\Table;
use Lib\Assets\Collection;
use Lib\Assets\Inline;
use Lib\Assets\Manager;
use Lib\Assets\Resource;
use Lib\Common\Strings;
use Lib\DTE\Asset\Assets;
use Lib\DTE\BaseEditor;
use Lib\DTE\Editor;
use Lib\DTE\Table\Columns\IColumn;

/**
 * @property Assets     assetsManager
 * @property Collection assetsCollection
 * @property Ajax       ajax
 * @property Manager    assets
 */
trait TProcess
{
    public function process()
    {
//        $this->makeParentChildData();

        $this->setCustomAssets();

        $this->init();
        $this->processColumns();
        $this->processButtons();
        $this->processAjax();
        $this->processRowGroup();
        $this->processSelect();
        $this->processEditors();
        $this->processAssets();
        $this->processJsonData();

        return $this;
    }

    private function processColumns()
    {
        $this->initColumns();

        /** @var IColumn $column */
        foreach($this->columns as $column)
        {
            $this->options['columns'][] = $column->toArray();
        }
    }

    private function processButtons()
    {
        $this->initButtons();

        /** @var Button $button */
        foreach($this->buttons as $button)
        {
            $this->options['buttons'][] = $button->toArray();
        }
    }

    private function processAjax()
    {
        $this->initAjax();

        if(is_array($this->ajax->toArray()) && !empty($this->ajax->toArray()))
            $this->addOption('ajax', $this->ajax->toArray());
    }

    private function processAssets()
    {
        $table = '';
        if($this->assetsManager->getCss() instanceof \Phalcon\Assets\Collection)
        {
            /** @var Resource $css */
            foreach($this->assetsManager->getCss()->getResources() as $css)
                $this->assets->collection('dte')->addCss($css->getPath(), $css->getLocal(), $css->getFilter(), $css->getAttributes());

            /** @var Inline $css */
            foreach($this->assetsManager->getCss()->getCodes() as $css)
                $this->assets->collection('dte')->addInlineJs($css->getContent(), $css->getFilter(), $css->getAttributes());

        }

        if($this->assetsManager->getJs() instanceof \Phalcon\Assets\Collection)
        {
            /** @var Resource $js */
            foreach($this->assetsManager->getJs()->getResources() as $js)
                $this->assets->collection('dte')->addJs($js->getPath(), $js->getLocal(), $js->getFilter(), $js->getAttributes());

            /** @var Inline $js */
            foreach($this->assetsManager->getJs()->getCodes() as $js)
                $this->assets->collection('dte')->addInlineJs($js->getContent(), $js->getFilter(), $js->getAttributes());
        }

        $table .= "$(document).ready(function() {";

        if($this->getName())
            $table .= "var ". $this->getName(). ";";

        /** @var Inline $content */
        foreach($this->assetsManager->getInlineJsTop() as $content)
            $table .= $content->getContent();

        /** @var Inline $content */
        foreach($this->assetsManager->getInlineJsMain() as $content)
            $table .= $content->getContent();

        $table .= "{$this->getName()} = $('#{$this->getName()}').DataTable( ";
        $table .= json_encode($this->options);
        $table .= ");";

        /** @var Inline $content */
        foreach($this->assetsManager->getInlineJsBottom() as $content)
            $table .= $content->getContent();

        $table .= "} );";

        $this->assets->collection('dte')->addInlineJs(
            Strings::clean($table)
        );
    }

    // in process
    private function makeParentChildData()
    {
        $tableName = null;
        if($this->getDTE()->getParent() !== null)
        {
            $editorName = $this->getEditor()->getName();
            $tableParentName = $this->getDTE()->getParent()->getTable()->getName();

            if($tableParentName)
            {
                $onSelect = '';
                $onSelect .= "$('#{$this->getDTE()->getName()}').hide();";
                $onSelect .= "$tableParentName.on('select', function() {";
                $onSelect .= "  $('#{$this->getDTE()->getName()}').show();";
                $onSelect .= "  {$this->getName()}.ajax.reload();";
                if($editorName && $this->getDTE()->getMap())
                {
                    $onSelect .= "$editorName.field('{$this->getDTE()->getMap()}').def($tableParentName.row( { selected: true } ).data().{$this->getDTE()->getIdFromParent()});";
                }
                $onSelect .= "});";
                $onDeSelect = '';

                $this->assetsManager->addInlineJsLow( /** @lang JavaScript */
                    "
                            {$onSelect}
                            $tableParentName.on('deselect', function() {
                              $('#{$this->getDTE()->getName()}').hide();
                              {$this->getName()}.ajax.reload();
                            });
                        ");
            }

        }

        $data = "";

        if($tableName)
        {
            $data = /** @lang JavaScript */
                "
                var selected = $tableName.row({selected:true});
                if ( selected.any() ) {
                    d.id_from_parent = selected.data().id;
                }
            ";
        }

        $this->ajax()->data()->addJsData(Strings::multilineToSingleline($data));
    }

    protected function processSelect()
    {
        if(!empty($this->select->toArray()))
            $this->addOption('select', $this->select->toArray());
        else
            $this->addOption('select', true);
    }

    protected function processRowGroup()
    {
        $this->rowGroup->afterInit();
        if(is_array($this->rowGroup->toArray()) && !empty($this->rowGroup->toArray()))
            $this->options['rowGroup'] = $this->rowGroup->toArray();
    }

    protected function processEditors()
    {
        /** @var BaseEditor $editor */
        foreach($this->getEditors() as $editor)
        {
            $editor->process();
        }
    }

    private function processJsonData()
    {
        if(
            $this->request->isAjax() &&
            (
                $this->request->getPost('name') == $this->getName()
            )
        )
        {
            $this->view->disable();

            $this->processData();

            $response['data'] = $this->getData();

            $response['debug'] = [];
            $response['files'] = [];
            $response['options'] = [];
//            $response['error'] = $this->getEditor()->getError();

            echo json_encode($response);
            die;
        }
    }

    private function isEditorAjax()
    {
        /** @var Editor $editor */
        foreach($this->getEditors() as $editor)
        {
            if($this->request->getPost('name') == $editor->getName())
                return true;
        }

        return false;
    }
}