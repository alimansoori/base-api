<?php
namespace Lib\Editors;


trait ManageClassName
{
    protected $className;

    public function getClassNames(): array
    {
        return $this->className;
    }

    public function setClassNames(array $classNames):void
    {
        $this->className = $classNames;
    }

    public function addClassName(string $className)
    {
        if (!$this->hasClassName($className))
            $this->className[] = $className;
    }

    public function hasClassName(string $className)
    {
        if (array_search($className, $this->className) === false)
        {
            return false;
        }

        return true;
    }
}