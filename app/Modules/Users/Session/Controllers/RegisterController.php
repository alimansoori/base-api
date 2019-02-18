<?php
namespace Modules\Users\Session\Controllers;

use Lib\Exception;
use Lib\Mvc\Controller;
use Lib\Mvc\Model\ModelUsers;
use Lib\Translate\T;

class RegisterController extends Controller
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
            if($this->request->getPost('username')) $emailOrUsername = $this->request->getPost('username');
            elseif($this->request->getPost('email')) $emailOrUsername = $this->request->getPost('email');
            else {
                $res['fieldsError']['username'] = [
                    'field' => 'username',
                    'status' => 'نام کاربری ضروری است.',
                ];
                $res['fieldsError']['email'] = [
                    'field' => 'email',
                    'status' => 'ایمیل ضروری است.',
                ];

                throw new Exception(
                    T::_('نام کاربری و ایمیل ضروری است.'),
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

            $username = $this->request->getPost('usename');
            $email = $this->request->getPost('email');
            $password = $this->request->getPost('password');

            if (!ModelUsers::createUser($username, $email, $password))
            {
                throw new Exception(
                    T::_('ثبت نام ناموفق'),
                    401
                );
            }

            $this->response->setStatusCode(200);
            $res['status'] = $this->response->getStatusCode();
            $res['message'] = 'Success';
        } catch (Exception $exception) {
            $this->response->setStatusCode($exception->getCode());
            $res['status'] = $exception->getCode();
            $res['message'] = $exception->getMessage();
        }

        $this->response->setJsonContent($res);
    }
}