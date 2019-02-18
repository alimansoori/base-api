<?php
namespace Modules\System\Widgets\Models;


use Lib\Mvc\Model;
use Lib\Validation;
use Modules\System\PageManager\Models\Pages\ModelPages;
use Modules\System\Widgets\Models\WidgetPlaces\ModelWidgetPlaces;
use Phalcon\Mvc\Model\Message;
use Phalcon\Validation\Validator\InclusionIn;

/**
 * @property Validation validator
 * @method ModelPages getPage()
 * @method ModelWidgetPlaces getPlace()
 * @method ModelWidgetViewDesktop[] getWidgetViewDesktop()
 * @method ModelWidgetViewTablet[] getWidgetViewTablet()
 * @method ModelWidgetViewMobile[] getWidgetViewMobile()
 */
class ModelPageWidgetPlaceMap extends Model
{
    private $id;
    private $page_id;
    private $place_id;

    protected function init()
    {
        $this->setSource('page_widget_place_map');
        $this->setDbRef(true);
    }

    protected function relations()
    {
        $this->belongsTo(
            'page_id',
            ModelPages::class,
            'id',
            [
                'alias' => 'Page'
            ]
        );

        $this->belongsTo(
            'place_id',
            ModelWidgetPlaces::class,
            'id',
            [
                'alias' => 'Place'
            ]
        );

        $this->hasMany(
            'id',
            ModelWidgetViewDesktop::class,
            'page_place_id',
            [
                'alias' => 'WidgetViewDesktop'
            ]
        );

        $this->hasMany(
            'id',
            ModelWidgetViewTablet::class,
            'page_place_id',
            [
                'alias' => 'WidgetViewTablet'
            ]
        );

        $this->hasMany(
            'id',
            ModelWidgetViewMobile::class,
            'page_place_id',
            [
                'alias' => 'WidgetViewMobile'
            ]
        );
    }

    protected function mainValidation()
    {
        $this->validator->add(
            'page_id',
            new InclusionIn([
                'domain' => array_column(
                    ModelPages::find(['columns' => 'id'])->toArray(),
                    'id'
                )
            ])
        );

        $this->validator->add(
            'place_id',
            new InclusionIn([
                'domain' => array_column(
                    ModelWidgetPlaces::find(['columns' => 'id'])->toArray(),
                    'id'
                )
            ])
        );
    }

    /* * * * * * * * */
    /*     Events    */
    /* * * * * * * * */

    public function beforeCreate()
    {
        parent::beforeCreate();

        $pageWidgetPlace = self::findFirst([
            'conditions' => 'page_id=:page_id: AND place_id=:place_id:',
            'bind' => [
                'page_id' => $this->getPageId(),
                'place_id' => $this->getPlaceId()
            ]
        ]);

        if ($pageWidgetPlace)
        {
            $this->appendMessage(new Message(
                'already exist record by this page_id and place_id'
            ));

            return false;
        }
    }

    /* * * * * * * * * * * * */
    /*     Static Methods    */
    /* * * * * * * * * * * * */

    public static function getTableInformation($device, $pageId, $placeId)
    {
        /** @var ModelPageWidgetPlaceMap $pageWidgetPlace */
        $pageWidgetPlace = self::findFirst([
            'conditions' => 'page_id=:page_id: AND place_id=:place_id:',
            'bind' => [
                'page_id' => $pageId,
                'place_id' => $placeId
            ]
        ]);

        if (!$pageWidgetPlace)
            return [];

        $widgetsView = null;

        $row = [];

        if ($device == 'desktop')
        {
            /** @var ModelWidgetViewDesktop[] $widgetsView */
            $widgetsView = $pageWidgetPlace->getWidgetViewDesktop([
                'order' => 'row, column'
            ]);

            $rowKey = null;
            $i=1;
            foreach ($widgetsView as $value)
            {
                if ($rowKey != $value->getRow())
                {
                    $i = 1;
                }

                $row[$value->getRow()][ 'DT_RowId'] = $value->getRow();

                if ($value->getColumn() != $i)
                {

                    for ($j = $i; $j<$value->getColumn(); $j++)
                    {
                        $row[$value->getRow()][ $j] = [
                            'display' => '_',
                            '_' => null
                        ];
                    }

                    $i++;
                    $rowKey = $value->getRow();
                    //                    continue;
                }

                if ($value->getColumn() == $i)
                {
                    $row[$value->getRow()][ $value->getColumn()] = [
                        'display' => is_null($value->getWidgetId()) ? '_' : $value->getWidgetInstance()->getWidget()->getName(),
                        '_' => $value->getWidgetId()
                    ];

                    $rowKey = $value->getRow();
                    $i++;
                    continue;
                }
            }
        }
        elseif ($device == 'tablet')
        {
            /** @var ModelWidgetViewTablet[] $widgetsView */
            $widgetsView = $pageWidgetPlace->getWidgetViewTablet([
                'order' => 'row, column'
            ]);

            $rowKey = null;
            $i=1;
            foreach ($widgetsView as $value)
            {
                if ($rowKey != $value->getRow())
                {
                    $i = 1;
                }

                $row[$value->getRow()][ 'DT_RowId'] = $value->getRow();

                if ($value->getColumn() != $i)
                {

                    for ($j = $i; $j<$value->getColumn(); $j++)
                    {
                        $row[$value->getRow()][ $j] = [
                            'display' => null,
                            '_' => null
                        ];
                    }

                    $i++;
                    $rowKey = $value->getRow();
                    //                    continue;
                }

                if ($value->getColumn() == $i)
                {
                    $row[$value->getRow()][ $value->getColumn()] = [
                        'display' => is_null($value->getWidgetId()) ? null : $value->getWidgetInstance()->getWidget()->getName(),
                        '_' => $value->getWidgetId()
                    ];

                    $rowKey = $value->getRow();
                    $i++;
                    continue;
                }
            }
        }
        elseif ($device == 'mobile')
        {
            /** @var ModelWidgetViewMobile[] $widgetsView */
            $widgetsView = $pageWidgetPlace->getWidgetViewMobile([
                'order' => 'row, column'
            ]);

            $rowKey = null;
            $i=1;
            foreach ($widgetsView as $value)
            {
                if ($rowKey != $value->getRow())
                {
                    $i = 1;
                }

                $row[$value->getRow()][ 'DT_RowId'] = $value->getRow();

                if ($value->getColumn() != $i)
                {

                    for ($j = $i; $j<$value->getColumn(); $j++)
                    {
                        $row[$value->getRow()][ $j] = [
                            'display' => null,
                            '_' => null
                        ];
                    }

                    $i++;
                    $rowKey = $value->getRow();
//                    continue;
                }

                if ($value->getColumn() == $i)
                {
                    $row[$value->getRow()][ $value->getColumn()] = [
                        'display' => is_null($value->getWidgetId()) ? null : $value->getWidgetInstance()->getWidget()->getName(),
                        '_' => $value->getWidgetId()
                    ];

                    $rowKey = $value->getRow();
                    $i++;
                    continue;
                }
            }

        }
        else
        {
            dump('Exception !!!!');
        }

        return array_values($row);
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
    public function getPageId()
    {
        return $this->page_id;
    }

    /**
     * @param mixed $page_id
     */
    public function setPageId($page_id): void
    {
        $this->page_id = $page_id;
    }

    /**
     * @return mixed
     */
    public function getPlaceId()
    {
        return $this->place_id;
    }

    /**
     * @param mixed $place_id
     */
    public function setPlaceId($place_id): void
    {
        $this->place_id = $place_id;
    }
}