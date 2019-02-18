<?php
namespace Lib\DTE\Table;

use Lib\DTE\Table;
use Lib\DTE\Table\Select\TSelectOptions;
use Lib\DTE\Table\Select\TSelectApi;
use Lib\Mvc\User\Component;

class Select extends Component
{
    const STYLE_API         = 'api';
    const STYLE_SINGLE      = 'single';
    const STYLE_MULTI       = 'multi';
    const STYLE_OS          = 'os';
    const STYLE_MULTI_SHIFT = 'multi+shift';

    use TSelectOptions;
    use TSelectApi;

    /** @var Table */
    protected $table;

    public function __construct(Table $table)
    {
        $this->table = $table;
    }

    /**
     * @return Table
     */
    public function getTable()
    {
        return $this->table;
    }

    /**
     * @param Table $table
     */
    public function setTable( $table )
    {
        $this->table = $table;
    }

    public function toArray()
    {
        $this->getTable()->assetsManager->addJs('assets/datatables.net-select/js/dataTables.select.min.js');
        $out = [];

        if($this->blurable)
            $out['blurable'] = $this->blurable;
        if($this->className)
            $out['className'] = $this->className;
        if(!$this->isInfo())
            $out['info'] = $this->info;
        if($this->items)
            $out['items'] = $this->items;
        if($this->selector)
            $out['selector'] = $this->selector;
        if($this->style)
            $out['style'] = $this->style;

        return $out;
    }
}