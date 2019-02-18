<?php
namespace Lib\Tables;


use Lib\Assets\Inline;
use Lib\Assets\Resource;
use Lib\Common\Strings;
use Lib\DTE\Asset\Assets;
use Lib\DTE\Table\Columns\Column;
use Lib\Mvc\User\Component;
use Lib\Translate\T;
use Phalcon\Text;

abstract class Adapter extends Component implements AdapterInterface, OptionsInterface, DomInterface, ColumnsInterface, EditorInterface, ButtonInterface
{
    use ManageOptions;
    use ManageDom;
    use ManageColumns;
    use ManageButtons;
    use ManageEditors;
    use ManageClassName;
    use ManageProcess;

    protected $name;
    /** @var Assets  */
    public $assetsManager;
    /** @var AjaxInterface */
    public $ajax;
    /** @var Events */
    protected $events;

    public function __construct($name)
    {
        $this->setName($name);
        $this->translate();
        $this->addOption('dom', 'lfrtip');
        $this->addOption('serverSide', true);

        $this->assetsManager = new Assets();
        $this->ajax = new Ajax($this);
        $this->events = new Events($this);
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function render(): string
    {
        $this->beforeRender();
        $classNames = implode(' ', $this->className);

        $out = "<table id='{$this->getName()}' class='{$classNames}' style='width: 100%'>";
        $out .= "</table>";

        return $out;
    }

    protected function translate()
    {
        $this->addOption( 'language', [
            'processing'     => T::_( 'dte_s_processing' ),
            'search'         => T::_( 'dte_s_search' ),
            'lengthMenu'     => T::_( 'dte_s_length_menu' ),
            'info'           => T::_( 'dte_s_info' ),
            'infoEmpty'      => T::_( 'dte_s_info_empty' ),
            'infoFiltered'   => T::_( 'dte_s_info_empty' ),
            'infoPostFix'    => T::_( 'dte_s_info_postfix' ),
            'loadingRecords' => T::_( 'dte_s_loading_records' ),
            'zeroRecords'    => T::_( 'dte_s_zero_records' ),
            'emptyTable'     => T::_( 'dte_s_empty_table' ),
            'paginate'       => [
                'first'    => T::_( 'dte_o_paginate_s_first' ),
                'previous' => T::_( 'dte_o_paginate_s_previous' ),
                'next'     => T::_( 'dte_o_paginate_s_next' ),
                'last'     => T::_( 'dte_o_paginate_s_last' ),
            ],
            'aria'           => [
                'sortAscending'  => T::_( 'dte_o_aria_sort_s_ascending' ),
                'sortDescending' => T::_( 'dte_o_aria_sort_s_descending' ),
            ],
        ] );
    }

    protected function beforeRender()
    {
        /** @var Resource $resource */
        foreach ($this->assets->collection($this->getName())->getResources() as $resource)
        {
            if ($resource->getType() == 'css' || $resource->getType() == 'js') {
                $this->assetsCollection->{'add'. Text::camelize($resource->getType())}(
                    $resource->getPath(),
                    $resource->getLocal(),
                    $resource->getFilter(),
                    $resource->getAttributes()
                );
            }
        }
        /** @var Inline $inline */
        foreach ($this->assets->collection($this->getName())->getCodes() as $inline)
        {
            if ($inline->getType() == 'css' || $inline->getType() == 'js') {
                $this->assetsCollection->{'addInline'.Text::camelize($inline->getType())}(
                    $inline->getContent(),
                    $inline->getFilter(),
                    $inline->getAttributes()
                );
            }
        }
    }
}