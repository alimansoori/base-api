<?php
namespace Modules\System\Menu\Models\AdminMenuRoles;


trait Properties
{
    private $id;
    private $admin_menu_id;
    private $role_id;

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
    public function getAdminMenuId()
    {
        return $this->admin_menu_id;
    }

    /**
     * @param mixed $admin_menu_id
     */
    public function setAdminMenuId( $admin_menu_id )
    {
        $this->admin_menu_id = $admin_menu_id;
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
    public function setRoleId( $role_id )
    {
        $this->role_id = $role_id;
    }
}