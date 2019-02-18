<?php
namespace Modules\System\PageManager\DTE\Editor;


use Lib\DTE\Editor\StandaloneEditor;
use Modules\System\PageManager\DTE\Editor\PageManager\TEditorPageManager;

class EditorPageManagerrr extends StandaloneEditor
{
    use TEditorPageManager;

    public function init()
    {
        $this->assetsManager->addInlineJsBottom( /** @lang JavaScript */
            "
$('#{$this->getName()}').on( 'click', 'dl dd[data-editor-field]', function (e) {
    {$this->getName()}.bubble( this );
} );
");
    }

    public function initData()
    {
        $this->addDatum([
            'title' => 'Ali'
        ]);
    }

    public function initFields()
    {
        $this->fieldTitle();
    }

    public function initAjax()
    {
        // TODO: Implement initAjax() method.
    }

    public function createAction()
    {
        // TODO: Implement createAction() method.
    }

    public function editAction()
    {
        $this->setData(array_values($this->getDataAfterValidate()));
    }

    public function removeAction()
    {
        // TODO: Implement removeAction() method.
    }

    public function initAjaxInitData()
    {
        $this->ajaxInitData->setSuccess(<<<TAG
        json = JSON.parse(json);
        for ( var i=0, ien=json.data.length ; i<ien ; i++ ) {
            alert('UUUUPPP');
            panel{$this->getName()}( json.data[i] );
        }
TAG
);
    }
}