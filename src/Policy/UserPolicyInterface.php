<?php


namespace Goldenraspberry\Permissions\Acl\Policy;


use Goldenraspberry\Permissions\Acl\User\UserInterface;

interface UserPolicyInterface extends PolicyInterface {

    /**
     * @param UserInterface $user
     * @return self
     */
    public function setUser(UserInterface $user);

    /**
     * @return UserInterface
     */
    public function getUser();

}