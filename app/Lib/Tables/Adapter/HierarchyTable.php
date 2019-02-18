<?php
namespace Lib\Tables\Adapter;


use Lib\Tables\Adapter;
use Lib\Tables\Ajax\HierarchyAjax;
use Lib\Tables\Exception;

abstract class HierarchyTable extends Adapter implements HierarchyTableInterface
{
    protected $parent;
    /** @var HierarchyTable[] */
    protected $children;

    public function __construct($name)
    {
        parent::__construct($name);

        $this->ajax = new HierarchyAjax($this);
    }

    public function beforeProcess(): void
    {
        $this->eventHierarchy();
        parent::beforeProcess();
    }

    private function eventHierarchy()
    {
        if ($this->children)
        {
            foreach ($this->children as $child)
            {
                $this->events->onSelect(<<<TAG
            {$child->getName()}.ajax.reload();
            if($('#part_{$child->getName()}').is(':hidden')){ $('#part_{$child->getName()}').show() }
TAG
                );
                $this->events->onDeselect(<<<TAG
            {$child->getName()}.ajax.reload();
            if($('#part_{$child->getName()}').is(':visible')){ $('#part_{$child->getName()}').hide() }
TAG
                );
            }
        }

        if ($this->getParent())
        {
            $this->assetsManager->addInlineJsBottom(/** @lang JavaScript */
                <<<TAG
                $('#part_{$this->getParent()->getName()}').on('hide', function() {
                  $('#part_{$this->getName()}').hide();
                });
TAG
);
        }
    }

    public function setParent(HierarchyTable $table): void
    {
        $this->parent = $table;
        $table->addChildren($this);
    }

    /**
     * @return HierarchyTable|null
     */
    public function getParent()
    {
        return $this->parent;
    }

    public function addChildren(HierarchyTable $table): void
    {
        $this->children[$table->getName()] = $table;
    }

    public function getChildren(string $name = null)
    {
        if ($name)
        {
            if ($this->isChildren($name))
            {
                return $this->children[$name];
            }

            throw new Exception("Children $name does not exist");
        }

        return $this->children;
    }

    public function isChildren(string $name): bool
    {
        if (isset($this->children[$name]))
        {
            return true;
        }

        return false;
    }
}