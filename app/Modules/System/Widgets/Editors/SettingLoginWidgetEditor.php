<?php
namespace Modules\System\Widgets\Editors;


use Lib\DTE\Editor\Fields\Type\Text;
use Lib\DTE\Editor\StandaloneEditor;
use Lib\Translate\T;
use Modules\System\PageManager\Models\WidgetInstance\ModelWidgetInstance;

class SettingLoginWidgetEditor extends StandaloneEditor
{
    private $widgetInstance;

    public function __construct($name, ModelWidgetInstance $widgetInstance)
    {
        parent::__construct($name);
        $this->widgetInstance = $widgetInstance;
    }

    public function init()
    {
        $this->assets->addInlineCss(<<<TAG
            dt[data-editor-label] { text-align: right; }
            dt { margin-top: 1em; }
            dt:first-child { margin-top: 0; }
            dd { width: 25% }
         
            *[data-editor-field] {
                border: 1px dashed #ccc;
                padding: 0.5em;
                margin: 0.5em;
            }
         
            *[data-editor-field]:hover {
                background: #f3f3f3;
                border: 1px dashed #333;
            }
TAG
);
        $this->assetsManager->addInlineJsBottom(<<<TAG
        $('#{$this->getName()}').on( 'click', 'dd[data-editor-field]', function (e) {
            {$this->getName()}.bubble( this );
        } );
TAG
);
    }

    public function initData()
    {
        $this->addDatum([
            'title' => 'Ali'
        ]);
    }

    public function initFields()
    {
        $title = new Text('title');
        $title->setLabel(T::_('title'));

        $this->addField($title);
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
        // TODO: Implement editAction() method.
    }

    public function removeAction()
    {
        // TODO: Implement removeAction() method.
    }

    public function initAjaxInitData()
    {
        $this->ajaxInitData->setDataType('json');
        $this->ajaxInitData->setSuccess( /** @lang JavaScript */
            "
for ( var i=0, ien=json.data.length ; i<ien ; i++ ) {
                panel{$this->getName()}( json.data[i] );
            }
");
    }
}