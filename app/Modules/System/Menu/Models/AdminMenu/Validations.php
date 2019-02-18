<?php
namespace Modules\System\Menu\Models\AdminMenu;


use Lib\Validation;
use Modules\System\Menu\Models\AdminMenuCategory\ModelAdminMenuCategory;
use Phalcon\Validation\Validator\InclusionIn;
use Phalcon\Validation\Validator\Numericality;
use Phalcon\Validation\Validator\StringLength;

/**
 * @property Validation validator
 */
trait Validations
{
    public function mainValidation()
    {
        $this->parentIdValidation();
        $this->categoryIdValidation();
        $this->linkValidation();
        $this->iconValidation();
        $this->positionValidation();
    }

    private function linkValidation()
    {
        $this->validator->add(
            'link',
            new StringLength([
                'max' => 200
            ])
        );
    }

    private function parentIdValidation()
    {
        $this->validator->add(
            'parent_id',
            new InclusionIn([
                'domain' => array_merge(
                    array_column(
                        self::find([
                            'columns' => 'id',
                        ])->toArray(),
                        'id'
                    )
                ),
                'allowEmpty' => true
            ])
        );
    }

    private function categoryIdValidation()
    {
        $this->validator->add(
            'category_id',
            new InclusionIn([
                'domain' => array_column(
                    ModelAdminMenuCategory::find([
                        'columns' => 'id'
                    ])->toArray(),
                    'id'
                )
            ])
        );
    }

    private function iconValidation()
    {
        $this->validator->add(
            'icon',
            new StringLength([
                'max' => 50,
                'allowEmpty' => true
            ])
        );
    }

    private function positionValidation()
    {
        $this->validator->add(
            'position',
            new Numericality()
        );
    }
}