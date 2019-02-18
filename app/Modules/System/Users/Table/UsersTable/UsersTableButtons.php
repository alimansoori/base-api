<?php
namespace Modules\System\Users\Table\UsersTable;


use Lib\DTE\Table\Buttons\ButtonLinkToSelected;
use Lib\DTE\Table\Buttons\Collection;
use Lib\DTE\Table\Buttons\ColumnVisibility\ColVisGroup;
use Lib\DTE\Table\Buttons\Editor\ButtonCreate;
use Lib\DTE\Table\Buttons\Editor\ButtonEdit;
use Lib\DTE\Table\Columns\Column;
use Lib\Translate\T;
use Modules\System\Native\Models\Language\ModelLanguage;

/**
 * @method Column getColumn()
 */
trait UsersTableButtons
{
    protected function btnLinkToRoles()
    {
        $btn = new ButtonLinkToSelected(
            'btn_link_to_roles',
            $this->url->get([
                'for' => 'user_roles__'. ModelLanguage::getCurrentLanguage()
            ])
        );
        $btn->setText(T::_('btn_link_to_roles'));

        $this->addButton($btn);
    }

    protected function btnCollectionEditButtons()
    {
        $btn = new Collection('btn_show_edit_buttons');
        $btn->setText(T::_('edit_user'));
        $btn->setTable($this);
        $btn->setAutoClose(true);

        $btn->addButton($this->btnLoginInformationEditor());
        $btn->addButton($this->btnPersonalInformationEditor());
        $btn->addButton($this->btnCompanyInformationEditor());
        $btn->addButton($this->btnSettingInformationEditor());
        $btn->addButton($this->btnEducationalInformationEditor());
        $btn->addButton($this->btnFurtherInformationEditor());

        $this->addButton($btn);
    }

    protected function btnCreateUser()
    {
        $btn = new ButtonCreate('btn_login_info_editor');
        $btn->setText(T::_('add_new_user'));
        $btn->setEditor($this->getEditor('login_info_editor'));

        $this->addButton($btn);
    }

    protected function btnLoginInformationEditor()
    {
        $btn = new ButtonEdit('btn_login_info_editor');
        $btn->setText(T::_('edit_login_info'));
        $btn->setEditor($this->getEditor('login_info_editor'));

        return $btn;
    }

    protected function btnPersonalInformationEditor()
    {
        $btn = new ButtonEdit('btn_personal_info_editor');
        $btn->setText(T::_('edit_personal_info'));
        $btn->setEditor($this->getEditor('personal_info_editor'));
        return $btn;
    }

    protected function btnCompanyInformationEditor()
    {
        $btn = new ButtonEdit('btn_company_info_editor');
        $btn->setText(T::_('edit_company_info'));
        $btn->setEditor($this->getEditor('company_info_editor'));
        return $btn;
    }

    protected function btnSettingInformationEditor()
    {
        $btn = new ButtonEdit('btn_setting_info_editor');
        $btn->setText(T::_('edit_setting_info'));
        $btn->setEditor($this->getEditor('setting_info_editor'));
        return $btn;
    }

    protected function btnEducationalInformationEditor()
    {
        $btn = new ButtonEdit('btn_educational_info_editor');
        $btn->setText(T::_('edit_educational_info'));
        $btn->setEditor($this->getEditor('educational_info_editor'));
        return $btn;
    }

    protected function btnFurtherInformationEditor()
    {
        $btn = new ButtonEdit('btn_further_info_editor');
        $btn->setText(T::_('edit_further_info'));
        $btn->setEditor($this->getEditor('further_info_editor'));
        return $btn;
    }

    protected function btnCollectionShowColumns()
    {
        $btn = new Collection('btn_show_collection_info');
        $btn->setText(T::_('show_collection_columns'));
        $btn->setTable($this);
        $btn->setAutoClose(true);

        $btn->addButton($this->btnShowCustomInfo());
        $btn->addButton($this->btnShowPersonalInfo());
        $btn->addButton($this->btnShowCompanyInfo());
        $btn->addButton($this->btnShowEducationalInfo());
        $btn->addButton($this->btnShowSettingInfo());
        $btn->addButton($this->btnShowFurtherInfo());

        $this->addButton($btn);
    }

