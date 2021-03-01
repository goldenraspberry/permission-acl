<?php


namespace Goldenraspberry\Permissions\Acl;


use Goldenraspberry\Permissions\Acl\Policy\PolicyInterface;
use Goldenraspberry\Permissions\Acl\Resource\ResourceInterface;
use Goldenraspberry\Permissions\Acl\Role\RoleInterface;
use Goldenraspberry\Permissions\Acl\User\UserInterface;

interface AclInterface {

    /**
     * check both of UserRule and RoleRule
     * @param UserInterface $user
     * @param ResourceInterface $resource
     * @return bool
     */
    public function isAllow(UserInterface $user, ResourceInterface $resource);

    /**
     * only check UserRule
     * @param UserInterface $user
     * @param ResourceInterface $resource
     * @return bool
     */
    public function isUserAllow(UserInterface $user, ResourceInterface $resource);

    /**
     * only check RoleRule
     * @param RoleInterface $role
     * @param ResourceInterface $resource
     * @return bool
     */
    public function isRoleAllow(RoleInterface $role, ResourceInterface $resource);

    /**
     * @param PolicyInterface $policy
     * @return bool
     */
    public function addPolicy(PolicyInterface $policy);

    /**
     * @param PolicyInterface $policy
     * @return bool
     */
    public function removePolicy(PolicyInterface $policy);

    /**
     * @param UserInterface $user
     * @param ResourceInterface $resource
     * @param int $rule
     * @param int $priority
     * @return bool
     */
    public function addUserPolicy(UserInterface $user, ResourceInterface $resource, $rule = 0, $priority = 0);

    /**
     * @param RoleInterface $role
     * @param ResourceInterface $resource
     * @param int $rule
     * @param int $priority
     * @return bool
     */
    public function addRolePolicy(RoleInterface $role, ResourceInterface $resource, $rule = 0, $priority = 0);

}