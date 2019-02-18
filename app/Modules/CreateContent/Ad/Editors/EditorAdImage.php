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

class EditorAdImage extends Editor
{
    public function init(): void
    {
    }

    public function initAjax(): void
    {
        $this->ajaxCreate->setUrl(
            $this->url->get([
                'for' => 'api_create_ad_image__'. ModelLanguage::getCurrentLanguage()
            ])
        );

        $this->ajaxEdit->setUrl(
            $this->url->get([
                'for' => 'api_edit_ad_image__'. ModelLanguage::getCurrentLanguage()
            ])
        );

        $this->ajaxRemove->setUrl(
            $this->url->get([
                'for' => 'api_remove_ad_image__'. ModelLanguage::getCurrentLanguage()
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
        $this->fieldImage();
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

    protected function fieldImage()
    {
        $field = new Upload('image_id');
        $field->setLabel(T::_('image'));
        $field->setClearText(T::_('clear'));
        $field->setNoFileText(T::_('no_image'));
//        $field->setClassName('block');
        $field->setDisplay(/** @lang JavaScript */
            <<<TAG
            return '<img src="'+{$this->getName()}.file( 'files', file_id ).web_path+'"/>';
TAG
);

        // ajax
        $ajax = new AjaxCreate($this, true);
        $ajax->setUrl(
            $this->url->get([
                'for' => 'api_upload_image__'. ModelLanguage::getCurrentLanguage()
            ])
        );

        $field->setAjax($ajax->toArray());

        $this->addField($field);
    }
}