<?php
namespace Modules\System\Menu\Controllers;

use Lib\Mvc\Controller;
use Lib\Translate\T;

class IndexController extends Controller
{
    public function indexAction()
    {
        dump(
            T::_('s_empty_table')
        );
    }
}