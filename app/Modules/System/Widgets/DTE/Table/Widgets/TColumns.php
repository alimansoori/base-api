<?php
namespace Modules\System\Widgets\DTE\Table\Widgets;

use Lib\DTE\Table\Columns\Column;
use Lib\Translate\T;

trait TColumns
{
    protected function columnName()
    {
        $widgetName = new Column('name');
        $widgetName->setTitle(T::_('widget_name'));
        $widgetName->setData('name');
        $this->addColumn($widgetName);
    }

    protected function columnNamespace()
    {
        $namespace = new Column('namespace');
        $namespace->setTitle(T::_('namespace'));
        $namespace->setData('namespace');
        $this->addColumn($namespace);
    }

    protected function columnPlacement()
    {
//        $placeName = new Column('place_name');
//        $placeName->setData('place_name');
//        $placeName->setTitle(T::_('widget_place_name'));
//        $placeName->setVisible(false);
//        $this->addColumn($placeName);
    }

    protected function columnDisplay()
    {
        $display = new Column('display');
        $display->setData('display');
        $display->setTitle(T::_('display'));
        $this->addColumn($display);
    }

    protected function columnPosition()
    {
        $position = new Column('position');
        $position->setData('position');
        $position->setTitle(T::_('position'));
        $this->addColumn($position);
    }

    protected function columnWidth()
    {
        $width = new Column('width');
        $width->setData('width');
        $width->setTitle(T::_('width'));
        $this->addColumn($width);
    }
}