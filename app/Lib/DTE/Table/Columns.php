<?php
namespace Lib\DTE\Table;

use Lib\DTE\Abstracts\Table;

class Columns implements IBuild
{
    /** @var Table $table */
    protected $table;

    private $columns = [];

    public static $columnsBuilder = [];

    public function __construct( Table $table)
    {
        $this->table = $table;
    }

    public function getColumns($arrayVal=true)
    {
        if($arrayVal)
            return array_values($this->columns);

        return $this->columns;
    }

    public function getColumnsByName()
    {
        return array_column($this->columns, 'name');
    }

//    public function getColumnsAssignByName()
//    {
//        $result = [];
//        foreach($this->columns as $column)
//        {
//            $result[] = $column['name']. ' AS '. $column['data'];
//        }
//        return $result;
//    }

    public function addColumn($col)
    {
        $this->columns[$col['name']] = $col;
    }

    public function addFirstColumn($col)
    {
        array_unshift($this->columns, $col);
    }

    public function build()
    {
        $this->table->addOptions([
            'columns' => $this->getColumns()
        ]);
    }

    public static function getColumnsForBuilder()
    {
        return array_values(self::$columnsBuilder);
    }
}