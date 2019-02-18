<?php
namespace Lib\DTE\Editor;


use Lib\Assets\Collection;
use Lib\Assets\Inline;
use Lib\Assets\Manager;
use Lib\Assets\Resource;
use Lib\Common\Strings;
use Lib\DTE\Asset\Assets;
use Lib\DTE\Editor\Fields\Field;
use Lib\DTE\Table;

/**
 * @property Events     events
 * @property Assets     assetsManager
 * @property Collection assetsCollection
 * @property Manager    assets
 * @method   Table      getTable()()
 */
trait TProcess
{
    public function process()
    {
        $this->init();

        $this->events->submitSuccess("if (json['redirect']) {window.location.href=json['redirect'];}");

        if ($this->getTable())
        {
            $this->events->submitSuccess("if (json['reload']) { {$this->getTable()->getName()}.ajax.reload(); }");
        }

        $this->events->process();

        $this->fieldsProcess();

        $this->AjaxProcess();

        $this->processJsonData();

//        $this->makeParentChildData();

        $this->setCustomAssets();

        if($this->getTable())
            $this->processAssetsTable();
        else
        {
            $this->processAssets();
        }

        return $this;
    }

    protected function setCustomAssets()
    {
        if(!$this->getTable())
        {
            $this->assetsManager->addJs('assets/datatables.net/js/jquery.dataTables.min.js');
            $this->assetsManager->addCss('assets/datatables.net-dt/css/jquery.dataTables.min.css');
        }
//        $this->assetsManager->addCss('assets/datatables.net-select-dt/css/select.dataTables.min.css');
        $this->assetsManager->addCss('dt/css/editor.dataTables.css');
        $this->assetsManager->addJs('dt/js/dataTables.editor.min.js');
    }

    protected function fieldsProcess()
    {
        $this->initFields();

        // make fields after init
        /** @var Field $field */
        foreach($this->getFields() as $field)
        {
            $this->addOption('fields', [$field->toArray()]);
        }
    }

    protected function AjaxProcess()
    {
        $this->initAjax();

        if(is_array($this->ajax->toArray()) && !empty($this->ajax->toArray()))
            $this->options['ajax'] = $this->ajax->toArray();
    }

    protected function processAssetsTable()
    {
        $this->assetsManager->addInlineJsTop("var ". $this->getName(). ";");

        if($this->assetsManager->getCss() instanceof \Phalcon\Assets\Collection)
        {
            /** @var Resource $css */
            foreach($this->assetsManager->getCss()->getResources() as $css)
                $this->getTable()->assetsManager->addCss($css->getPath(), $css->getLocal(), $css->getFilter(), $css->getAttributes());

            /** @var Inline $css */
            foreach($this->assetsManager->getCss()->getCodes() as $css)
                $this->getTable()->assetsManager->addInlineCss($css->getContent(), $css->getFilter(), $css->getAttributes());
        }

        if($this->assetsManager->getJs() instanceof \Phalcon\Assets\Collection)
        {
            /** @var Resource $js */
            foreach($this->assetsManager->getJs()->getResources() as $js)
                $this->getTable()->assetsManager->addJs($js->getPath(), $js->getLocal(), $js->getFilter(), $js->getAttributes());

            /** @var Inline $js */
            foreach($this->assetsManager->getJs()->getCodes() as $js)
                $this->getTable()->assetsManager->addInlineJs($js->getContent(), $js->getFilter(), $js->getAttributes());
        }

        /** @var Inline $content */
        foreach($this->assetsManager->getInlineJsTop() as $content)
            $this->getTable()->assetsManager->addInlineJsTop($content->getContent());

        $editor = "{$this->getName()} = new $.fn.dataTable.Editor( ";
        $editor .= json_encode($this->options);
        // process options to json encode
        $editor .= " );";

        $this->getTable()->assetsManager->addInlineJsMain($editor);

        /** @var Inline $content */
        foreach($this->assetsManager->getInlineJsMain() as $content)
            $this->getTable()->assetsManager->addInlineJsMain($content->getContent());

        /** @var Inline $content */
        foreach($this->assetsManager->getInlineJsBottom() as $content)
            $this->getTable()->assetsManager->addInlineJsBottom($content->getContent());
    }

    protected function processAssets()
    {
        $editor = '';

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

        $editor .= "$(document).ready(function() {";

        $editor .= "var ". $this->getName(). ";";

        /** @var Inline $content */
        foreach($this->assetsManager->getInlineJsTop() as $content)
            $editor .= $content->getContent();

        /** @var Inline $content */
        foreach($this->assetsManager->getInlineJsMain() as $content)
            $editor .= $content->getContent();

        $editor .= "{$this->getName()} = new $.fn.dataTable.Editor( ";
        $editor .= json_encode($this->options);
        // process options to json encode
        $editor .= " );";

        /** @var Inline $content */
        foreach($this->assetsManager->getInlineJsBottom() as $content)
            $editor .= $content->getContent();

        $editor .= "} );";
        $this->assets->collection('dte')->addInlineJs(Strings::clean($editor));
    }

    // in process
    private function makeParentChildData()
    {
        $tableName = null;
        if($this->getDTE()->getParent() !== null)
        {
            $tableName = $this->getDTE()->getParent()->getTable()->getName();
            $editorParentName = $this->getDTE()->getParent()->getEditor()->getName();
            if($editorParentName)
            {
                $this->assetsManager->addInlineJsLow( /** @lang JavaScript */
                    "
                            $editorParentName.on('submitSuccess', function() {
                              {$this->getTable()->getName()}.ajax.reload();
                            });
                        ");
            }

            $this->assetsManager->addInlineJsLow( /** @lang JavaScript */
                "
                            {$this->getName()}.on('submitSuccess', function() {
                              $tableName.ajax.reload();
                            });
                        ");
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

    private function processJsonData()
    {
        if(
            $this->request->isAjax() && $this->request->getPost('name') == $this->getName()
        )
        {
            $this->view->disable();
            $this->processData();

            $response['data'] = $this->getData();

            $response['debug'] = [];
            $response['files'] = [];
            $response['options'] = [];
            $response['fieldErrors'] = $this->getFieldErrors();
            $response['error'] = $this->getError();

            if($this->redirect)
            {
                $response['redirect'] = $this->redirect;
            }

            $response['reload'] = $this->reload;

            echo json_encode($response);
            die;
        }
    }

}