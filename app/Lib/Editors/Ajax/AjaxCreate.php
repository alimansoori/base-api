<?php
namespace Lib\Editors\Ajax;


use Lib\Common\Strings;
use Lib\Editors\Adapter;
use Lib\Editors\Ajax;
use Lib\Tables\Adapter\HierarchyTable;

class AjaxCreate extends Ajax
{
    private $hierarchy = false;
    public function __construct(Adapter $editor, $hierarchy=false)
    {
        parent::__construct($editor);
        $this->setType('POST');
        $this->hierarchy = $hierarchy;
    }

    public function toArray()
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

        return $ajax;
    }

    public function process()
    {
        $this->editor->addOption('ajax', [
            'create' => $this->toArray()
        ]);
    }
}