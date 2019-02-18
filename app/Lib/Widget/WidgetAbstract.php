<?php
namespace Lib\Widget;

use Lib\Assets\Collection;
use Lib\Mvc\Helper;
use Modules\System\PageManager\Models\WidgetInstance\ModelWidgetInstance;
use Phalcon\Mvc\User\Component;
use Phalcon\Text;

/**
 * @property Helper helper
 * @property Collection $assetsCollection
 * @property Collection $assetsWidgets
 */
abstract class WidgetAbstract extends Component
{
    private $module;

    public function run(ModelWidgetInstance $widgetInstance, $params = [])
    {
        $partial = Text::uncamelize(
            str_replace('Widget', '', substr(get_class($this), strrpos(get_class($this), '\\') + 1)),
            '-'
        );
        $this->widgetPartial( $partial, $this->initialize($widgetInstance, $params));
    }

    public function widgetPartial($template, $data = [])
    {
        $this->helper->modulePartial($template, $data, $this->module);
    }

    public function setModule($module)
    {
        $this->module = $module;
    }

//    protected function initialize()
//    {
//        return [];
//    }

    abstract public function initialize(ModelWidgetInstance $widgetInstance, $params = []);

    abstract public static function setting(ModelWidgetInstance $widgetInstance);
}