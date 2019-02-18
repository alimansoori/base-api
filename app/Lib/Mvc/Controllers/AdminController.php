<?php
namespace Lib\Mvc\Controllers;

use Lib\Authenticates\Auth;
use Lib\Mvc\Controller;
use Lib\Mvc\Helper\Locale;
use Lib\Tag;
use Modules\System\Menu\Models\AdminMenu\ModelAdminMenu;
use Modules\System\Native\Models\Language\ModelLanguage;

/**
 * @property Auth $auth
 * @property Tag  tag
 */
class AdminController extends Controller
{
    public function initialize()
    {
        $this->tag->setTitle('داشبورد');
        $this->tag->setTitleSeparator('-');
        $this->setTemplate('dashboard');

        if (!$this->auth->isLoggedIn())
        {
//            $this->auth->logIn('admin', '123456789');
            $to = ltrim(
                $this->router->getRewriteUri(),
                '/'
            );

            $this->flash->notice('Log in please');
            $this->response->redirect('');
//            $this->response->redirect($this->url->get([
//                    'for' => 'login__'. ModelLanguage::getCurrentLanguage()
//                ]).'?to='. $to,
//                true
//                );
//            $this->response->send();
        }

        parent::initialize();

        $this->view->admin_menus = ModelAdminMenu::getAdminMenusForView();
    }

    public function setTemplate($theme)
    {
        $this->view->setMainView(THEME_PATH.$theme. '/theme');
        $this->view->setLayoutsDir(THEME_PATH.$theme. '/layouts/');
        $this->view->setLayout('main');
        $this->view->setPartialsDir(THEME_PATH.$theme. '/partials/');
    }

}