<?php
namespace Lib\DTE\Table;


use Lib\DTE\Table;
use Lib\DTE\Table\RowGroup\RowGroupOptionsTrait;

class RowGroup
{
    use RowGroupOptionsTrait;

    private $table;

    public function __construct( Table $table)
    {
        $this->table = $table;
    }

    public function afterInit()
    {
        $this->table->assetsCollection->addCss('assets/datatables.net-rowgroup-dt/css/rowGroup.dataTables.min.css');
        $this->getTable()->assetsManager->addJs('assets/datatables.net-rowgroup/js/dataTables.rowGroup.min.js');
        return $this;
    }

    public function toArray()
    {
        $output = [];

        if($this->className)
            $output['className'] = $this->className;
        if($this->dataSrc)
            $output['dataSrc'] = $this->dataSrc;
        if($this->emptyDataGroup)
            $output['emptyDataGroup'] = $this->emptyDataGroup;
        if($this->enable === false)
            $output['enable'] = $this->enable;
        if($this->endClassName)
            $output['endClassName'] = $this->endClassName;
        if($this->endRender)
            $output['endRender'] = $this->endRender;
        if($this->startClassName)
            $output['startClassName'] = $this->startClassName;
        if($this->startRender)
            $output['startRender'] = $this->startRender;

        return $output;
    }

    public function getDataSrc()
    {
        if(isset($this->table->getOptions()['rowGroup']['dataSrc']))
        {
            return $this->table->getOptions()['rowGroup']['dataSrc'];
        }

        return null;
    }

    /**
     * @return Table
     */
    public function getTable()
    {
        return $this->table;
    }
}