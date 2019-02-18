<?php
namespace Modules\CreateContent\Ad\Widgets;


use Lib\Widget\WidgetAbstract;
use Modules\CreateContent\Ad\Editors\EditorSearch;
use Modules\System\PageManager\Models\WidgetInstance\ModelWidgetInstance;

class Ads extends WidgetAbstract
{

    public function initialize(ModelWidgetInstance $widgetInstance, $params = [])
    {
        $search = new EditorSearch('search_editor');

        return [
            'search' => $search->process(),
            'params' => $params
        ];
    }

    public static function setting(ModelWidgetInstance $widgetInstance)
    {
    }
}