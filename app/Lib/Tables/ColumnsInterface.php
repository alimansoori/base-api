<?php
namespace Lib\Tables;


interface ColumnsInterface
{
    public function initColumns(): void;
    public function processColumns(): void;

    /**
     * @return Column[]
     */
    public function getColumns();
    public function getColumn(string $name): Column;
    public function addColumn(Column $column);
    public function hasColumn(string $name): bool;
}