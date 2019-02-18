<?php
namespace Modules\Frontend\HomePage\DTE\Editor\EditorSession;


use Lib\DTE\Editor\Fields\Type\Password;
use Lib\DTE\Editor\Fields\Type\Text;
use Lib\DTE\Editor\Template\Fieldset;
use Phalcon\Validation\Validator\Confirmation;
use Phalcon\Validation\Validator\Email;
use Phalcon\Validation\Validator\PresenceOf;
use Phalcon\Validation\Validator\StringLength;

trait TEditorSession
{
    protected function fieldSignInUsernameOrEmail(Fieldset $fieldset)
    {
        $username = new Text('signin_username_email');
        $username->setLabel('Email or Username');
        $username->setAttr([
            'placeholder' => 'please type username or email'
        ]);

        $username->addValidators([
            new PresenceOf(['cancelOnFail'=>true])
        ]);

        $this->addField($username);
        $fieldset->add($username);

        // clear another fields
        $this->assetsManager->addInlineJsBottom( /** @lang JavaScript */
            <<<TAG
$( {$this->getName()}.field( 'signin_username_email' ).input() ).on( 'keyup', function (e, d) {
    {$this->getName()}.field( 'register_username' ).val('');
    {$this->getName()}.field( 'register_email' ).val('');
    {$this->getName()}.field( 'register_password' ).val('');
    {$this->getName()}.field( 'register_confirm_password' ).val('');
    {$this->getName()}.field( 'forget_username_email' ).val('');
} );
TAG
);
    }

