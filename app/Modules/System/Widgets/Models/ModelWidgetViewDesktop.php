<?php
namespace Modules\System\Widgets\Models;


use Lib\Mvc\Model;
use Modules\System\PageManager\Models\WidgetInstance\ModelWidgetInstance;
use Phalcon\Validation\Validator\InclusionIn;
use Phalcon\Validation\Validator\Numericality;

/**
 * @method ModelWidgetInstance      getWidgetInstance()
 * @method ModelPageWidgetPlaceMap  getPagePlaceMap()
 */
class ModelWidgetViewDesktop extends Model
{
    private $id;
    private $widget_id;
    private $page_place_id;
    private $column;
    private $row;

    protected function init()
    {
        $this->setSource('widget_view_desktop');
        $this->setDbRef(true);
    }

    protected function relations()
    {
        $this->belongsTo(
            'widget_id',
            ModelWidgetInstance::class,
            'id',
            [
                'alias' => 'WidgetInstance'
            ]
        );

        $this->belongsTo(
            'page_place_id',
            ModelPageWidgetPlaceMap::class,
            'id',
            [
                'alias' => 'PagePlaceMap'
            ]
        );
    }

    protected function mainValidation()
    {
        $this->validator->add(
            'widget_id',
            new InclusionIn([
                'domain' => array_merge(
                    ['null'],
                    array_column(
                        ModelWidgetInstance::find(['columns' => 'id'])->toArray(),
                        'id'
                    )
                ),
                'allowEmpty' => true
            ])
        );

        $this->validator->add(
            'page_place_id',
            new InclusionIn([
                'domain' => array_column(
                    ModelPageWidgetPlaceMap::find(['columns' => 'id'])->toArray(),
                    'id'
                )
            ])
        );

        $this->validator->add(
            'column',
            new InclusionIn([
                'domain' => [1,2,3,4,5,6,7,8,9,10,11,12]
            ])
        );

        $this->validator->add(
            'row',
            new Numericality()
        );
    }

    public function afterSaveEditor()
    {
        if ($this->getPagePlaceId())
        {
            for ($i=1; $i<=12; $i++)
            {
                if ($i == $this->getColumn())
                    continue;

                if (!$this->getWidgetId())
                {
                    $widgetPlace = self::findFirst([
                        'conditions' => 'widget_id IS NULL AND page_place_id=:p_id: AND column=:col: AND row=:row:',
                        'bind' => [
                            'p_id' => $this->getPagePlaceId(),
                            'column' => $i,
                            'row' => $this->row
                        ]
                    ]);
                }
                else
                {
                    $widgetPlace = self::findFirst([
                        'conditions' => 'widget_id=:w_id: AND page_place_id=:p_id: AND column=:column: AND row=:row:',
                        'bind' => [
                            'w_id' => $this->getWidgetId(),
                            'p_id' => $this->getPagePlaceId(),
                            'column' => $i,
                            'row' => $this->getRow()
                        ]
                    ]);
                }

                if (!$widgetPlace)
                {
                    $model = new self();
                    $model->setWidgetId(null);
                    if ($this->getWidgetId())
                    {
                        $model->setWidgetId($this->getWidgetId());
                    }
                    $model->setPagePlaceId($this->getPagePlaceId());
                    $model->setColumn($i);
                    $model->setRow($this->getRow());

                    if (!$model->save())
                    {
                        dump($model->getMessages());
                    }
                }
            }
        }
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
    public function getWidgetId()
    {
        return $this->widget_id;
    }

    /**
     * @param mixed $widget_id
     */
    public function setWidgetId($widget_id): void
    {
        $this->widget_id = $widget_id;
    }

    /**
     * @return mixed
     */
    public function getPagePlaceId()
    {
        return $this->page_place_id;
    }

    /**
     * @param mixed $page_place_id
     */
    public function setPagePlaceId($page_place_id): void
    {
        $this->page_place_id = $page_place_id;
    }

    /**
     * @return mixed
     */
    public function getColumn()
    {
        return $this->column;
    }

    /**
     * @param mixed $column
     */
    public function setColumn($column): void
    {
        $this->column = $column;
    }

    /**
     * @return mixed
     */
    public function getRow()
    {
        return $this->row;
    }

    /**
     * @param mixed $row
     */
    public function setRow($row): void
    {
        $this->row = $row;
    }
}