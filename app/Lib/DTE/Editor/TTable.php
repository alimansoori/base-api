<?php
namespace Lib\DTE\Editor;


use Lib\DTE\ITable;
use Lib\DTE\Table;

trait TTable
{
    /** @var Table $table */
    protected $table;

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
    public function setTable( Table $table )
    {
        if(!$table instanceof Table\NullObjectTable)
            $this->addOption('table', '#'. $table->getName());

        $this->table = $table;
    }
}