<?php
namespace Modules\System\Menu\Models\AdminMenuCategoryTitle;


use Modules\System\Menu\Models\AdminMenuCategory\ModelAdminMenuCategory;
use Modules\System\Native\Models\Language\ModelLanguage;

/**
 * @method ModelAdminMenuCategory getCategory()
 * @method ModelLanguage          getLanguage()
 */
trait TRelations
{
    protected function relations()
    {
        $this->belongsTo(
            'category_id',
            ModelAdminMenuCategory::class,
            'id',
            [
                'alias' => 'Category'
            ]
        );

        $this->belongsTo(
            'language_iso',
            ModelLanguage::class,
            'iso',
            [
                'alias' => 'Language'
            ]
        );
    }
}