<?php
namespace Modules\CreateContent\Currency\Editors;


use Lib\Editors\Fields\Type\Text;
use Lib\Editors\Adapter\Editor;
use Lib\Translate\T;
use Modules\System\Native\Models\Language\ModelLanguage;

class PriceEditor extends Editor
{
    public function init(): void
    {
        // TODO: Implement init() method.
    }

    public function initFields(): void
    {
        $this->fieldPrice();
    }

    private function fieldPrice()
    {
        $field = new Text('price');
        $field->setLabel(T::_('price'));
        $this->addField($field);
    }

    public function initAjax(): void
    {
        $this->ajaxCreate->setUrl(
            $this->url->get([
                'for' => 'api_create_price__'. ModelLanguage::getCurrentLanguage()
            ])
        );

        $this->ajaxEdit->setUrl(
            $this->url->get([
                'for' => 'api_edit_price__'. ModelLanguage::getCurrentLanguage()
            ])
        );

        $this->ajaxRemove->setUrl(
            $this->url->get([
                'for' => 'api_remove_price__'. ModelLanguage::getCurrentLanguage()
            ])
        );
    }
}