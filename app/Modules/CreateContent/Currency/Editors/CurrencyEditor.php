<?php
namespace Modules\CreateContent\Currency\Editors;


use Lib\Editors\Fields\Type\Hidden;
use Lib\Editors\Fields\Type\Text;
use Lib\Editors\Adapter\Editor;
use Lib\Translate\T;
use Modules\System\Native\Models\Language\ModelLanguage;

class CurrencyEditor extends Editor
{
    public function init(): void
    {
        // TODO: Implement init() method.
    }

    public function initFields(): void
    {
        $this->fieldPosition();
        $this->fieldTitle();
    }

    protected function fieldPosition()
    {
        $field = new Hidden('position');
        $this->addField($field);
    }

    private function fieldTitle()
    {
        $field = new Text('title');
        $field->setLabel(T::_('title'));
        $this->addField($field);
    }

    public function initAjax(): void
    {
        $this->ajaxCreate->setUrl(
            $this->url->get([
                'for' => 'api_create_currency__'. ModelLanguage::getCurrentLanguage()
            ])
        );

        $this->ajaxEdit->setUrl(
            $this->url->get([
                'for' => 'api_edit_currency__'. ModelLanguage::getCurrentLanguage()
            ])
        );

        $this->ajaxRemove->setUrl(
            $this->url->get([
                'for' => 'api_remove_currency__'. ModelLanguage::getCurrentLanguage()
            ])
        );
    }
}