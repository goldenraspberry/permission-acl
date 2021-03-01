<?php


namespace Goldenraspberry\Permissions\Acl\Role;


interface RoleGroupInterface extends RoleInterface {

    /**
     * @param RoleInterface $role
     * @return bool
     */
    public function addRole(RoleInterface $role);

    /**
     * @param RoleInterface $role
     * @return bool
     */
    public function removeRole(RoleInterface $role);

    /**
     * @return array
     */
    public function listRole();

}