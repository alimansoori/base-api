<?php
namespace Lib\Tables\Adapter;


interface HierarchyTableInterface
{
    public function setParent(HierarchyTable $table): void ;
    public function getParent();
    public function addChildren(HierarchyTable $table): void ;

    /**
     * @param string|null $name
     * @return HierarchyTable|HierarchyTable[]
     */
    public function getChildren(string $name = null);
    public function isChildren(string $name): bool ;
}