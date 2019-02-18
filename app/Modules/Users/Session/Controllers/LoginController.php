<?php
namespace Modules\Users\Session\Controllers;

use Lib\Exception;
use Lib\Mvc\Controller;
use Lib\Translate\T;

class LoginController extends Controller
{
    public function indexAction()
    {
        $res = [];

        try {
            if ($this->auth->isLoggedIn())
            {
                throw new Exception(
                    T::_('قبلا به سیستم وارد شده اید.'),
                    401
                );
            }

            $emailOrUsername = null;
            if($this->request->getPost('username_email')) $emailOrUsername = $this->request->getPost('username_email');
            else {
                $res['fieldsError']['username_email'] = [
                    'field' => 'username_email',
                    'status' => 'نام کاربری و یا ایمیل ضروری است.',
                ];

                throw new Exception(
                    T::_('نام کاربری و یا ایمیل ضروری است.'),
                    401
                );
            }

            if(!$this->request->getPost('password'))
            {
                throw new Exception(
                    T::_('پسورد مورد نیاز است.'),
                    401
                );
            }

            $password = $this->request->getPost('password');

            if (!$this->auth->logIn($emailOrUsername, $password))
            {
                throw new Exception(
                    T::_('ورود ناموفق'),
                    401
                );
            }

            $res['token'] = [
                'access_token' => $this->auth->getToken(),
                'expires_in' => 15*60,
                'token_type' => 'bearer'
            ];

            $this->response->setStatusCode(200);
            $res['status'] = $this->response->getStatusCode();
            $res['result'] = true;
            $res['message'] = 'Success';
        } catch (Exception $exception) {
            $this->response->setStatusCode($exception->getCode());
            $res['status'] = $exception->getCode();
            $res['message'] = $exception->getMessage();
        }

        $this->response->setJsonContent($res);
    }
}