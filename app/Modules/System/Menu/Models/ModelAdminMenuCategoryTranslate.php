<?php
namespace Modules\System\Menu\Models;


use Lib\Mvc\Model;
use Modules\System\Menu\Models\AdminMenuCategoryTitle\Properties;
use Modules\System\Menu\Models\AdminMenuCategoryTitle\TEvents;
use Modules\System\Menu\Models\AdminMenuCategoryTitle\TRelations;
use Modules\System\Menu\Models\AdminMenuCategoryTitle\TValidations;

class ModelAdminMenuCategoryTranslate extends Model
{
    use Properties;
    use TValidations;
    use TEvents;
    use TRelations;

    protected function init()
    {
        $this->setSource('admin_menu_category_translate');
        $this->setDbRef(true);
    }
}