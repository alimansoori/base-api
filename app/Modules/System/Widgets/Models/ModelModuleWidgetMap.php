<?php
namespace Modules\System\Widgets\Models;


use Lib\Mvc\Model;
use Modules\System\Widgets\Models\Widgets\ModelWidgets;

/**
 * @method ModelModules getModule()
 * @method ModelWidgets getWidget()
 */
class ModelModuleWidgetMap extends Model
{
    private $id;
    private $module_id;
    private $widget_id;

    protected function init()
    {
        $this->setSource('module_widget_map');
        $this->setDbRef(true);
    }

    protected function relations()
    {
        $this->belongsTo(
            'module_id',
            ModelModules::class,
            'id',
            [
                'alias' => 'Module'
            ]
        );

        $this->belongsTo(
            'widget_id',
            ModelWidgets::class,
            'id',
            [
                'alias' => 'Widget'
            ]
        );
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getModuleId()
    {
        return $this->module_id;
    }

    /**
     * @param mixed $module_id
     */
    public function setModuleId( $module_id ): void
    {
        $this->module_id = $module_id;
    }

    /**
     * @return mixed
     */
    public function getWidgetId()
    {
        return $this->widget_id;
    }

    /**
     * @param mixed $widget_id
     */
    public function setWidgetId( $widget_id ): void
    {
        $this->widget_id = $widget_id;
    }
}