<?php
namespace Lib\Tables\Ajax;


use Lib\Tables\Adapter\HierarchyTable;
use Lib\Tables\Ajax;

/**
 * @method HierarchyTable getTable()
 */
class HierarchyAjax extends Ajax
{
    public function getData($isArray = true)
    {
        $data = parent::getData($isArray);

        if ($this->getTable()->getParent() instanceof HierarchyTable)
        {
            $data .= <<<TAG
            var selected = {$this->getTable()->getParent()->getName()}.row( { selected: true } );
 
            if ( selected.any() ) {
                d.hierarchy_id = selected.data().id;
            }
TAG;
        }

        return $data;
    }
}