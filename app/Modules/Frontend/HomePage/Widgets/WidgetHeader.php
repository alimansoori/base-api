<?php
namespace Modules\Frontend\HomePage\Widgets;


use Lib\Widget\WidgetAbstract;
use Modules\Frontend\HomePage\DTE\Editor\EditorSession;
use Modules\System\PageManager\Models\WidgetInstance\ModelWidgetInstance;

class WidgetHeader extends WidgetAbstract
{
    public function initialize( ModelWidgetInstance $widgetInstance, $params = [] )
    {
        $editor = new EditorSession('session_editor');
        $editor_ad_new = new EditorSession('session_editor_ad_new', true);

        return [
            'session_editor' => $editor->process(),
            'session_editor_ad_new' => $editor_ad_new->process(),
            'pageWidget' => $widgetInstance,
            'params' => $params
        ];
    }

    public static function setting(ModelWidgetInstance $widgetInstance)
    {
        // TODO: Implement setting() method.
    }
}