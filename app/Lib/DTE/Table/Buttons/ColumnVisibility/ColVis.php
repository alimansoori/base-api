<?php
namespace Lib\DTE\Table\Buttons\ColumnVisibility;


use Lib\DTE\Table\Button;

class ColVis extends Button implements IColumnVisibility
{
    public final function __construct()
    {
        $this->extend = 'colvis';
    }

    public function init()
    {
        parent::init();
        $this->getTable()->assetsManager->addJs('assets/datatables.net-buttons/js/buttons.colVis.js');
    }
}
