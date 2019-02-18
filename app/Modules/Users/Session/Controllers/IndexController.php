<?php
namespace Modules\Users\Session\Controllers;

use Lib\Authenticates\Auth;
use Lib\Authenticates\IAuth;
use Lib\Contents\Classes\DTE;
use Lib\Mvc\Controllers\AdminController;
use Lib\Mvc\Helper;
use Modules\Users\Session\DataTable\Editor;
use Modules\Users\Session\DataTable\Table;
use Modules\Users\Session\Forms\LoginForm;
use Modules\Users\Session\Forms\RegisterForm;
use Phalcon\Mvc\Controller;

/**
 * @property Helper $helper
 * @property IAuth $auth
 */
class IndexController extends Controller
{
    public function testAction()
    {
//        $this->content->setTemplate('role_table');
//        $this->content->theme->viewMasterPage();
//        $dte = new DTE(new Editor('editor'), new Table('table'), 'dte');
//
//        $this->view->dte = $dte;
    }

    public function indexAction()
    {
//        dump(
//            $this->auth->getUser()
//        );
        $login = $this->auth->logIn(
            'alimatin',
            '123456789'
        );

        if($login)
        {
            dump('login success');
        }

        dump('faild');


        // Check user is logged in
        if ($this->auth->isLoggedIn())
        {
            $this->response->redirect('');
        }

        $content = $this->helper->content();
        $content->setTemplate('session-template', 'Session Template');

        $loginForm = $content->addFormWide(new LoginForm());
        $signupForm = $content->addFormTall(new RegisterForm());

        $content->getTheme()->noLeftMasterPage();
//        $content->getTheme()->noRightMasterPage();
//        $content->getTheme()->noLeftRightMasterPage();
//        $content->getTheme()->viewMasterPage();

        if($loginForm->isValid())
        {
            try
            {
                $this->auth->check();
            }
            catch( \Exception $e )
            {
                $this->flash->success($e->getMessage());
            }
        }

        if($signupForm->isValid())
        {
            $user = new Users(
                [
                    'username' => $this->request->getPost('username', 'striptags'),
                    'email'    => $this->request->getPost('email', [
                        'striptags',
                        'email'
                    ]),
                    'password' => $this->request->getPost('password'),
                    'active'   => true
                ]
            );

            if ($user->save())
            {
                $this->flash->success('Success save');
            }
            else
            {
                foreach ($user->getMessages() as $message)
                {
                    $this->flash->error($message);
                }
            }
        }

        $content->create();
    }
}