<?php
namespace Lib\DTE\Editor;


use Lib\Common\Strings;
use Lib\DTE\AjaxInputData;
use Lib\DTE\BaseEditor;

abstract class StandaloneEditor extends BaseEditor
{
    /** @var AjaxInputData $ajaxInitData */
    public $ajaxInitData;

    public function __construct( $name )
    {
        parent::__construct( $name );

        $this->ajaxInitData = new AjaxInputData($this);
    }

    abstract public function initData();
    abstract public function initAjaxInitData();

    public function render()
    {
        return "<div id='{$this->getName()}'></div>";
    }

    public function process()
    {
        $this->fieldsProcess();
        $this->initAjaxInitData();
        $this->panel();

        $jsonOutput = Strings::clean(
            json_encode($this->ajaxInitData->toArray())
        );
        $this->assetsManager->addInlineJsBottom( /** @lang JavaScript */
            "
$.ajax( {$jsonOutput} );
");

        $this->init();

        $this->AjaxProcess();

        $this->processJsonData();

        $this->setCustomAssets();

        $this->processAssets();

        return $this;
    }

    protected function panel()
    {
        $this->assetsManager->addInlineJsTop( /** @lang JavaScript */
            "
function panel{$this->getName()} ( data )
{
    var id = data.DT_RowId;
    $({$this->outputFields()}).appendTo( '#{$this->getName()}' );
}
");
    }

    protected function outputFields()
    {
        $out = "'<dl>'+";

        foreach($this->getFields() as $field)
        {
            $out .= "'<dt data-editor-label=\"{$field->getName()}\">{$field->getLabel()}</dt>'+";
            $out .= "'<dd data-editor-field=\"{$field->getName()}\">'+data.{$field->getName()}+'</dd>'+";
        }

        $out .= "'</dl>'";

        return $out;
    }

    public function processData()
    {
        parent::processData();

        if(
            $this->request->isAjax() &&
            $this->request->getPost('action') == 'initData' &&
            $this->request->getPost('name') &&
            $this->request->getPost('name') == $this->getName()
        )
        {
            $this->data = [];
            $this->view->disable();

            $this->initData();
        }
    }

    protected function setCustomAssets()
    {
        $this->assetsManager->addJs('assets/datatables.net/js/jquery.dataTables.min.js');
        $this->assetsManager->addCss('assets/datatables.net-dt/css/jquery.dataTables.min.css');
        parent::setCustomAssets();
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

            echo json_encode($response);
            die;
        }
    }
}