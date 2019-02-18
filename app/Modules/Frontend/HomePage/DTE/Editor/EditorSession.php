<?php

namespace Modules\Frontend\HomePage\DTE\Editor;


use Lib\DTE\Editor;
use Lib\DTE\Editor\Template\Fieldset;
use Modules\System\Native\Models\Language\ModelLanguage;
use Modules\System\Users\Models\ModelUsers;
use Modules\Frontend\HomePage\DTE\Editor\EditorSession\TEditorSession;

class EditorSession extends Editor
{
    use TEditorSession;

    private $ad_new = false;

    public function __construct($name, bool $ad_new = false)
    {
        parent::__construct($name);

        if ($ad_new)
            $this->ad_new = true;
    }

    public function init()
    {
        // On click button session
        $this->assetsManager->addInlineJsBottom( /** @lang JavaScript */
            "
    $('#ilya_btn_{$this->getName()}').on('click', function (e) {
        e.preventDefault();
        {$this->getName()}
            .title('ورود یا ثبت نام')
            .buttons('ثبت نام / ورود ')
            .edit();
    });
" );

    }


    public function initFields()
    {
        $signInFieldset   = new Fieldset( 'signin_fieldset', 'Already registered? Sign-in:' );
        $registerFieldset = new Fieldset( 'register_fieldset', 'Or create a DataTables account:' );
        $forgetFieldset   = new Fieldset( 'forget_fieldset', 'Request a new password:' );
        $forgetFieldset->setVisible(false);

        // SignIn fields
        $this->fieldSignInUsernameOrEmail( $signInFieldset );
        $this->fieldSignInPassword( $signInFieldset );

        // Register fields
        $this->fieldRegisterUsername( $registerFieldset );
        $this->fieldRegisterEmail( $registerFieldset );
        $this->fieldRegisterPassword( $registerFieldset );
        $this->fieldRegisterConfirmPassword( $registerFieldset );

        // SignIn fields
        $this->fieldForgetUsernameOrEmail( $forgetFieldset );

        $this->template->add( $signInFieldset );
        $this->template->add( $registerFieldset );
        $this->template->add( $forgetFieldset );
        $this->setOption( 'template', '#'.$this->template->getId() );
    }

    public function initAjax()
    {
        // TODO: Implement initAjax() method.
    }

    protected function beforeValidation($data)
    {
        // Login
        if(
            isset($data['signin_username_email']) &&
            isset($data['signin_password']) &&
            (
                !empty($data['signin_username_email']) ||
                !empty($data['signin_password'])
            )
        )
        {
            $this->removeField('register_username');
            $this->removeField('register_email');
            $this->removeField('register_password');
            $this->removeField('register_confirm_password');
            $this->removeField('forget_username_email');
        }
        // Register
        elseif(
            isset($data['register_username']) &&
            isset($data['register_email']) &&
            isset($data['register_password']) &&
            isset($data['register_confirm_password']) &&
            (
                !empty($data['register_username']) ||
                !empty($data['register_email']) ||
                !empty($data['register_password']) ||
                !empty($data['register_confirm_password'])
            )
        )
        {
            $this->removeField('signin_username_email');
            $this->removeField('signin_password');
            $this->removeField('forget_username_email');
        }
        // Forget
        elseif(
            isset($data['forget_username_email']) && !empty($data['forget_username_email'])
        )
        {
            $this->removeField('register_username');
            $this->removeField('register_email');
            $this->removeField('register_password');
            $this->removeField('register_confirm_password');
            $this->removeField('signin_username_email');
            $this->removeField('signin_password');
        }
    }

    public function createAction()
    {
        // TODO: Implement createAction() method.
    }

    public function editAction()
    {
        $data = $this->getDataAfterValidate()['keyless'];

        // Login
        if(
            isset($data['signin_username_email']) &&
            isset($data['signin_password']) &&
        (
            !empty($data['signin_username_email']) ||
            !empty($data['signin_password'])
        )
        )
        {
            $success = $this->auth->logIn(
                $data['signin_username_email'],
                $data['signin_password']
            );

            if($success)
            {
                if ($this->ad_new === true)
                {
                    $this->redirect = $this->url->get([
                        'for' => 'ad_new__'. ModelLanguage::getCurrentLanguage()
                    ]);
                }
                else
                {
                    $this->redirect = $this->url->get([
                        'for' => 'dashboard__'. ModelLanguage::getCurrentLanguage()
                    ]);
                }
            }
            else
            {
                $this->appendMessages($this->auth->getMessages());
            }
            return;
        }
        // Register
        elseif(
            isset($data['register_username']) &&
            isset($data['register_email']) &&
            isset($data['register_password']) &&
            isset($data['register_confirm_password']) &&
            (
                !empty($data['register_username']) ||
                !empty($data['register_email']) ||
                !empty($data['register_password']) ||
                !empty($data['register_confirm_password'])
            )
        )
        {
            /** @var ModelUsers $user */
            $user = $this->auth->createUser(
                $data['register_username'],
                $data['register_email'],
                $data['register_password']
            );

            if($user instanceof ModelUsers)
                $this->flash->success('Success Register');
            else
                $this->appendMessages($this->auth->getMessages());
        }
        // Forget
        elseif(
            isset($data['forget_username_email']) &&
            (
                !empty($data['forget_username_email'])
            )
        )
        {
            dump('forget');
        }
        else
        {
            $this->setError('Errorrrr !!!!!');
        }


    }

    public function removeAction()
    {
        // TODO: Implement removeAction() method.
    }

    public function render($type=null)
    {
        $out = parent::render();
        if ($this->ad_new === true)
        {
            if($this->auth->isLoggedIn())
            {
                $out .= "<a class='btn-simple btn--tertiary' href='{$this->url->get("ad/new")}'>درج رایگان آگهی</a>";
            }
            else
            {
                $out .= "<a class='btn-simple btn--tertiary' href='{$this->url->get("session")}' id='ilya_btn_{$this->getName()}'>درج رایگان آگهی</a>";
            }
        }
        else
        {
            if($this->auth->isLoggedIn())
            {
                $out .= "<a href='{$this->url->get("dashboard")}'>پروفایل من</a>";
            }
            else
            {
                $out .= "<a href='{$this->url->get("session")}' id='ilya_btn_{$this->getName()}'>پروفایل من</a>";
            }
        }

        $out .= $this->template->render();
        return $out;
    }
}