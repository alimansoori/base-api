<?php
namespace Lib\Tables\Buttons\ColumnVisibility;


use Lib\DTE\Table\Button;

class ColVisGroup extends Button
{
    private $show;
    private $hide;

    public final function __construct($name)
    {
        parent::__construct($name);
        $this->extend = 'colvisGroup';
    }

    public function init()
    {
        parent::init();
        $this->getTable()->assetsManager->addJs('assets/datatables.net-buttons/js/buttons.colVis.js');
    }

    public function toArray()
    {
        $out = parent::toArray();

        if((is_array($this->show) && !empty($this->show)) || is_string($this->show))
        {
            $out['show'] = $this->getShow();
        }

        if((is_array($this->hide) && !empty($this->hide)) || is_string($this->hide))
        {
            $out['hide'] = $this->getHide();
        }

        return $out;
    }

    /**
     * @return array
     */
    public function getShow(): array
    {
        return $this->show;
    }

    /**
     * @param array $show
     */
    public function setShow( array $show ): void
    {
        $this->show = $show;
    }

    /**
     * @return mixed
     */
    public function getHide()
    {
        return $this->hide;
    }

    /**
     * @param array|string $hide
     */
    public function setHide( $hide ): void
    {
        $this->hide = $hide;
    }
}
