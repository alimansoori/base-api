<?php

namespace Modules\CreateContent\Ad\Editors;


use Lib\Editors\Adapter\StandaloneEditor;
use Lib\Editors\Ajax\AjaxCreate;
use Lib\Editors\Fields\Type\Text;
use Lib\Editors\Fields\Type\Textarea;
use Lib\Editors\Fields\Type\Upload;
use Lib\Translate\T;
use Modules\CreateContent\Ad\Models\ModelAd;
use Modules\System\Native\Models\Language\ModelLanguage;

class EditorAdNew extends StandaloneEditor
{
    private $editId;
    /** @var ModelAd  */
    private $editAd;

    public function __construct(string $name, $editId = null)
    {
        parent::__construct($name);

        if ($editId && is_numeric($editId))
        {
            $this->editId = $editId;
            $this->editAd = ModelAd::findFirst($editId);
        }
    }

    public function init(): void
    {
        $this->addFunctionOnPageDisplay();
        $this->addOption('display', "||onPageDisplay($('#new_panel'))||");
        if (!$this->editAd)
            $this->editorCreate();
        else
            $this->editorEdit();
    }

    public function initAjax(): void
    {
        if ($this->editAd)
        {
            $this->ajaxCreate->setUrl(
                $this->url->get([
                    'for' => 'api_edit_ad__'.ModelLanguage::getCurrentLanguage(),
                    'ad_id' => $this->editId
                ])
            );
        }
        else
        {
            $this->ajaxCreate->setUrl(
                $this->url->get([
                    'for' => 'api_create_new_ad__'.ModelLanguage::getCurrentLanguage()
                ])
            );
        }
    }

    /* * * * * * * * * * * * * * * * * * * * * * * * * * */
    /*     Fields
    /* * * * * * * * * * * * * * * * * * * * * * * * * * */

    public function initFields(): void
    {
        $this->fieldTitle();
        $this->fieldDescription();
        $this->fieldImage();
    }

    private function fieldTitle()
    {
        $field = new Text('title');
        $field->setLabel(T::_('title'));
        if ($this->editAd)
        {
            $field->setDef($this->editAd->getTitle());
        }
        $this->addField($field);
    }

    private function fieldDescription()
    {
        $field = new Textarea('description');
        $field->setLabel(T::_('description'));
        if ($this->editAd)
        {
            $field->setDef($this->editAd->getDescription());
        }
        $this->addField($field);
    }

    private function fieldImage()
    {
        $field = new Upload('image', true);
        $field->setLabel(T::_('image'));

        // ajax
        $ajax = new AjaxCreate($this, true);
        $ajax->setUrl(
            $this->url->get([
                'for' => 'api_upload_image_ad_new__'. ModelLanguage::getCurrentLanguage()
            ])
        );

        $field->setAjax($ajax->toArray());
        $this->addField($field);
    }

    private function editorCreate()
    {
        $ajaxUrl = $this->url->get([
            'for' => 'api_fields_editor__'. ModelLanguage::getCurrentLanguage(),
        ]);

        $this->assetsManager->addCss('assets/select2/dist/css/select2.min.css');
        $this->assetsManager->addJs('assets/select2/dist/js/select2.min.js');
        $this->assetsManager->addJs('dt/js/editor.select2.js');
        $this->assetsManager->addJs('dt/js/editor.select-range.js');
        $this->assetsManager->addJs('dt/js/editor.range.js');
        $this->assetsManager->addJs('dt/js/editor.price.js');

        $this->assetsManager->addInlineJsBottom(/** @lang JavaScript */
            <<<TAG
            function createEditor{$this->getName()}() {
                  {$this->getName()}.create({
                    title: 'ثبت رایگان آگهی',
                    buttons: [
                        {
                            text: 'ارسال آگهی',
                            fn: function () {
                                this.submit();
                            }
                        },
                        {
                            label: 'تغییر دسته بندی',
                            fn: function () {
                                {$this->getName()}.close();
                            }
                        }
                    ],
                });
            }
            
            $.ajax({
                url: '{$ajaxUrl}',
                type: 'POST',
                data: {
                  category_id: 21,
                  action: 'create'
                },
                success: function (json) {
                    json.fields.forEach(function(options) {
                        if (options.type == 'range'){
                            options.type = 'text';
                        }
                        
                        if (options.type == 'price'){
                            options.isSearch = false;
                        }
                        
                        if (options.type == 'select_range'){
                            options.type = 'select2';
                        }
                        
                        if (options.type == 'select2'){
                            options.opts = {
                                placeholder: 'انتخاب کنید'
                            };
                        }
                        {$this->getName()}.add(options);
                    });
                    
                    createEditor{$this->getName()}();
                },
                statusCode: {
                  404: function() {
                    alert('page not found');
                  }
                }
            });
TAG
        );
    }

    private function editorEdit()
    {
        $ajaxUrl = $this->url->get([
            'for' => 'api_fields_editor__'. ModelLanguage::getCurrentLanguage(),
            'ad_id' => $this->editId
        ]);

        $this->assetsManager->addCss('assets/select2/dist/css/select2.min.css');
        $this->assetsManager->addJs('assets/select2/dist/js/select2.min.js');
        $this->assetsManager->addJs('dt/js/editor.select2.js');
        $this->assetsManager->addJs('dt/js/editor.select-range.js');
        $this->assetsManager->addJs('dt/js/editor.range.js');
        $this->assetsManager->addJs('dt/js/editor.price.js');

        $this->assetsManager->addInlineJsBottom(/** @lang JavaScript */
            <<<TAG
            function createEditor{$this->getName()}() {
                  {$this->getName()}.create({
                    title: 'ویرایش آگهی',
                    buttons: [
                        {
                            text: 'ارسال آگهی',
                            fn: function () {
                                this.submit();
                            }
                        }
                    ],
                });
            }
            
            $.ajax({
                url: '{$ajaxUrl}',
                type: 'POST',
                data: {
                  ad_id: {$this->editId},
                  action: 'edit'
                },
                success: function (json) {
                    json.fields.forEach(function(options) {
                        if (options.type == 'range'){
                            options.type = 'text';
                        }
                        
                        if (options.type == 'price'){
                            options.isSearch = false;
                        }
                        
                        if (options.type == 'select_range'){
                            options.type = 'select2';
                        }
                        
                        if (options.type == 'select2'){
                            options.opts = {
                                placeholder: 'انتخاب کنید'
                            };
                        }
                        {$this->getName()}.add(options);
                    });
                    
                    createEditor{$this->getName()}();
                },
                statusCode: {
                  404: function() {
                    alert('page not found');
                  }
                }
            });
TAG
        );
    }
}