<?php
namespace Modules\System\PageManager\Models\Routes;


use Modules\System\Native\Models\Language\ModelLanguage;
use Modules\System\PageManager\DTE\Table\TablePageManager;
use Modules\System\PageManager\Models\Pages\ModelPages;

trait TModelRoutesQueries
{
    /**
     * Get array from pages in local language
     *
     * @uses TablePageManager
     * @param bool $local
     * @return array
     */
    public static function getPagesByLocal($local = true)
    {
        $params = [];
        if($local)
        {
            $params['conditions'] = 'language_iso=:lang:';
            $params['bind']['lang'] = ModelLanguage::getCurrentLanguage();
        }
        /** @var self[] $routes */
        $routes = self::find($params);

        $pages = [];
        foreach($routes as $route)
        {
            $row = [];
            /** @var ModelPages $page */
            foreach($route->getPages() as $page)
            {
                $row['DT_RowId'] = $page->getId();
                $row['route_title'] = $route->getTitle();
                $pages[] = array_merge($row,$page->toArray());
            }
        }

        return $pages;
    }

    /**
     * Route Exist In Current Language By Id
     *
     * @param int $id
     * @return bool
     */
    public static function routeExistInCurrentLanguageById($id)
    {
        if (!is_numeric($id))
            return false;

        $route = ModelRoutes::findFirst([
            'conditions' => 'id=:id: AND language_iso=:lang:',
            'bind' => [
                'id' => $id,
                'lang' => ModelLanguage::getCurrentLanguage()
            ]
        ]);

        if($route)
        {
            return true;
        }

        return false;
    }
}