    protected function fieldSignInPassword(Fieldset $fieldset)
    {
        $password = new Password('signin_password');
        $password->setLabel('Password');
        $password->setAttr([
            'placeholder' => 'please type password'
        ]);
        $password->setFieldInfo('<a id="forget_field_info" href="#">Forget ?</a>');

        $password->addValidators([
            new PresenceOf([
                'cancelOnFail'
            ]),
            new StringLength([
                'min' => 6
            ])
        ]);

        $this->addField($password);
        $fieldset->add($password);

        $this->assetsManager->addInlineJsBottom( /** @lang JavaScript */
            "
$('body').on('click', '#forget_field_info', function(e) {
    e.preventDefault(true);
    
    $('#signin_fieldset').hide();
    $('#register_fieldset').hide();
    $('#forget_fieldset').show();
});
");

        // clear another fields
        $this->assetsManager->addInlineJsBottom( /** @lang JavaScript */
            <<<TAG
$( {$this->getName()}.field( 'signin_password' ).input() ).on( 'keyup', function (e, d) {
    {$this->getName()}.field( 'register_username' ).val('');
    {$this->getName()}.field( 'register_email' ).val('');
    {$this->getName()}.field( 'register_password' ).val('');
    {$this->getName()}.field( 'register_confirm_password' ).val('');
    {$this->getName()}.field( 'forget_username_email' ).val('');
} );
TAG
        );
    }

    protected function fieldRegisterUsername(Fieldset $fieldset)
    {
        $username = new Text('register_username');
        $username->setLabel('Username');
        $username->setAttr([
            'placeholder' => 'please type username'
        ]);

        $username->addValidators([
            new PresenceOf(['cancelOnFail'=>true])
        ]);

        $this->addField($username);
        $fieldset->add($username);

        // clear another fields
        $this->assetsManager->addInlineJsBottom( /** @lang JavaScript */
            <<<TAG
$( {$this->getName()}.field( 'register_username' ).input() ).on( 'keyup', function (e, d) {
    {$this->getName()}.field( 'signin_username_email' ).val('');
    {$this->getName()}.field( 'signin_password' ).val('');
    {$this->getName()}.field( 'forget_username_email' ).val('');
} );
TAG
        );
    }

    protected function fieldRegisterEmail(Fieldset $fieldset)
    {
        $email = new Text('register_email');
        $email->setLabel('Email');
        $email->setAttr([
            'placeholder' => 'please type email'
        ]);

        $email->addValidators([
            new PresenceOf(['cancelOnFail' => true]),
            new Email()
        ]);

        $this->addField($email);
        $fieldset->add($email);

        // clear another fields
        $this->assetsManager->addInlineJsBottom( /** @lang JavaScript */
            <<<TAG
$( {$this->getName()}.field( 'register_email' ).input() ).on( 'keyup', function (e, d) {
    {$this->getName()}.field( 'signin_username_email' ).val('');
    {$this->getName()}.field( 'signin_password' ).val('');
    {$this->getName()}.field( 'forget_username_email' ).val('');
} );
TAG
        );
    }

    protected function fieldRegisterPassword(Fieldset $fieldset)
    {
        $password = new Password('register_password');
        $password->setLabel('Password');
        $password->setAttr([
            'placeholder' => 'please type password'
        ]);
        $password->addValidators([
            new PresenceOf([
                'cancelOnFail' => true
            ]),
            new Confirmation([
                'with' => 'register_confirm_password'
            ])
        ]);

        $this->addField($password);
        $fieldset->add($password);

        // clear another fields
        $this->assetsManager->addInlineJsBottom( /** @lang JavaScript */
            <<<TAG
$( {$this->getName()}.field( 'register_password' ).input() ).on( 'keyup', function (e, d) {
    {$this->getName()}.field( 'signin_username_email' ).val('');
    {$this->getName()}.field( 'signin_password' ).val('');
    {$this->getName()}.field( 'forget_username_email' ).val('');
} );
TAG
        );
    }

    protected function fieldRegisterConfirmPassword(Fieldset $fieldset)
    {
        $confirmPassword = new Password('register_confirm_password');
        $confirmPassword->setLabel('Confirm Password');
        $confirmPassword->setAttr([
            'placeholder' => 'please type confirm password'
        ]);

        $this->addField($confirmPassword);
        $fieldset->add($confirmPassword);

        // clear another fields
        $this->assetsManager->addInlineJsBottom( /** @lang JavaScript */
            <<<TAG
$( {$this->getName()}.field( 'register_confirm_password' ).input() ).on( 'keyup', function (e, d) {
    {$this->getName()}.field( 'signin_username_email' ).val('');
    {$this->getName()}.field( 'signin_password' ).val('');
    {$this->getName()}.field( 'forget_username_email' ).val('');
} );
TAG
        );
    }

    protected function fieldForgetUsernameOrEmail(Fieldset $fieldset)
    {
        $emailOrUsername = new Text('forget_username_email');
        $emailOrUsername->setLabel('Email or username');
        $emailOrUsername->setAttr([
            'placeholder' => 'please type email or username'
        ]);
        $emailOrUsername->setFieldInfo('<a id="remember_field_info" href="#">I remember now!</a>');

        $this->addField($emailOrUsername);
        $fieldset->add($emailOrUsername);

        $this->assetsManager->addInlineJsBottom( /** @lang JavaScript */
            "
$('body').on('click', '#remember_field_info', function(e) {
    e.preventDefault(true);
    
    $('#signin_fieldset').show();
    $('#register_fieldset').show();
    $('#forget_fieldset').hide();
});
");

        // clear another fields
        $this->assetsManager->addInlineJsBottom( /** @lang JavaScript */
            <<<TAG
$( {$this->getName()}.field( 'forget_username_email' ).input() ).on( 'keyup', function (e, d) {
    {$this->getName()}.field( 'signin_username_email' ).val('');
    {$this->getName()}.field( 'signin_password' ).val('');
    {$this->getName()}.field( 'register_confirm_password' ).val('');
    {$this->getName()}.field( 'register_password' ).val('');
    {$this->getName()}.field( 'register_username' ).val('');
    {$this->getName()}.field( 'register_email' ).val('');
} );
TAG
        );
    }
}