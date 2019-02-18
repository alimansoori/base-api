<?php
namespace Modules\System\Widgets\Editors\WidgetManager;


use Lib\DTE\Editor\Fields\Type\Ckeditor;
use Lib\DTE\Editor\Fields\Type\Radio;
use Lib\DTE\Editor\Fields\Type\Select2;
use Lib\DTE\Editor\Fields\Type\Text;
use Lib\DTE\Editor\Fields\Type\Textarea;
use Lib\Translate\T;
use Modules\System\PageManager\Models\Pages\ModelPages;

trait Fields
{
    protected function fieldName()
    {
        $name = new Text('name');
        $name->setData('name._');
        $name->setLabel(T::_('name'));

        $this->addField($name);
    }

    protected function fieldParentId()
    {
        $parent = new Select2('parent_id');
        $parent->setLabel(T::_('parent'));
        $parent->setOptions(
            array_merge(
                [
                    [
                        'title' => 'NULL',
                        'id' => null
                    ]
                ],
                ModelPages::find(['columns' => 'id, title'])->toArray()
            )
        );
        $parent->setOptionsPair('title', 'id');

        $this->addField($parent);
    }

    protected function fieldTitleMenu()
    {
        $titleMenu = new Text('title_menu');
        $titleMenu->setLabel(T::_('page_title_in_menu'));

        $this->addField($titleMenu);
    }

    protected function fieldSlug()
    {
        $slug = new Text('slug');
        $slug->setLabel('Slug');

        $attrs['style'] = 'direction:ltr;';
        $attrs['placeholder'] = 'For Example => /home-page';

        $slug->addAttrs($attrs);

        $this->addField($slug);
    }

    protected function fieldKeywords()
    {
        $keys = new Textarea( 'keywords' );
        $keys->setClassName( 'block' );
        $keys->setLabel( 'Keywords' );
        $this->addField( $keys );
    }

    protected function fieldDescription()
    {
        $description = new Textarea( 'description' );
        $description->setClassName( 'block' );
        $description->setLabel( 'Description' );
        $this->addField( $description );
    }

    protected function fieldContent()
    {
        $content = new Ckeditor( 'content' );
        $content->setClassName( 'block' );
        $content->setLabel( 'Content' );
        $this->addField( $content );
    }

    protected function fieldPosition()
    {
        $position = new Text('position');
        $position->setLabel(T::_('position'));
        $position->setAttr([
            'placeholder' => T::_('placeholder_numeric_field'),
            'type' => 'number'
        ]);

        $this->addField($position);
    }

    protected function fieldStatus()
    {
        $field = new Radio('status');
        $field->setLabel(T::_('status'));
        $field->setOptions([
            [
                'label' => T::_('active'),
                'value' => 'active'
            ],
            [
                'label' => T::_('inactive'),
                'value' => 'inactive'
            ]
        ]);
        $field->setDef('active');

        $this->addField($field);
    }
}