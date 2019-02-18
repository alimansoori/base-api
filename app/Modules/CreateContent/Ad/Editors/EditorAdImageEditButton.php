<?php
namespace Modules\CreateContent\Ad\Editors;


use Lib\Editors\Adapter\Editor;
use Lib\Editors\Ajax\AjaxCreate;
use Lib\Editors\Fields\Type\Ckeditor;
use Lib\Editors\Fields\Type\Hidden;
use Lib\Editors\Fields\Type\SelectMenu;
use Lib\Editors\Fields\Type\Text;
use Lib\Editors\Fields\Type\Upload;
use Lib\Translate\T;
use Modules\System\Native\Models\Language\ModelLanguage;

class EditorAdImageEditButton extends Editor
{
    public function init(): void
    {
    }

    public function initAjax(): void
    {
        $this->ajaxEdit->setUrl(
            $this->url->get([
                'for' => 'api_edit_ad_image__'. ModelLanguage::getCurrentLanguage()
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

    protected function fieldPosition()
    {
        $field = new Hidden('position');

        $this->addField($field);
    }
}