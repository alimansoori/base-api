<?php
namespace Lib\Editors\Fields\Type;


use Modules\System\Native\Models\Language\ModelLanguage;

class SelectMenu extends Hidden
{
    public function __construct($name)
    {
        parent::__construct($name);
    }

    public function init()
    {
        parent::init();

        $url = $this->getEditor()->url->get([
            'for' => 'api_ad_categories__'. ModelLanguage::getCurrentLanguage()
        ]);

        $this->getEditor()->events->displayOrder(/** @lang JavaScript */
            <<<TAG
        $( ".parent_id" ).after( '<div class=\"DTE_Field DTE_Field_Type_text\">' +
            '<label data-dte-e=\"label\" class=\"DTE_Label\" for=\"DTE_Field_title\">' +
            '{$this->getLabel()}' +
             '<div data-dte-e="msg-label" class="DTE_Label_Info"></div></label>' +
            '<div data-dte-e="input" class="DTE_Field_Input">' +
               '<div data-dte-e="input-control" class="DTE_Field_InputControl" style="display: block;">' +
                 '<div id="search-adv" class="dl-menuwrapper">' +
                    '<div class="dl-trigger">همه دسته بندی ها</div>' +
                        '<ul class="dl-menu"></ul>' +
                    '</div>' +
               '</div>' +
            '</div>' +
         '</div>' );

function createList(parent, array) {
    array.forEach(function(o) {
      var li = document.createElement('li'),
        ul;
      var a = document.createElement('a');
      a.className = 'dl-menu__link';
      a.textContent = o.title;
      a.href = '#';
      a.id = o.id;
      li.appendChild(a);
      parent.appendChild(li);

      if (o.children) {
        ul = document.createElement('ul');
        ul.className = 'dl-submenu';
        li.appendChild(ul);
        createList(ul, o.children);
      }
    });
}

$.ajax({
    url: "{$url}",
    dataType: 'json',
    success: function(result){
        $('ul.dl-menu').empty();
      createList(document.querySelector('#search-adv .dl-menu'), result);
      
      var field = {$this->getEditor()->getName()}.field('{$this->getName()}');
      $('#search-adv').dlmenu(field);
    }
});

        
TAG
);

        $this->getEditor()->assetsManager->addJs('dt/select-menu/modernizr.custom.js');
        $this->getEditor()->assetsManager->addJs('dt/select-menu/jquery.dlmenu.js');
        $this->getEditor()->assetsManager->addCss('dt/select-menu/select-menu-default.css');
        $this->getEditor()->assetsManager->addCss('dt/select-menu/select-menu-component.css');
    }
}