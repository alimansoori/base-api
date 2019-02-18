<?php
namespace Lib\Editors;


use Lib\DTE\Asset\Assets;
use Lib\Editors\Ajax\AjaxCreate;
use Lib\Editors\Ajax\AjaxEdit;
use Lib\Editors\Ajax\AjaxRemove;
use Lib\Mvc\User\Component;
use Lib\Translate\T;
use Modules\System\Native\Models\Language\ModelLanguage;

abstract class Adapter extends Component implements AdapterInterface, OptionsInterface
{
    protected $name;
    /** @var Assets $assetsManager */
    public $assetsManager;

    /** @var null|\Lib\Tables\Adapter */
    protected $table;

    /** @var Events */
    public $events;

    /** @var Ajax */
    protected $ajaxCreate;
    /** @var Ajax */
    protected $ajaxEdit;
    /** @var Ajax */
    protected $ajaxRemove;

    public function __construct(string $name)
    {
        $this->setName($name);
        $this->assetsManager = new Assets();
        $this->events = new Events($this);

        $this->ajaxCreate = new AjaxCreate($this);
        $this->ajaxEdit   = new AjaxEdit($this);
        $this->ajaxRemove = new AjaxRemove($this);

        $this->translate();

        $this->setDirection();
    }

    use ManageOptions;
    use ManageClassName;
    use ManageFields;
    use ManageProcess;

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return \Lib\Tables\Adapter|null
     */
    public function getTable(): ?\Lib\Tables\Adapter
    {
        return $this->table;
    }

    /**
     * @param \Lib\Tables\Adapter|null $table
     * @throws Exception
     */
    public function setTable(?\Lib\Tables\Adapter $table): void
    {
        $this->addOption('table', '#'. $table->getName());
        $this->table = $table;
    }

    protected function translate()
    {
        return $this->addOption('i18n', [
            'create' => [
                'button' => T::_('dte_create_button'),
                'title'  => T::_('dte_create_title'),
                'submit' => T::_('dte_create_submit'),
            ],
            'edit' => [
                'button' => T::_('dte_edit_button'),
                'title'  => T::_('dte_edit_title'),
                'submit' => T::_('dte_edit_submit'),
            ],
            'remove' => [
                'button' => T::_('dte_remove_button'),
                'title'  => T::_('dte_remove_title'),
                'submit' => T::_('dte_remove_submit'),
                'confirm' => [
                    '_' => T::_('dte_remove_multi_confirm'),
                    '1' => T::_('dte_remove_one_confirm'),
                ]
            ],
            'multi' => [
                'title' => T::_('dte_multi_title'),
                'info' => T::_('dte_multi_info'),
                'restore' => T::_('dte_multi_restore'),
                'noMulti' => T::_('dte_multi_no_multi'),
            ],
            'error' => [
                'system' => T::_('dte_error_system')
            ],
            'datetime' => [
                'previous' => T::_('dte_date_time_previous'),
                'next' => T::_('dte_date_time_next'),
                'weekdays' => [
                    T::_('sunday'),
                    T::_('monday'),
                    T::_('tuesday'),
                    T::_('wednesday'),
                    T::_('thursday'),
                    T::_('friday'),
                    T::_('saturday'),
                ]
            ],
        ]);
    }

    private function setDirection()
    {
        if (ModelLanguage::getCurrentDir() == 'ltr')
            return;

        $this->assetsManager->addInlineCss(/** @lang CSS */
            <<<TAG
            div.DTE_Body div.DTE_Body_Content div.DTE_Field>label{
                float: right;
                text-align: right;
            }
            div.DTE_Field_Input{
                direction: rtl;
                text-align: right;
            }
TAG
);
    }

    protected function addFunctionOnPageDisplay()
    {
        $this->assetsManager->addInlineJsTop(/** @lang JavaScript */
            <<<TAG
        function onPageDisplay(elm) {
            var name = 'onPage' + Math.random();
            var Editor = $.fn.dataTable.Editor;
            var emptyInfo;

            Editor.display[name] = $.extend(true, {}, Editor.models.display, {
                init: function (editor) {
                    emptyInfo = elm.html();
                    return Editor.display[name];
                },

                open: function (editor, form, callback) {
                    elm.children().detach();
                    elm.append(form);

                    if (callback) {
                        callback();
                    }
                },

                close: function (editor, callback) {
                    elm.children().detach();
                    elm.html(emptyInfo);

                    if (callback) {
                        callback();
                    }
                }
            });

            return name;
        }
TAG
        );
    }

}