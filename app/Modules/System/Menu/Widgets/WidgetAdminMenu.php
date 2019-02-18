<?php
namespace Modules\System\Menu\Widgets;

use Lib\Contents\ContentBuilder;
use Modules\System\PageManager\Models\WidgetInstance\ModelWidgetInstance;
use Modules\System\Users\Models\ModelUsers;
use Lib\Widget\WidgetAbstract;
use Modules\System\Menu\Models\AdminMenu\ModelAdminMenu;
use Modules\System\Menu\Models\AdminMenuCategory\ModelAdminMenuCategory;
use Modules\System\Native\Models\Language\ModelLanguage;

class WidgetAdminMenu extends WidgetAbstract
{
    /** @var ContentBuilder $content */
    private $content;
    private $params;

    /**
     * @see http://multi-level-push-menu.make.rs/
     * @param ModelWidgetInstance $widgetInstance
     * @param array $params
     * @return array
     * @throws \ReflectionException
     */
    public function initialize(ModelWidgetInstance $widgetInstance, $params = [])
    {
        $this->params = $params;
        $this->content = ContentBuilder::instantiate();

        $this->addAssets();

        return [
            'menu_list' => $this->getMenus(),
            'params' => $params,
        ];
    }

    private function addAssets()
    {
        $this->assetsWidgets->addCss('ilya-theme/base/assets/multi-level-menu/jquery.multilevelpushmenu.css');
        $this->assetsWidgets->addJs("ilya-theme/base/assets/multi-level-menu/jquery.multilevelpushmenu.min.js");
    }

    private function options($id)
    {
        $options = [
            'container' => "||$( '#menu-push-{$id}' )||",
            'mode' => 'cover',
            'menuWidth' => '100%',
            'onItemClick' => "||function() {var event = arguments[0], item = arguments[2]; var itemHref = item.find( 'a:first' ).attr( 'href' ); location.href = itemHref;}||"
        ];

        if($this->helper->isRTL())
        {
            $options['direction'] = 'rtl';
            $options['backItemIcon'] = 'fa fa-angle-left';
            $options['groupIcon'] = 'fa fa-angle-right';
        }

        $options = json_encode($options);
        $options = str_replace('"||', '', $options);
        $options = str_replace('||"', '', $options);

        return $options;
    }

    private function getMenu()
    {
        $row = [];

        $roles = ModelUsers::getUserRolesForAuth();

        foreach(ModelAdminMenu::find([
            'order' => 'position'
        ]) as $key=>$value)
        {
            foreach($value->getRoles() as $role)
            {
                foreach($roles as $roleUser)
                {
                    if($role->name === $roleUser)
                    {
                        $row[] = $value->toArray();
                        break;
                    }
                }
            }
        }

        return $row;
    }

    private function getMenus()
    {
        $result = [];

        $roles = ModelUsers::getUserRolesForAuth();

        foreach(ModelAdminMenuCategory::find([
            'order' => 'position'
        ]) as $keyCat=>$cat)
        {
            $storeAdminMenu = [];

            /** @var ModelAdminMenu $adminMenu */
            foreach($cat->getAdminMenus() as $adminMenu)
            {
                if(!empty($adminMenu->getRoles()->toArray()))
                {
                    foreach($roles as $role)
                    {
                        if(in_array($role, array_column($adminMenu->getRoles()->toArray(), 'name')))
                        {
                            if($this->helper->locale()->getLanguage() == ModelLanguage::getMainLanguage())
                            {
                                $adminMenu->link = $this->url->get(ltrim($adminMenu->link, '/'));
                            }
                            else
                            {
                                $adminMenu->link = $this->url->get(
                                    $this->helper->locale()->getLanguage().
                                    '/'.
                                    ltrim($adminMenu->link, '/')
                                );
                            }

                            $storeAdminMenu[] = $adminMenu->toArray();
                        }
                    }
                }
            }
            $result[$cat->title] = $this->printListRecursive($storeAdminMenu);

            if(!empty($storeAdminMenu))
            {
                $this->assetsWidgets->addInlineJs( /** @lang JavaScript */
                    "
$(document).ready(function(){
    // HTML markup implementation, overlap mode
    $( '#menu-push-{$cat->title}' ).multilevelpushmenu({$this->options($cat->title)});
});
");
            }
        }

        return $result;
    }

    private function printListRecursive($list,$parent=null, $res='')
    {
        $child = 0;
        $foundSome = false;
        foreach($list as $item){
            if( $item['parent_id']==$parent ){
                $child++;
                if( $foundSome==false ){
                    $res .= '<ul>';
                    $foundSome = true;
                }
                $res .= '<li>';
                $res .= "<a href='{$item['link']}'><i class='fa {$item['icon']}'></i>{$item['title']}</a>";

                $row = $this->printListRecursive($list,$item['id'], $res);

                $res = $row['res'];
                if($row['child'])
                {
                    $res .= "<h2><i class='fa {$item['icon']}'></i>{$item['title']}</h2>";
                }

                $res .= '</li>';
            }
        }
        if( $foundSome ){
            $res .= '</ul>';
        }
        $result = [
            'res' => $res,
            'child' => $child
        ];

        return $result;
    }

    public static function setting(ModelWidgetInstance $widgetInstance)
    {
        // TODO: Implement setting() method.
    }
}