    protected function btnShowPersonalInfo()
    {
        $btn = new ColVisGroup('btn_show_personal_info');
        $btn->setText(T::_('show_personal_info'));

        $btn->setShow([
            $this->getColumn('id')->getTarget(),
            $this->getColumn('username')->getTarget(),
            $this->getColumn('email')->getTarget(),
            $this->getColumn('first_name')->getTarget(),
            $this->getColumn('last_name')->getTarget(),
            $this->getColumn('parent_name')->getTarget(),
            $this->getColumn('id_number')->getTarget(),
            $this->getColumn('place_of_birth')->getTarget(),
            $this->getColumn('gender')->getTarget(),
            $this->getColumn('date_of_birth')->getTarget(),
            $this->getColumn('national_code')->getTarget(),
            $this->getColumn('mobile')->getTarget(),
            $this->getColumn('phone')->getTarget(),
            $this->getColumn('fax')->getTarget(),
            $this->getColumn('state')->getTarget(),
            $this->getColumn('city')->getTarget(),
            $this->getColumn('postal_code')->getTarget(),
            $this->getColumn('address')->getTarget(),
        ]);

        $btn->setHide([
            $this->getColumn('setting_time_zone')->getTarget(),
            $this->getColumn('setting_language')->getTarget(),
            $this->getColumn('company_name')->getTarget(),
            $this->getColumn('company_type')->getTarget(),
            $this->getColumn('company_economic_code')->getTarget(),
            $this->getColumn('company_national_code')->getTarget(),
            $this->getColumn('company_register_code')->getTarget(),
            $this->getColumn('company_responsibility')->getTarget(),
            $this->getColumn('company_personnel_code')->getTarget(),
            $this->getColumn('educational_level')->getTarget(),
            $this->getColumn('educational_field')->getTarget(),
            $this->getColumn('profile_url')->getTarget(),
            $this->getColumn('blog_address')->getTarget(),
            $this->getColumn('signature')->getTarget(),
            $this->getColumn('favorites')->getTarget(),
            $this->getColumn('avatar_address')->getTarget(),
            $this->getColumn('description')->getTarget(),
            $this->getColumn('created')->getTarget(),
            $this->getColumn('status')->getTarget(),
        ]);

        return $btn;
    }

    protected function btnShowCustomInfo()
    {
        $btn = new ColVisGroup('btn_show_custom_info');
        $btn->setText(T::_('show_custom_info'));

        $btn->setShow([
            $this->getColumn('id')->getTarget(),
            $this->getColumn('username')->getTarget(),
            $this->getColumn('email')->getTarget(),
            $this->getColumn('created')->getTarget(),
            $this->getColumn('first_name')->getTarget(),
            $this->getColumn('last_name')->getTarget(),
            $this->getColumn('company_name')->getTarget(),
            $this->getColumn('status')->getTarget(),
        ]);

        $btn->setHide([
            $this->getColumn('parent_name')->getTarget(),
            $this->getColumn('id_number')->getTarget(),
            $this->getColumn('place_of_birth')->getTarget(),
            $this->getColumn('gender')->getTarget(),
            $this->getColumn('date_of_birth')->getTarget(),
            $this->getColumn('national_code')->getTarget(),
            $this->getColumn('mobile')->getTarget(),
            $this->getColumn('phone')->getTarget(),
            $this->getColumn('fax')->getTarget(),
            $this->getColumn('state')->getTarget(),
            $this->getColumn('city')->getTarget(),
            $this->getColumn('postal_code')->getTarget(),
            $this->getColumn('address')->getTarget(),
            $this->getColumn('setting_time_zone')->getTarget(),
            $this->getColumn('setting_language')->getTarget(),
            $this->getColumn('company_type')->getTarget(),
            $this->getColumn('company_economic_code')->getTarget(),
            $this->getColumn('company_national_code')->getTarget(),
            $this->getColumn('company_register_code')->getTarget(),
            $this->getColumn('company_responsibility')->getTarget(),
            $this->getColumn('company_personnel_code')->getTarget(),
            $this->getColumn('educational_level')->getTarget(),
            $this->getColumn('educational_field')->getTarget(),
            $this->getColumn('profile_url')->getTarget(),
            $this->getColumn('blog_address')->getTarget(),
            $this->getColumn('signature')->getTarget(),
            $this->getColumn('favorites')->getTarget(),
            $this->getColumn('avatar_address')->getTarget(),
            $this->getColumn('description')->getTarget(),
        ]);

        return $btn;
    }

