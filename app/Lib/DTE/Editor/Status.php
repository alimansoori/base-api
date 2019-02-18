<?php
namespace Lib\DTE\Editor;


class Status
{
    private $create = false;
    private $edit   = false;
    private $remove = false;

    /**
     * @return bool
     */
    public function isCreate()
    {
        return $this->create;
    }

    /**
     * @param bool $create
     */
    public function setCreate( $create )
    {
        if(is_bool($create))
            $this->create = $create;
    }

    /**
     * @return bool
     */
    public function isEdit()
    {
        return $this->edit;
    }

    /**
     * @param bool $edit
     */
    public function setEdit( $edit )
    {
        if(is_bool($edit))
            $this->edit = $edit;
    }

    /**
     * @return bool
     */
    public function isRemove()
    {
        return $this->remove;
    }

    /**
     * @param bool $remove
     */
    public function setRemove( $remove )
    {
        if(is_bool($remove))
            $this->remove = $remove;
    }

}