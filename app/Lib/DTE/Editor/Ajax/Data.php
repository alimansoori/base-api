<?php
namespace Lib\DTE\Editor\Ajax;

use Lib\Common\Strings;
use Lib\DTE\Ajax\AjaxData;
use Lib\DTE\Editor\Ajax;

class Data extends AjaxData
{
    public function __construct(Ajax $ajax)
    {
        parent::__construct($ajax);
        $this->data['name'] = $ajax->getEditor()->getName();
    }

    protected function getParentChildData()
    {
        $tableName = null;
        if($this->ajax->getTable() !== null && $this->ajax->getTable()->getDTE()->getParent() !== null)
        {
            $tableName = $this->ajax->getTable()->getDTE()->getParent()->getTable()->getName();
        }
        if($this->ajax->getEditor() !== null && $this->ajax->getEditor()->getDTE()->getParent() !== null)
        {
            $tableName = $this->ajax->getEditor()->getDTE()->getParent()->getTable()->getName();
        }

        $data = "";

        $id = $this->ajax->getEditor()->getDTE()->getIdFromParent();

        if($tableName)
        {
            $data = /** @lang JavaScript */
                "
                var selected = $tableName.row({selected:true});
                if ( selected.any() ) {
                    d.id_from_parent = selected.data().{$id};
                }
            ";
        }

        return Strings::multilineToSingleline($data);
    }
}