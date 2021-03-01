<?php


namespace Goldenraspberry\Permissions\Acl\Policy;


use Goldenraspberry\Permissions\Acl\Role\RoleInterface;

class RolePolicy implements RolePolicyInterface {

    use Policy;

    /**
     * @var RoleInterface
     */
    protected $role = null;

    public function setRole(RoleInterface $role) {
        $this->role = $role;
        return $this;
    }

    public function getRole() {
        return $this->role;
    }


}