    protected function btnShowEducationalInfo()
    {
        $btn = new ColVisGroup('btn_show_educational_info');
        $btn->setText(T::_('show_educational_info'));

        $btn->setShow([
            $this->getColumn('id')->getTarget(),
            $this->getColumn('username')->getTarget(),
            $this->getColumn('educational_level')->getTarget(),
            $this->getColumn('educational_field')->getTarget(),
        ]);

        $btn->setHide([
            $this->getColumn('email')->getTarget(),
            $this->getColumn('created')->getTarget(),
            $this->getColumn('status')->getTarget(),
            $this->getColumn('first_name')->getTarget(),
            $this->getColumn('last_name')->getTarget(),
            $this->getColumn('parent_name')->getTarget(),
            $this->getColumn('id_number')->getTarget(),
            $this->getColumn('place_of_birth')->getTarget(),
            $this->getColumn('gender')->getTarget(),
            $this->getColumn('date_of_birth')->getTarget(),
            $this->getColumn('national_code')->getTarget(),
            $this->getColumn('mobile')->getTarget(),
            $this->getColumn('phone')->getTarget(),
            $this->getColumn('fax')->getTarget(),
            $this->getColumn('state')->getTarget(),
            $this->getColumn('city')->getTarget(),
            $this->getColumn('postal_code')->getTarget(),
            $this->getColumn('address')->getTarget(),
            $this->getColumn('setting_time_zone')->getTarget(),
            $this->getColumn('setting_language')->getTarget(),
            $this->getColumn('company_name')->getTarget(),
            $this->getColumn('company_type')->getTarget(),
            $this->getColumn('company_economic_code')->getTarget(),
            $this->getColumn('company_national_code')->getTarget(),
            $this->getColumn('company_register_code')->getTarget(),
            $this->getColumn('company_responsibility')->getTarget(),
            $this->getColumn('company_personnel_code')->getTarget(),
            $this->getColumn('profile_url')->getTarget(),
            $this->getColumn('blog_address')->getTarget(),
            $this->getColumn('signature')->getTarget(),
            $this->getColumn('favorites')->getTarget(),
            $this->getColumn('avatar_address')->getTarget(),
            $this->getColumn('description')->getTarget(),
        ]);

        return $btn;
    }

    protected function btnShowCompanyInfo()
    {
        $btn = new ColVisGroup('btn_show_company_info');
        $btn->setText(T::_('show_company_info'));

        $btn->setShow([
            $this->getColumn('id')->getTarget(),
            $this->getColumn('username')->getTarget(),
            $this->getColumn('company_name')->getTarget(),
            $this->getColumn('company_type')->getTarget(),
            $this->getColumn('company_economic_code')->getTarget(),
            $this->getColumn('company_national_code')->getTarget(),
            $this->getColumn('company_register_code')->getTarget(),
            $this->getColumn('company_responsibility')->getTarget(),
            $this->getColumn('company_personnel_code')->getTarget(),
        ]);

        $btn->setHide([
            $this->getColumn('educational_level')->getTarget(),
            $this->getColumn('educational_field')->getTarget(),
            $this->getColumn('email')->getTarget(),
            $this->getColumn('created')->getTarget(),
            $this->getColumn('status')->getTarget(),
            $this->getColumn('first_name')->getTarget(),
            $this->getColumn('last_name')->getTarget(),
            $this->getColumn('parent_name')->getTarget(),
            $this->getColumn('id_number')->getTarget(),
            $this->getColumn('place_of_birth')->getTarget(),
            $this->getColumn('gender')->getTarget(),
            $this->getColumn('date_of_birth')->getTarget(),
            $this->getColumn('national_code')->getTarget(),
            $this->getColumn('mobile')->getTarget(),
            $this->getColumn('phone')->getTarget(),
            $this->getColumn('fax')->getTarget(),
            $this->getColumn('state')->getTarget(),
            $this->getColumn('city')->getTarget(),
            $this->getColumn('postal_code')->getTarget(),
            $this->getColumn('address')->getTarget(),
            $this->getColumn('setting_time_zone')->getTarget(),
            $this->getColumn('setting_language')->getTarget(),
            $this->getColumn('profile_url')->getTarget(),
            $this->getColumn('blog_address')->getTarget(),
            $this->getColumn('signature')->getTarget(),
            $this->getColumn('favorites')->getTarget(),
            $this->getColumn('avatar_address')->getTarget(),
            $this->getColumn('description')->getTarget(),
        ]);

        return $btn;
    }

