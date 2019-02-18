<?php
/*
	Widget Name: calender_widget
	Widget URI:
	Widget Description: calender_widget_description
	Widget Version: 1.0
	Widget Date: 2018-03-27
	Widget Author: Ali Mansoori
	Widget Author URI: https://www.ilyaidea.ir/
	Widget License: GPLv2
	Widget Minimum IlyaIdea Version: 1.4
	Widget Update Check URI:
*/
namespace Modules\System\Widgets\Widgets;

use Modules\System\PageManager\Models\WidgetInstance\ModelWidgetInstance;
use Lib\Widget\WidgetAbstract;
use Modules\System\Widgets\Editors\SettingLoginWidgetEditor;

class Login extends WidgetAbstract
{
    public function initialize(ModelWidgetInstance $widgetInstance, $params = [])
    {
        return [
            'name' => 'Login_'. $widgetInstance->getTitle(). ' => '. $widgetInstance->getWidget()->getName(),
            'pageWidget' => $widgetInstance,
            'params' => $params
        ];
    }

    public static function setting(ModelWidgetInstance $widgetInstance)
    {
        $editor = new SettingLoginWidgetEditor('setting_login_editor', $widgetInstance);

        return $editor->process();
    }

    private static function fields(ModelWidgetInstance $widgetInstance)
    {
        $fields = [];

        return $fields;
    }
}