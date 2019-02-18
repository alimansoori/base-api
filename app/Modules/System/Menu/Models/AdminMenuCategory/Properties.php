<?php
namespace Modules\System\Menu\Models\AdminMenuCategory;


trait Properties
{
    private $id;
    private $position;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getPosition()
    {
        return $this->position;
    }

    /**
     * @param mixed $position
     */
    public function setPosition( $position )
    {
        $this->position = $position;
    }
}