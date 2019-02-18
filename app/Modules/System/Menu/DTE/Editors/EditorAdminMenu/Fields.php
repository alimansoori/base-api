<?php
namespace Modules\System\Menu\DTE\Editors\EditorAdminMenu;


use Lib\DTE\Editor\Fields\Type\Select;
use Lib\DTE\Editor\Fields\Type\Select2;
use Lib\DTE\Editor\Fields\Type\Text;
use Lib\Mvc\Helper\CmsCache;
use Lib\Translate\T;
use Modules\System\Menu\Models\AdminMenu\ModelAdminMenu;
use Modules\System\Menu\Models\AdminMenuCategory\ModelAdminMenuCategory;
use Modules\System\Menu\Models\ModelAdminMenuCategoryTranslate;
use Modules\System\Menu\Models\ModelAdminMenuTranslate;
use Modules\System\Native\Models\Language\ModelLanguage;
use Modules\System\Permission\Models\ModelRoles;

trait Fields
{
    protected function fieldTitle()
    {
        $field = new Text('title');
        $field->setData('title._');
        $field->setLabel(T::_('title'));

        $this->addField($field);
    }

    protected function fieldCategory()
    {
        /** @var ModelAdminMenuCategory[] $categories */
        $categories = ModelAdminMenuCategory::find();

        $options = [];
        $options[] = [
            'label' => '',
            'value' => null
        ];

        foreach ($categories as $cat)
        {
            $catLabel = 'Not set';
            $catValue = $cat->getId();

            if ($cat->getTranslates())
            {
                /** @var ModelAdminMenuCategoryTranslate $translate */
                $translate = $cat->getTranslates([
                    'conditions' => 'language_iso=:lang:',
                    'bind' => [
                        'lang' => ModelLanguage::getCurrentLanguage()
                    ]
                ])->getFirst();
                if ($translate)
                {
                    $catLabel = $translate->getTitle();
                }
            }

            $options[] = [
                'label' => $catLabel,
                'value' => $catValue
            ];
        }
        $field = new Select('category_id');
        $field->setData('category_id._');
        $field->setLabel(T::_('manage'));
        $field->setOptions($options);

        $this->addField($field);
    }

    protected function fieldParentId()
    {
        /** @var ModelAdminMenu[] $parents */
        $parents = ModelAdminMenu::find([
            'conditions' => 'parent_id IS NULL'
        ]);

        $options = [];
        $options[] = [
            'label' => T::_('level_one'),
            'value' => null
        ];
        foreach ($parents as $parent)
        {
            $parentLabel = 'Not set';
            $parentValue = $parent->getId();

            if ($parent->getTranslates())
            {
                /** @var ModelAdminMenuTranslate $translate */
                $translate = $parent->getTranslates([
                    'conditions' => 'language_iso=:lang:',
                    'bind' => [
                        'lang' => ModelLanguage::getCurrentLanguage()
                    ]
                ])->getFirst();
                if ($translate)
                {
                    $parentLabel = $translate->getTitle();
                }
            }

            $options[] = [
                'label' => $parentLabel,
                'value' => $parentValue
            ];
        }
        $field = new Select('parent_id');
        $field->setFieldInfo('اگر مقداری انتخاب نشود این رکورد در سطح اول قرار میگیرد');
        $field->setLabel(T::_('parent'));
        $field->setOptions($options);

        $this->addField($field);
    }

    protected function fieldLink()
    {
        $field = new Text('link');
        $field->setData('link._');
        $field->setLabel(T::_('link'));

        $this->addField($field);
    }

    protected function fieldIcon()
    {
//        $row = [];
//
//        foreach (CmsCache::getInstance()->get('themify') as $value)
//        {
//            $row[] = [
//                'label' => "<i class='$value'></i>&nbsp;&nbsp;&nbsp;" . str_replace('ti', '', \Phalcon\Text::humanize($value)),
//                'value' => $value
//            ];
//        }
//        CmsCache::getInstance()->save('themify_select2_option', $row);

        $field = new Select2('icon');
        $field->setLabel(T::_('title'));
        $field->setOptions(CmsCache::getInstance()->get('themify_select2_option'));
        $field->setOpts([
            'escapeMarkup' => "||function(m) { return m; }||",
            'placeholder' => T::_('please_select_icon')
        ]);

        $this->addField($field);
    }

    protected function fieldRoles()
    {
        $roles = ModelRoles::find([
            'columns' => 'id, title'
        ]);

        $options = [];

        foreach ($roles as $role)
        {
            $options[] = [
                'label' => $role->title,
                'value' => $role->id
            ];
        }

        $field = new Select2('roles');
        $field->setData('roles');
        $field->setLabel(T::_('roles'));
        $field->setOptions($options);
        $field->setOpts([
            'placeholder' => T::_('please_select_roles'),
            'multiple' => true
        ]);

        $this->addField($field);
    }
}