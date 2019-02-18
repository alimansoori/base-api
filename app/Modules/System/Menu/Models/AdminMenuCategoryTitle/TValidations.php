<?php
namespace Modules\System\Menu\Models\AdminMenuCategoryTitle;

use Lib\Validation;
use Modules\System\Menu\Models\AdminMenuCategory\ModelAdminMenuCategory;
use Modules\System\Native\Models\Language\ModelLanguage;
use Phalcon\Validation\Validator\InclusionIn;
use Phalcon\Validation\Validator\StringLength;
use Lib\Validation\Validator\UniquenessFor;

/**
 * @property Validation validator
 */
trait TValidations
{
    protected function mainValidation()
    {
        $this->validateTitle();
        $this->validateCategoryId();
        $this->validateLanguageIso();
    }

    private function validateTitle()
    {
        $this->validator->add(
            'title',
            new StringLength([
                'max' => 50
            ])
        );
    }

    private function validateCategoryId()
    {
        $this->validator->add(
            'category_id',
            new InclusionIn([
                'domain' => ModelAdminMenuCategory::getCategoriesById()
            ])
        );

        $this->validator->add(
            'category_id',
            new UniquenessFor([
                'model' => $this,
                'fields' => [
                    'language_iso'
                ]
            ])
        );
    }

    private function validateLanguageIso()
    {
        $this->validator->add(
            'language_iso',
            new InclusionIn([
                'domain' => ModelLanguage::getLanguages()
            ])
        );
    }
}