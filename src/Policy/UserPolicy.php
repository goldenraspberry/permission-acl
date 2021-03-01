<?php


namespace Goldenraspberry\Permissions\Acl\Policy;


use Goldenraspberry\Permissions\Acl\User\UserInterface;

class UserPolicy implements UserPolicyInterface {

    use Policy;

    /**
     * @var UserInterface
     */
    protected $user = null;

    public function setUser(UserInterface $user) {
        $this->user = $user;
        return $this;
    }

    public function getUser() {
        return $this->user;
    }


}