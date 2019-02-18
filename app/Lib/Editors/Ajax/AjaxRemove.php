<?php
namespace Lib\Editors\Ajax;


use Lib\Common\Strings;
use Lib\Editors\Adapter;
use Lib\Editors\Ajax;
use Lib\Tables\Adapter\HierarchyTable;

class AjaxRemove extends Ajax
{
    private $hierarchy = false;
    public function __construct(Adapter $editor, $hierarchy = false)
    {
        parent::__construct($editor);
        $this->setType('DELETE');
        $this->hierarchy = $hierarchy;
    }

    public function process()
    {
        $ajax = [];

        if ($this->_url)
        {
            $ajax['url'] = $this->_url;
        }
        if ($this->_type)
        {
            $ajax['type'] = $this->_type;
        }
        if (!empty($this->getData()))
        {
            $ajax['data'] = Strings::multilineToSingleline("||function(d){".$this->getData(false)."}||");
            if ($this->hierarchy)
            {
                if ($this->editor->getTable() instanceof HierarchyTable)
                {
                    $tableName = $this->editor->getTable()->getParent()->getName();
                    $ajax['data'] = Strings::multilineToSingleline("||function(d){".$this->getData(false)."; var selected = $tableName.row({selected:true}); if(selected.any()){d.hierarchy_id=selected.data().id;}}||");
                }
            }
        }

        $this->editor->addOption('ajax', [
            'remove' => $ajax
        ]);
    }
}