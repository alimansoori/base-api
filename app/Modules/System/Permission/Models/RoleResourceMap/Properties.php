<?php
namespace Modules\System\Permission\Models\RoleResourceMap;


trait Properties
{
    private $id;
    private $role_id;
    private $resource_id;
    private $status;

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
    public function getRoleId()
    {
        return $this->role_id;
    }

    /**
     * @param mixed $role_id
     */
    public function setRoleId( $role_id ): void
    {
        $this->role_id = $role_id;
    }

    /**
     * @return mixed
     */
    public function getResourceId()
    {
        return $this->resource_id;
    }

    /**
     * @param mixed $resource_id
     */
    public function setResourceId( $resource_id ): void
    {
        $this->resource_id = $resource_id;
    }

    /**
     * @return mixed
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param mixed $status
     */
    public function setStatus( $status ): void
    {
        $this->status = $status;
    }
}