<?php
namespace Modules\Frontend\HomePage\Widgets;


use Lib\Widget\WidgetAbstract;
use Modules\Frontend\HomePage\DTE\Editor\EditorSession;
use Modules\System\PageManager\Models\WidgetInstance\ModelWidgetInstance;

class WidgetFooter extends WidgetAbstract
{
    public function initialize( ModelWidgetInstance $widgetInstance, $params = [] )
    {
        $editor = new EditorSession('session_editor');

        return [
            'session_editor' => $editor->process(),
            'params' => $params
        ];
    }

    public static function setting(ModelWidgetInstance $widgetInstance)
    {
        // TODO: Implement setting() method.
    }
}