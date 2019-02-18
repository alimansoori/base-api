<?php
namespace Modules\System\Menu\Models\AdminMenu;


use Lib\Common\Arrays;
use Lib\Mvc\Model;
use Modules\System\Menu\Models\AdminMenuRoles\ModelAdminMenuRoles;
use Modules\System\Menu\Models\ModelAdminMenuCategoryTranslate;
use Modules\System\Menu\Models\ModelAdminMenuTranslate;
use Modules\System\Native\Models\Language\ModelLanguage;
use Modules\System\Permission\Models\ModelRoles;
use Modules\System\Users\Models\ModelUsers;
use Phalcon\Di;

class ModelAdminMenu extends Model
{
    use Properties;
    use Relations;
    use Validations;
    use Events;

    public function init()
    {
        $this->setSource('admin_menu');
        $this->setDbRef(true);
    }

    public static function getTableInfo()
    {
        /** @var ModelAdminMenu[] $adminMenus */
        $adminMenus = ModelAdminMenu::find([
            'order' => 'category_id, position'
        ]);

        $data = [];
        foreach ($adminMenus as $adminMenu)
        {
            $data[] = self::getDataTable($adminMenu);
        }

        return Arrays::treeFlat($data);
    }

    public static function getDataTable(ModelAdminMenu $adminMenu)
    {
        $titleDisplay = 'Not set';
        $titleValue = null;
        /** @var ModelAdminMenuTranslate $translate */
        $translate = $adminMenu->getTranslates([
            'conditions' => 'language_iso=:lang:',
            'bind' => [
                'lang' => ModelLanguage::getCurrentLanguage()
            ]
        ])->getFirst();

        if ($translate)
        {
            $titleDisplay = $translate->getTitle();
            $titleValue = $translate->getTitle();
        }

        $categoryDisplay = null;
        if ($adminMenu->getCategory()->getTranslates())
        {
            /** @var ModelAdminMenuCategoryTranslate $categoryTranslate */
            $categoryTranslate = $adminMenu->getCategory()->getTranslates([
                'conditions' => 'language_iso=:lang:',
                'bind' => [
                    'lang' => ModelLanguage::getCurrentLanguage()
                ]
            ])->getFirst();

            $categoryDisplay = $categoryTranslate->getTitle();
        }

        $parentDisplay = null;
        $parentValue   = null;

        if ($adminMenu->getParentId())
        {
            if ($adminMenu->getParent()->getTranslates())
            {
                /** @var ModelAdminMenuTranslate $parentTranslate */
                $parentTranslate = $adminMenu->getParent()->getTranslates([
                    'conditions' => 'language_iso=:lang:',
                    'bind' => [
                        'lang' => ModelLanguage::getCurrentLanguage()
                    ]
                ])->getFirst();

                if ($parentTranslate)
                {
                    $parentDisplay = $parentTranslate->getTitle();
                    $parentValue = $adminMenu->getParentId();
                }
            }
        }


        return array_merge(
            $adminMenu->toArray(),
            [
                'DT_RowId' => $adminMenu->getId(),
                'link' => [
                    'display' => Di::getDefault()->get('url')->get($adminMenu->getLink()),
                    '_' => $adminMenu->getLink()
                ],
                'parent' => [
                    'display' => $parentDisplay,
                    '_' => $parentValue
                ],
                'title'    => [
                    'display' => $titleDisplay,
                    '_'       => $titleValue
                ],
                'category_id' => [
                    'display' => $categoryDisplay,
                    '_'       => $adminMenu->getCategoryId()
                ],
                'roles' => array_column($adminMenu->getRoles()->toArray(), 'id')
            ]
        );
    }

    public static function getAdminMenusForView()
    {
        /** @var ModelAdminMenu[] $adminMenus */
        $adminMenus = self::find([
            'order' => 'category_id, position'
        ]);

        $data = [];
        foreach ($adminMenus as $adminMenu)
        {
            /** @var ModelRoles $adminRole */
            foreach ($adminMenu->getRoles() as $adminRole)
            {
                foreach (ModelUsers::getUserRolesForAuth() as $userRole)
                {
                    if ($adminRole->getName() == $userRole )
                    {
                        $data[$adminMenu->getCategory()->getTranslates([
                            'conditions' => 'language_iso=:lang:',
                            'bind' => [
                                'lang' => ModelLanguage::getCurrentLanguage()
                            ]
                        ])->getFirst()->getTitle()][$adminMenu->getId()] = self::getDataTable($adminMenu);
                    }
                }
            }
        }

        $row = [];
        foreach ($data as $key => $datum)
        {
            $row[$key] = Arrays::tree($datum);
        }

        return $row;
    }
}