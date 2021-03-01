<?php


namespace Goldenraspberry\Permissions\Acl\User;


use Goldenraspberry\Permissions\Acl\Role\RoleInterface;

interface UserInterface {

    /**
     * @return int
     */
    public function getId();

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
     * @return array []RoleInterface
     */
    public function listRole();
}