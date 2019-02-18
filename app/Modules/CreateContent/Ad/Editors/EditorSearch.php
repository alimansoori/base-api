<?php

namespace Modules\CreateContent\Ad\Editors;


use Lib\Editors\Adapter\StandaloneEditor;
use Lib\Editors\Fields\Type\Mask;
use Lib\Editors\Fields\Type\Select;
use Lib\Editors\Fields\Type\Select2;
use Lib\Translate\T;
use Modules\System\Native\Models\Language\ModelLanguage;

class EditorSearch extends StandaloneEditor

{
    public function init(): void
    {
        $this->addFunctionOnPageDisplay();
        $this->addOption('display', "||onPageDisplay($('#search_box'))||");
        $this->editorCreate();
        $this->postList();
    }

    public function initAjax(): void
    {
        $this->ajaxCreate->setUrl(
            $this->url->get([
                'for' => 'api_ad_search__'.ModelLanguage::getCurrentLanguage()
            ])
        );
        $this->ajaxCreate->setType('GET');
    }

    public function render(): string
    {
        parent::render();

        return /** @lang HTML */
            <<<TAG
<div id="search_box">
    <button class="search_btn">Open Search box</button>
</div>
TAG;
    }

    /* * * * * * * * * * * * * * * * * * * * * * * * * * */
    /*     Fields
    /* * * * * * * * * * * * * * * * * * * * * * * * * * */

    public function initFields(): void
    {
        $this->fieldSearch();
        $this->fieldPriceBox();
    }

    private function fieldSearch()
    {
        $field = new Select2('search');
        $field->setLabel(T::_('search'));
        $field->setOpts([
            'placeholder' => T::_('search')
        ]);

        if ($this->request->getQuery('search'))
        {
            $field->setDef($this->request->getQuery('search'));
        }

        $this->addField($field);
    }

    private function fieldPriceBox()
    {
        $this->fieldPrice();
        $this->fieldPriceFrom();
        $this->fieldPriceTo();

        $this->assetsManager->addInlineJsBottom(/** @lang JavaScript */
            <<<TAG
            {$this->getName()}.dependent('price', function (val) {
                if (val === 1){
                    return {show: ['price_from', 'price_to']};
                } else {
                    return {hide: ['price_from', 'price_to']};
                }
            });
TAG

);
    }

    private function fieldPrice()
    {
        $field = new Select('price');
        $field->setLabel(T::_('price'));
        $field->setOptions([
            [
                'label' => 'مقطوع - تومان',
                'value' => 1,
            ],
            [
                'label' => 'مجانی',
                'value' => 2,
            ],
            [
                'label' => 'توافقی',
                'value' => 3,
            ],
            [
                'label' => 'جهت معاوضه',
                'value' => 4,
            ]
        ]);

        if ($this->request->getQuery('price'))
        {
            $field->setDef($this->request->getQuery('price'));
        }


        $this->addField($field);
    }

    private function fieldPriceFrom()
    {
        $field = new Mask('price_from');
        $field->setLabel(T::_('price_from'));
        $field->setMask("#,##0");
        $field->setMaskOptions([
            'placeholder' => 'قیمت به تومان',
            'reverse' => true
        ]);

        if ($this->request->getQuery('price_from'))
        {
            $field->setDef($this->request->getQuery('price_from'));
        }

        $this->addField($field);
    }

    private function fieldPriceTo()
    {
        $field = new Mask('price_to');
        $field->setLabel(T::_('price_to'));
        $field->setMask("#,##0");
        $field->setMaskOptions([
            'placeholder' => 'قیمت به تومان',
            'reverse' => true
        ]);

        if ($this->request->getQuery('price_to'))
        {
            $field->setDef($this->request->getQuery('price_to'));
        }

        $this->addField($field);
    }

    private function editorCreate()
    {
        $this->assetsManager->addInlineJsBottom(/** @lang JavaScript */
            <<<TAG
            function createEditor{$this->getName()}() {
                  {$this->getName()}.create({
                    title: 'جستجو',
                    buttons: [
                        {
                            text: 'جستجو',
                            fn: function () {
                                var that = this;
                                var fields = this.fields();
                                that.submit();
    
                                var params = {};
                                $.each(fields, function (index, field) {
                                    that.field(field).def(
                                        that.field(field).val()
                                    );
                                    params[field] = that.field(field).val();
                                });
                                var esc = encodeURIComponent;
                                var query = Object.keys(params)
                                    .map(k => esc(k) + '=' + esc(params[k]))
                                    .join('&');
    
                                history.pushState('', "", "?" + query);
                                that.create();
                            },
                        },
                        {
                            label: 'لغو',
                            fn: function () {
                                {$this->getName()}.close();
                            }
                        }
                    ],
                });
            }
            
            createEditor{$this->getName()}();

            $('#search_box').on('click', '.search_btn', function (e) {
                createEditor{$this->getName()}();
            });
TAG
        );
    }

    private function postList()
    {
        $url = $this->url->get([
            'for' => 'api_ad_search__'.ModelLanguage::getCurrentLanguage()
        ]);
        $this->assetsManager->addInlineJsBottom(/** @lang JavaScript */
            <<<TAG
            createBtnExtraItems();
            var offset = 30;
            $('body').on('click', '#extra_items',function(e) {
              e.preventDefault();
              $('#extra_items').remove();
              createLoader();
              $.ajax( {
                url: '{$url}',
                dataType: 'json',
                data: {
                    action: 'create',
                    data: [
                        $.extend(
                            {offset:offset},
                            getUrlVars()
                        )
                    ]
                },
                success: function ( json ) {
                    $('#post_loading').remove();
                    offset = offset + 30;
                }
              });
              createBtnExtraItems();
            } );
            
            function getUrlVars()
            {
                var vars = {}, hash;
                var hashes = window.location.href.slice(window.location.href.indexOf('?') + 1).split('&');
                for(var i = 0; i < hashes.length; i++)
                {
                    hash = hashes[i].split('=');
                    vars[hash[0]] = hash[1];
                }
                return vars;
            }
            
            function createLoader ()
            {
                if($('#post_loading').length){
                    return;
                }
                $(
                    '<div id="post_loading" class="ui active centered inline loader"></div>'
                ).appendTo( '#panels' );
            }
            
            function createBtnExtraItems ()
            {
                if($('#extra_items').length){
                    return;
                }
                $(
                    '<button id="extra_items">دیدن موارد بیشتر</button>'
                ).appendTo( '#panels' );
            }
TAG
);
        $this->assetsManager->addCss('css/semantic-ui/loader.min.css');
    }
}