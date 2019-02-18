<?php
namespace Lib\DTE\Table;


use Lib\DTE\Table\Columns\Column;
use Lib\DTE\Table\Columns\IColumn;
use Lib\Exception;

trait TColumns
{
    /** @var Column[] $columns */
    private $columns = [];
    private $targetColumn = 0;

    abstract public function initColumns();

    /**
     * @return Column[]
     */
    public function getColumns()
    {
        return $this->columns;
    }

    /**
     * @param string $name
     * @return Column
     * @throws TableException
     */
    public function getColumn($name)
    {
        if(!$this->hasColumn($name))
            throw new TableException("Column for name $name does not exist");

        return $this->columns[$name];
    }

    /**
     * Adds a column to the table
     *
     * @param IColumn $column
     * @return IColumn
     * @throws Exception
     */
    public function addColumn($column)
    {
        if(!$column instanceof Column)
            throw new Exception('please enter parameter instance of IColumn');

        $column->setTable($this);
        $column->setTarget($this->targetColumn);
        $column->init();
        $this->columns[$column->getName()] = $column;

        $this->targetColumn = $this->targetColumn + 1;
        return $column;
    }

    /**
     * Adds a group of columns
     *
     * @param IColumn[] $columns
     * @param bool $merge
     * @return $this
     */
    public function addColumns(array $columns, $merge = true)
    {
        $currentColumns = $this->columns;
        $mergeColumns = [];
        if($merge)
        {
            if(is_array($currentColumns))
            {
                $mergeColumns = array_merge($currentColumns, $columns);
            }
        }
        else
        {
            $mergeColumns = $columns;
        }

        $this->columns = $mergeColumns;
        return $this;
    }

    public function hasColumn($name)
    {
        return isset($this->columns[$name]);
    }
}