<?php
namespace Modules\PageManager\Backend\Models\Resources;


use Modules\PageManager\Backend\Models\ModelCategoryResources;
use Modules\PageManager\Backend\Models\ModelResources;
use Modules\System\Users\Models\ModelUsers;

/**
 * @property ModelResources           parent
 * @property ModelResources[]           child
 * @method   ModelResources             getParent()
 * @method   ModelCategoryResources     getCategory()
 * @method   ModelResources[]           getChild()
 * @method   ModelUsers                 getCreator()
 */
trait TModelPagesRelations
{
    protected function relations()
    {
        $this->belongsTo(
            'category_id',
            ModelCategoryResources::class,
            'id',
            [
                'alias' => 'Category',
                'foreignKey' => [
                    'message' => 'دسته بندی انتخاب شده شما، وجود ندارد'
                ]
            ]
        );

        $this->belongsTo(
            'parent_id',
            self::class,
            'id',
            [
                'alias' => 'Parent',
                'foreignKey' => [
                    'allowNulls' => true,
                    'message' => 'پدر موردنظر وجود ندارد'
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