<?php

namespace Modules\System\Users\Table;


use Lib\DTE\Table;
use Modules\System\Users\Editor\CommonInformationEditor;
use Modules\System\Users\Editor\CompanyInformationEditor;
use Modules\System\Users\Editor\EducationalInformationEditor;
use Modules\System\Users\Editor\FurtherInformationEditor;
use Modules\System\Users\Editor\LoginInformationEditor;
use Modules\System\Users\Editor\PersonalInformationEditor;
use Modules\System\Users\Editor\SettingInformationEditor;
use Modules\System\Users\Models\ModelUsers;
use Modules\System\Users\Table\UsersTable\UsersTableButtons;
use Modules\System\Users\Table\UsersTable\UsersTableColumns;
use Lib\DTE\Table\Columns\Type\ColumnId;

class UsersTable extends Table
{
    use UsersTableColumns;
    use UsersTableButtons;

    public function init()
    {
        $this->addEditorsToTable();
        $this->addOption( 'responsive', true );
        $this->addOption( 'direction', 'rtl' );
        $this->setDom( "Brtip" );

        // add bootstrap
        $this->assetsCollection->addCss( 'assets/datatables.net-bs4/css/dataTables.bootstrap4.min.css' );
        $this->assetsManager->addJs( 'assets/datatables.net-bs4/js/dataTables.bootstrap4.min.js' );

        $this->initFiltering();

        $this->initInlineEditing();

//        $this->fixedColumns();
    }

    public function initButtons()
    {
        $this->btnCreateUser();
        $this->btnCollectionShowColumns();
        $this->btnCollectionEditButtons();
        $this->btnLinkToRoles();
    }

    public function initColumns()
    {
        $this->addColumn(new ColumnId());
        $this->columnUsername();
        $this->columnFirstName();
        $this->columnLastName();
        $this->columnEmail();
        $this->columnCreated();
        $this->columnCompanyName();
        $this->columnStatus();
        $this->columnTimeZone();
        $this->columnLanguage();
        $this->columnCompanyType();
        $this->columnCompanyEconomicCode();
        $this->columnCompanyNationalCode();
        $this->columnCompanyRegisterCode();
        $this->columnCompanyResponsibility();
        $this->columnCompanyPersonnelCode();
        $this->columnParentName();
        $this->columnIdNumber();
        $this->columnPlaceOfBirth();
        $this->columnGender();
        $this->columnDateOfBirth();
        $this->columnNationalCode();
        $this->columnMobile();
        $this->columnPhone();
        $this->columnFax();
        $this->columnState();
        $this->columnCity();
        $this->columnPostalCode();
        $this->columnAddress();
        $this->columnEducationalLevel();
        $this->columnEducationalField();
        $this->columnProfileUrl();
        $this->columnBlogAddress();
        $this->columnSignature();
        $this->columnFavorites();
        $this->columnAvatarAddress();
        $this->columnDescription();
    }

    public function initData()
    {
        $this->setData( ModelUsers::getUsersTableInformation() );
    }

    public function initAjax()
    {
        $this->ajax->addData('ali', "||$('input.global_filter').val();||");
    }

    public function render()
    {
        $output = /** @lang HTML */
            <<<TAG
<div class="j-wrapper j-wrapper-640">
    <form class="j-pro" id="j-pro" novalidate>
        <div class="j-content">
            <!-- start name -->
            <div class="j-unit">
                <div class="j-input">
                    <label class="j-icon-right" for="name">
                        <i class="icofont icofont-search"></i>
                    </label>
                    <input class="global_filter" type="text" placeholder="Search ... " name="name">
                </div>
            </div>
            <!-- start response from server -->
            <div class="j-response"></div>
            <!-- end response from server -->
        </div>
    </form>
</div>
TAG;
        $output .= parent::render();
        return $output;
    }

    private function addEditorsToTable()
    {
        $this->setEditor( new LoginInformationEditor( 'login_info_editor' ) );
        $this->setEditor( new CommonInformationEditor( 'common_info_editor' ) );
        $this->setEditor( new PersonalInformationEditor( 'personal_info_editor' ) );
        $this->setEditor( new CompanyInformationEditor( 'company_info_editor' ) );
        $this->setEditor( new SettingInformationEditor( 'setting_info_editor' ) );
        $this->setEditor( new FurtherInformationEditor( 'further_info_editor' ) );
        $this->setEditor( new EducationalInformationEditor( 'educational_info_editor' ) );
    }

    private function initFiltering()
    {
        $this->assetsManager->addInlineJsBottom( /** @lang JavaScript */
            <<<TAG
$('input.global_filter').on('keyup click', function() {
  {$this->getName()}.search($('input.global_filter').val()).draw();
});

TAG

);
    }

    private function initInlineEditing()
{
    $this->assetsManager->addInlineJsBottom( /** @lang JavaScript */
        "
{$this->getName()}.on('click', 'td.login-col i', function(e) {
  e.stopImmediatePropagation();
  {$this->getEditor('common_info_editor')->getName()}.bubble($(this).parent());
});
");
    $this->assetsManager->addInlineJsBottom( /** @lang JavaScript */
        "
{$this->getName()}.on('click', 'td.setting-col i', function(e) {
  e.stopImmediatePropagation();
  {$this->getEditor('setting_info_editor')->getName()}.bubble($(this).parent());
});
");
    $this->assetsManager->addInlineJsBottom( /** @lang JavaScript */
        "
{$this->getName()}.on('click', 'td.further-col i', function(e) {
  e.stopImmediatePropagation();
  {$this->getEditor('further_info_editor')->getName()}.bubble($(this).parent());
});
");
    $this->assetsManager->addInlineJsBottom( /** @lang JavaScript */
        "
{$this->getName()}.on('click', 'td.personal-col i', function(e) {
  e.stopImmediatePropagation();
  {$this->getEditor('personal_info_editor')->getName()}.bubble($(this).parent());
});
");
    $this->assetsManager->addInlineJsBottom( /** @lang JavaScript */
        "
{$this->getName()}.on('click', 'td.company-col i', function(e) {
  e.stopImmediatePropagation();
  {$this->getEditor('company_info_editor')->getName()}.bubble($(this).parent());
});
");
    $this->assetsManager->addInlineJsBottom( /** @lang JavaScript */
        "
{$this->getName()}.on('click', 'td.educational-col i', function(e) {
  e.stopImmediatePropagation();
  {$this->getEditor('educational_info_editor')->getName()}.bubble($(this).parent());
});
");
}

    private function fixedColumns()
    {
        $this->addOption('scrollY', '300px');
        $this->addOption('scrollX', true);
        $this->addOption('scrollCollapse', true);
        $this->addOption('paging', false);
        $this->addOption('fixedColumns', [
            'leftColumns' => 2
        ]);

        $this->assetsManager->addCss('assets/datatables.net-fixedcolumns-dt/css/fixedColumns.dataTables.min.css');
        $this->assetsManager->addJs('assets/datatables.net-fixedcolumns/js/dataTables.fixedColumns.min.js');

        $this->assetsCollection->addInlineCss(<<<TAG
th, td { white-space: nowrap; }
div.dataTables_wrapper {
    width: 100%;
    margin: 0 auto;
}
TAG
);
    }
}