<?php
namespace Lib\DTE\Table\Buttons\FileExport;


use Lib\DTE\Table\Button;

class Copy extends Button implements IFileExport
{
    public function __construct()
    {
        $this->extend = 'copy';
    }

    public function afterInit()
    {
        parent::afterInit();
        $this->getTable()->jsHigh->addJs('assets/datatables.net-buttons/js/buttons.flash.min.js');
        $this->getTable()->jsHigh->addJs('assets/datatables.net-buttons/js/buttons.html5.min.js');
    }

}