<?php
namespace Modules\CreateContent\Ad\Editors;


use Lib\Editors\Adapter\Editor;
use Lib\Editors\Fields\Type\Ckeditor;
use Lib\Editors\Fields\Type\SelectMenu;
use Lib\Editors\Fields\Type\Text;
use Lib\Translate\T;
use Modules\System\Native\Models\Language\ModelLanguage;

class EditorCategory extends Editor
{
    public function init(): void
    {
//        $this->addFieldParent();
    }

    public function initAjax(): void
    {
        $this->ajaxCreate->setUrl(
            $this->url->get([
                'for' => 'api_create_ad_category__'. ModelLanguage::getCurrentLanguage()
            ])
        );

        $this->ajaxEdit->setUrl(
            $this->url->get([
                'for' => 'api_edit_ad_category__'. ModelLanguage::getCurrentLanguage()
            ])
        );

        $this->ajaxRemove->setUrl(
            $this->url->get([
                'for' => 'api_remove_ad_category__'. ModelLanguage::getCurrentLanguage()
            ])
        );
    }

    /* * * * * * * * * * * * * * * * * * * * * * * * * * */
    /*     Fields
    /* * * * * * * * * * * * * * * * * * * * * * * * * * */

    public function initFields(): void
    {
        $this->fieldTitle();
        $this->fieldPosition();
//        $this->fieldParentId();
        $this->fieldDescription();
    }

    private function fieldTitle()
    {
        $field = new Text('title');
        $field->setLabel(T::_('title'));
        $field->setAttr([
            'placeholder' => T::_('title')
        ]);

        $this->addField($field);
    }

    private function fieldDescription()
    {
        $field = new Ckeditor('description');
        $field->setLabel(T::_('description'));
        $field->setClassName('block');

        $this->addField($field);
    }

    private function fieldParentId()
    {
        $field = new SelectMenu('parent_id');
        $field->setClassName('parent_id');
        $field->setLabel(T::_('parent'));

        $this->addField($field);
    }

    private function addFieldParent()
    {
        $url = $this->url->get([
            'for' => 'api_ad_categories__'. ModelLanguage::getCurrentLanguage()
        ]);
        $this->events->initEdit(/** @lang JavaScript */
            "
            var selected = {$this->getTable()->getName()}.row( { selected: true } );
    
            if ( selected.any() ) {
                var id = selected.data().id;
            }
        ");
        $this->events->preOpen(/** @lang JavaScript */
            "        
            $.ajax({
                url: '{$url}',
                dataType: 'json',
                success: function(result,status,xhr) {
                  alert('llll');
                }
            });
        "
        );
        $this->events->initRemove("alert('remove');");

    }
}