    protected function btnShowFurtherInfo()
    {
        $btn = new ColVisGroup('btn_show_further_info');
        $btn->setText(T::_('show_further_info'));

        $btn->setShow([
            $this->getColumn('id')->getTarget(),
            $this->getColumn('username')->getTarget(),
            $this->getColumn('profile_url')->getTarget(),
            $this->getColumn('blog_address')->getTarget(),
            $this->getColumn('signature')->getTarget(),
            $this->getColumn('favorites')->getTarget(),
            $this->getColumn('avatar_address')->getTarget(),
            $this->getColumn('description')->getTarget(),
        ]);

        $btn->setHide([
            $this->getColumn('company_name')->getTarget(),
            $this->getColumn('company_type')->getTarget(),
            $this->getColumn('company_economic_code')->getTarget(),
            $this->getColumn('company_national_code')->getTarget(),
            $this->getColumn('company_register_code')->getTarget(),
            $this->getColumn('company_responsibility')->getTarget(),
            $this->getColumn('company_personnel_code')->getTarget(),
            $this->getColumn('educational_level')->getTarget(),
            $this->getColumn('educational_field')->getTarget(),
            $this->getColumn('email')->getTarget(),
            $this->getColumn('created')->getTarget(),
            $this->getColumn('status')->getTarget(),
            $this->getColumn('first_name')->getTarget(),
            $this->getColumn('last_name')->getTarget(),
            $this->getColumn('parent_name')->getTarget(),
            $this->getColumn('id_number')->getTarget(),
            $this->getColumn('place_of_birth')->getTarget(),
            $this->getColumn('gender')->getTarget(),
            $this->getColumn('date_of_birth')->getTarget(),
            $this->getColumn('national_code')->getTarget(),
            $this->getColumn('mobile')->getTarget(),
            $this->getColumn('phone')->getTarget(),
            $this->getColumn('fax')->getTarget(),
            $this->getColumn('state')->getTarget(),
            $this->getColumn('city')->getTarget(),
            $this->getColumn('postal_code')->getTarget(),
            $this->getColumn('address')->getTarget(),
            $this->getColumn('setting_time_zone')->getTarget(),
            $this->getColumn('setting_language')->getTarget(),
        ]);

        return $btn;
    }

    protected function btnShowSettingInfo()
    {
        $btn = new ColVisGroup('btn_show_setting_info');
        $btn->setText(T::_('show_setting_info'));

        $btn->setShow([
            $this->getColumn('id')->getTarget(),
            $this->getColumn('username')->getTarget(),
            $this->getColumn('setting_time_zone')->getTarget(),
            $this->getColumn('setting_language')->getTarget(),
        ]);

        $btn->setHide([
            $this->getColumn('company_name')->getTarget(),
            $this->getColumn('company_type')->getTarget(),
            $this->getColumn('company_economic_code')->getTarget(),
            $this->getColumn('company_national_code')->getTarget(),
            $this->getColumn('company_register_code')->getTarget(),
            $this->getColumn('company_responsibility')->getTarget(),
            $this->getColumn('company_personnel_code')->getTarget(),
            $this->getColumn('educational_level')->getTarget(),
            $this->getColumn('educational_field')->getTarget(),
            $this->getColumn('email')->getTarget(),
            $this->getColumn('created')->getTarget(),
            $this->getColumn('status')->getTarget(),
            $this->getColumn('first_name')->getTarget(),
            $this->getColumn('last_name')->getTarget(),
            $this->getColumn('parent_name')->getTarget(),
            $this->getColumn('id_number')->getTarget(),
            $this->getColumn('place_of_birth')->getTarget(),
            $this->getColumn('gender')->getTarget(),
            $this->getColumn('date_of_birth')->getTarget(),
            $this->getColumn('national_code')->getTarget(),
            $this->getColumn('mobile')->getTarget(),
            $this->getColumn('phone')->getTarget(),
            $this->getColumn('fax')->getTarget(),
            $this->getColumn('state')->getTarget(),
            $this->getColumn('city')->getTarget(),
            $this->getColumn('postal_code')->getTarget(),
            $this->getColumn('address')->getTarget(),
            $this->getColumn('profile_url')->getTarget(),
            $this->getColumn('blog_address')->getTarget(),
            $this->getColumn('signature')->getTarget(),
            $this->getColumn('favorites')->getTarget(),
            $this->getColumn('avatar_address')->getTarget(),
            $this->getColumn('description')->getTarget(),
        ]);

        return $btn;
    }
}