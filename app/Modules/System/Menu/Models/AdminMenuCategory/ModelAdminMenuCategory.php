<?php
namespace Modules\System\Menu\Models\AdminMenuCategory;

use Lib\Mvc\Model;
use Modules\System\Menu\Models\AdminMenu\ModelAdminMenu;
use Modules\System\Menu\Models\ModelAdminMenuCategoryTranslate;
use Modules\System\Native\Models\Language\ModelLanguage;

class ModelAdminMenuCategory extends Model
{
    use Properties;
    use Relations;
    use Events;
    use Validations;

    public function init()
    {
        $this->setDbRef(true);
        $this->setSource('admin_menu_category');
    }

    /**
 * get all manage key=id And value=title by local
 *
 * @param bool $local
 * @return array
 */
    public static function getColumnsIDToTitle($local = true)
    {
        $parameters = [];
        $parameters['columns'] = 'id, title';
        $parameters['order'] = 'position ASC';

        if($local)
        {
            $parameters['conditions'] = 'language=:lang:';
            $parameters['bind']['lang'] = ModelLanguage::getCurrentLanguage();
        }

        return array_column(
            self::find($parameters)->toArray(),
            'title',
            'id'
        );
    }

    /**
     * get all manage value=id by local
     *
     * @param bool $local
     * @return array
     */
    public static function getColumnsID($local = true)
    {
        $parameters = [];
        $parameters['columns'] = 'id';

        if($local)
        {
            $parameters['conditions'] = 'language=:lang:';
            $parameters['bind']['lang'] = ModelLanguage::getCurrentLanguage();
        }

        return array_column(
            self::find($parameters)->toArray(),
            'id'
        );
    }

    public static function getAllAdminMenusForDT($local=true, $idFromParent = null)
    {
        $result = [];
        $param = [];
        if($local)
        {
            $param['conditions'] = 'language=:lang:';
            $param['bind']['lang'] = ModelLanguage::getCurrentLanguage();
        }

        if($idFromParent)
        {
            $param['conditions'] .= " AND id=:id:";
            $param['bind']['id'] = $idFromParent;

            $category = self::findFirst($param);

            if(!$category)
                return [];

            /** @var ModelAdminMenu[]|[] $adminMenus */
            $adminMenus = $category->getAdminMenus([
                'order' => 'position, parent_id'
            ]);

            foreach($adminMenus as $adminMenu)
            {
                $row = [];
                $row['DT_RowId'] = 'row_'. $adminMenu->id;
                $row['parent_title'] = @$adminMenu->getParent()->title;
                $row['category_title'] = $category->getTitle();
                $row['manage'] = $adminMenu->getAdminMenuCategoryId();

                $result[] = array_merge($adminMenu->toArray(), $row);
            }
        }
        else
        {
            $categories = self::find($param);

            /** @var self $category */
            foreach($categories as $category)
            {
                /** @var ModelAdminMenu[]|[] $adminMenus */
                $adminMenus = $category->getAdminMenus([
                    'order' => 'position, parent_id'
                ]);

                foreach($adminMenus as $adminMenu)
                {
                    $row = [];
                    $row['DT_RowId'] = 'row_'. $adminMenu->getId();
                    $row['parent_title'] = @$adminMenu->getParent()->title;
                    $row['category_title'] = $category->getTitle();
                    $row['manage'] = $adminMenu->getCategoryId();

                    $result[] = array_merge($adminMenu->toArray(), $row);
                }

            }
        }

        return $result;
    }

    public static function getCategories($local=true)
    {
        $result = [];
        $param = [];
        if($local)
        {
            $param['conditions'] = 'language=:lang:';
            $param['bind']['lang'] = ModelLanguage::getCurrentLanguage();
        }

        $categories = self::find($param);

        /** @var self $category */
        foreach($categories as $category)
        {
            $row = [];
            $row['DT_RowId'] = 'row_'. $category->id;

            $result[] = array_merge($category->toArray(), $row);

        }

        return $result;
    }

    /**
     * @return array
     * <code>
     *  value is id
     *  array(
     *      0 => 5,
     *      1 => 6,
     *      2 => 7
     * )
     * </code>
     */
    public static function getCategoriesById()
    {
        return array_column(
            self::find(['columns' => 'id'])->toArray(),
            'id'
        );
    }

    public static function getTableInfo()
    {
        /** @var ModelAdminMenuCategory[] $categories */
        $categories = self::find([
            'order' => 'position'
        ]);

        $data = [];

        foreach ($categories as $category)
        {
            $data[] = self::getDataTable($category);
        }

        return $data;
    }

    public static function getDataTable(ModelAdminMenuCategory $category)
    {
        $dis_title = 'not set';

        if ($category->getTranslates())
        {
            /** @var ModelAdminMenuCategoryTranslate $title */
            $title = $category->getTranslates([
                'conditions' => 'language_iso=:lang:',
                'bind' => [
                    'lang' => ModelLanguage::getCurrentLanguage()
                ]
            ])->getFirst();

            if ($title)
            {
                $dis_title = $title->getTitle();
            }
        }
        return array_merge(
            $category->toArray(),
            [
                'DT_RowId' => $category->getId(),
                'title' => $dis_title
            ]
        );
    }

}