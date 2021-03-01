<?php


namespace GoldenraspberryTest\Permissions\Acl\Mock;


use Goldenraspberry\Permissions\Acl\Role\RoleInterface;
use Goldenraspberry\Permissions\Acl\User\UserInterface;

class User implements UserInterface {

    use Id;

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