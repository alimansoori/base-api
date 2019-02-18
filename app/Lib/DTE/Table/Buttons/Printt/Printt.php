<?php
namespace Lib\DTE\Table\Buttons\Printt;


use Lib\DTE\Table\Button;

class Printt extends Button implements IPrint
{
    public function __construct()
    {
        $this->extend = 'print';
    }

    public function afterInit()
    {
        parent::afterInit();
        $this->getTable()->jsHigh->addJs('assets/datatables.net-buttons/js/buttons.print.js');
    }
}