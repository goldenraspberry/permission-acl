<?php


namespace Goldenraspberry\Permissions\Acl\Policy;


use Goldenraspberry\Permissions\Acl\Role\RoleInterface;

interface RolePolicyInterface extends PolicyInterface {

    /**
     * @param RoleInterface $role
     * @return self
     */
    public function setRole(RoleInterface $role);

    /**
     * @return RoleInterface
     */
    public function getRole();

}