<?php
namespace Modules\System\Menu\Models\AdminMenuCategory;


use Modules\System\Menu\Models\AdminMenu\ModelAdminMenu;
use Modules\System\Menu\Models\ModelAdminMenuCategoryTranslate;
use Modules\System\Native\Models\Language\ModelLanguage;

/**
 * @property ModelAdminMenu[] adminMenus
 * @method   ModelAdminMenu[] getAdminMenus()
 * @method   ModelAdminMenuCategoryTranslate[] getTranslates()
 * @property ModelLanguage language
 * @method   ModelLanguage getLanguage()
 */
trait Relations
{
    public function relations()
    {
        $this->hasMany(
            'id',
            ModelAdminMenu::class,
            'category_id',
            [
                'alias' => 'AdminMenus',
                'foreignKey' => [
                    'message' => 'The manage cannot be deleted because admin menu model are using it',
                ]
            ]
        );

        $this->hasMany(
            'id',
            ModelAdminMenuCategoryTranslate::class,
            'category_id',
            [
                'alias' => 'Translates',
                'foreignKey' => [
                    'message' => 'This language does not exist in modelLanguage'
                ]
            ]
        );
    }
}