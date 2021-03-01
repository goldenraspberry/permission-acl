<?php


namespace GoldenraspberryTest\Permissions\Acl\Mock;


use Goldenraspberry\Permissions\Acl\Policy\PolicyInterface;
use Goldenraspberry\Permissions\Acl\Policy\PolicyRegisterInterface;
use Goldenraspberry\Permissions\Acl\Policy\RolePolicyInterface;
use Goldenraspberry\Permissions\Acl\Policy\UserPolicyInterface;
use Goldenraspberry\Permissions\Acl\Role\RoleGroupInterface;
use Goldenraspberry\Permissions\Acl\Role\RoleInterface;
use Goldenraspberry\Permissions\Acl\User\UserInterface;

class PolicyRegister implements PolicyRegisterInterface {

    use Register;

    public function register(PolicyInterface $policy) {
        $this->registerData($policy);
    }

    public function unregister(PolicyInterface $policy) {
        $this->unregisterData($policy);
    }

    public function listByUser(UserInterface $user) {
        $list = [];
        foreach($this->data as $p){
            if ($p instanceof UserPolicyInterface){
                if ($p->getUser()->getId() == $user->getId()){
                    $list[] = $p;
                }
            }
        }
        return $list;
    }

    public function listByRole(RoleInterface $role) {
        $list = [];
        foreach($this->data as $p){
            if ($p instanceof RolePolicyInterface){
                if ($p->getRole()->getId() == $role->getId()){
                    $list[] = $p;
                }
            }
        }
        return $list;
    }

    public function listByRoles(array $listRole) {
        $mRoleId = [];
        $queue = $listRole;
        while (!empty($queue)){
            $role = array_shift($queue);
            if (isset($mRoleId[$role->getId()])){
                continue;
            }
            $mRoleId[$role->getId()] = $role;
            if ($role instanceof RoleGroupInterface){
                $list = $role->listRole();
                $queue = array_merge($queue, $list);
            }
        }

        $list = [];
        foreach($this->data as $p){
            if ($p instanceof RolePolicyInterface){
                if (isset($mRoleId[$p->getRole()->getId()])){
                    $list[] = $p;
                }
            }
        }
        return $list;
    }


}