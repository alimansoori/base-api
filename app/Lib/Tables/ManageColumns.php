<?php
namespace Lib\Tables;


trait ManageColumns
{
    protected $columns = [];
    private $targetColumn = 0;

    public function getColumns()
    {
        return $this->columns;
    }

    public function getColumn(string $name): Column
    {
        if(!$this->hasColumn($name))
            throw new Exception("Column for name $name does not exist");

        return $this->columns[$name];
    }

    public function addColumn(Column $column)
    {
        $column->setTable($this);
        $column->setTarget($this->targetColumn);
        $this->columns[$column->getName()] = $column;
        $this->targetColumn = $this->targetColumn + 1;
    }

    public function hasColumn(string $name): bool
    {
        return isset($this->columns[$name]);
    }

    public function processColumns(): void
    {
        $this->initColumns();

        /** @var Column $column */
        foreach($this->columns as $column)
        {
            $column->init();
            $this->options['columns'][] = $column->toArray();
        }
    }

}