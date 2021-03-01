<?php


namespace GoldenraspberryTest\Permissions\Acl\Mock;


use Goldenraspberry\Permissions\Acl\Role\RoleGroupInterface;
use Goldenraspberry\Permissions\Acl\Role\RoleInterface;

class RoleGroup extends Role implements RoleGroupInterface {

    protected $mapRole = [];

    public function addRole(RoleInterface $role) {
        $this->mapRole[$role->getId()] = $role;
    }

    public function removeRole(RoleInterface $role) {
        unset($this->mapRole[$role->getId()]);
    }

    public function listRole() {
        return array_values($this->mapRole);
    }


}