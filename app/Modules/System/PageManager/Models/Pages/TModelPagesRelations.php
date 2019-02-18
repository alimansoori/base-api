<?php
namespace Modules\System\PageManager\Models\Pages;


use Modules\System\PageManager\Models\WidgetInstance\ModelWidgetInstance;
use Modules\System\Users\Models\ModelUsers;
use Modules\System\PageManager\Models\PageDesign\ModelPageDesign;

/**
 * @property ModelPages             parent
 * @property ModelPages[]           child
 * @method  ModelPages              getParent()
 * @method  ModelPages[]            getChild()
 * @method  ModelUsers              getCreator()
 */
trait TModelPagesRelations
{
    protected function relations()
    {

        $this->belongsTo(
            'parent_id',
            self::class,
            'id',
            [
                'alias' => 'Parent',
                'foreignKey' => [
                    'allowNulls' => true,
                    'message' => 'The parent_id does not exist in Pages model'
                ]
            ]
        );

        $this->hasMany(
            'id',
            self::class,
            'parent_id',
            [
                'alias' => 'Child',
                'foreignKey' => [
                    'message' => 'The Page could not be delete because other Pages are using it'
                ]
            ]
        );

//        $this->hasMany(
//            'id',
//            ModelWidgetInstance::class,
//            'page_id',
//            [
//                'alias' => 'PageWidgets',
//                'foreignKey' => [
//                    'message' => 'The Page could not be delete because Widgets model are using it'
//                ]
//            ]
//        );

        $this->belongsTo(
            'creator_id',
            ModelUsers::class,
            'id',
            [
                'alias' => 'Creator',
                'foreignKey' => [
                    'message' => 'The creator_id does not exist in ModelUsers'
                ]
            ]
        );
    }

}