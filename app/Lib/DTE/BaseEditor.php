<?php
namespace Lib\DTE;


use Lib\DTE\Ajax\AjaxCommon;
use Lib\DTE\Asset\Assets;
use Lib\DTE\Editor\Ajax;
use Lib\DTE\Editor\Events;
use Lib\DTE\Editor\Status;
use Lib\DTE\Editor\TError;
use Lib\DTE\Editor\TFields;
use Lib\DTE\Editor\TMessages;
use Lib\DTE\Editor\TOptions;
use Lib\DTE\Editor\TProcess;
use Lib\DTE\Editor\TReqAjax;
use Lib\DTE\Editor\TTable;
use Lib\Mvc\User\Component;
use Lib\Translate\T;

abstract class BaseEditor extends Component
{
    use TOptions;
    use TFields;
    use TMessages;
    use TError;
    use TTable;
    use TProcess;
    use TReqAjax;

    protected $redirect;
    protected $reload = false;

    private $postData = [];

    protected $name;
    /** @var Assets */
    public $assetsManager;

    /** @var AjaxCommon $ajax */
    protected $ajax;
    /** @var Events */
    protected $events;

    protected $operationMade = 0;
    const OP_NONE   = 0;
    const OP_CREATE = 1;
    const OP_EDIT   = 2;
    const OP_REMOVE = 3;

    public function __construct($name)
    {
        $this->setName($name);
        $this->assetsManager = new Assets();
        $this->ajax = new Ajax($this);
        $this->events = new Events($this);
        $this->translate();
    }

    protected function translate()
    {
        return $this->setOption('i18n', $this->options['i18n'] = [
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

    abstract public function render();

    /** @return mixed */
    public function getName() { return $this->name; }

    /** @param mixed $name */
    public function setName( $name ) { $this->name = $name; }

    /** @return Status */
    public function getStatus() { return $this->status; }

    public function getPostData() { return $this->postData; }

    /** @return int */
    public function getOperationMade() { return $this->operationMade; }

    abstract public function init();

    abstract public function initFields();

    abstract public function initAjax();

    abstract public function createAction();

    abstract public function editAction();

    abstract public function removeAction();
}