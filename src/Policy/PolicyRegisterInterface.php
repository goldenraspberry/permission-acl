<?php


namespace Goldenraspberry\Permissions\Acl\Policy;


use Goldenraspberry\Permissions\Acl\Role\RoleInterface;
use Goldenraspberry\Permissions\Acl\User\UserInterface;

interface PolicyRegisterInterface {

    /**
     * @param PolicyInterface $policy
     * @return bool
     */
    public function register(PolicyInterface $policy);

    /**
     * @param PolicyInterface $policy
     * @return bool
     */
    public function unregister(PolicyInterface $policy);

    /**
     * @param UserInterface $user
     * @return array []Policy
     */
    public function listByUser(UserInterface $user);

    /**
     * @param RoleInterface $role
     * @return array []Policy
     */
    public function listByRole(RoleInterface $role);

    /**
     * @param array $listRole []RoleInterface
     * @return array []Policy
     */
    public function listByRoles(array $listRole);
}