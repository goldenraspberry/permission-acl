<?php


namespace Goldenraspberry\Permissions\Acl;


use Goldenraspberry\Permissions\Acl\Assert\AssertInterface;
use Goldenraspberry\Permissions\Acl\Policy\PolicyInterface;
use Goldenraspberry\Permissions\Acl\Policy\PolicyRegisterInterface;
use Goldenraspberry\Permissions\Acl\Policy\RolePolicy;
use Goldenraspberry\Permissions\Acl\Policy\UserPolicy;
use Goldenraspberry\Permissions\Acl\Resource\ResourceInterface;
use Goldenraspberry\Permissions\Acl\Role\RoleInterface;
use Goldenraspberry\Permissions\Acl\User\UserInterface;

class Acl implements AclInterface {

    /**
     * ACL rules; whitelist (deny everything to all) by default
     * @var int
     */
    protected $defaultRule = PolicyInterface::DENY;

    /**
     * @var PolicyRegisterInterface
     */
    protected $policyRegister = null;

    /**
     * @var AssertInterface
     */
    protected $assert = null;

    public function setPolicyRegister(PolicyRegisterInterface $policyRegister){
        $this->policyRegister = $policyRegister;
    }

    public function setAssert(AssertInterface $assert){
        $this->assert = $assert;
    }

    public function isAllow(UserInterface $user, ResourceInterface $resource) {
        if ($this->policyRegister == null) return false;
        $listUserPolicy = $this->policyRegister->listByUser($user);
        $listRolePolicy = $this->policyRegister->listByRoles($user->listRole());
        return $this->assertPolicy(array_merge($listRolePolicy, $listUserPolicy), $resource);
    }

    public function isUserAllow(UserInterface $user, ResourceInterface $resource) {
        if ($this->policyRegister == null) return false;
        $listUserPolicy = $this->policyRegister->listByUser($user);
        return $this->assertPolicy($listUserPolicy, $resource);
    }

    public function isRoleAllow(RoleInterface $role, ResourceInterface $resource) {
        if ($this->policyRegister == null) return false;
        $listRolePolicy = $this->policyRegister->listByRole($role);
        return $this->assertPolicy($listRolePolicy, $resource);
    }

    /**
     * @param ResourceInterface $resource
     * @param array $listPolicy
     * @return bool
     */
    protected function assertPolicy(array $listPolicy, ResourceInterface $resource){
        if ($this->assert == null) return false;
        return $this->assert->isAllow($listPolicy, $resource, $this->defaultRule);
    }

    public function addPolicy(PolicyInterface $policy) {
        if ($this->policyRegister == null) return false;
        return $this->policyRegister->register($policy);
    }

    public function removePolicy(PolicyInterface $policy){
        if ($this->policyRegister == null) return false;
        return $this->policyRegister->unregister($policy);
    }

    public function addUserPolicy(UserInterface $user, ResourceInterface $resource, $rule = 0, $priority = 0) {
        $up = new UserPolicy();
        $up->setPriority($priority);
        $up->setResource($resource);
        $up->setRule($rule);
        $up->setUser($user);
        return $this->addPolicy($up);
    }

    public function addRolePolicy(RoleInterface $role, ResourceInterface $resource, $rule = 0, $priority = 0) {
        $rp = new RolePolicy();
        $rp->setPriority($priority);
        $rp->setResource($resource);
        $rp->setRule($rule);
        $rp->setRole($role);
        return $this->addPolicy($rp);
    }


}