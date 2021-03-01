<?php


namespace GoldenraspberryTest\Permissions\Acl;


use Goldenraspberry\Permissions\Acl\Acl;
use Goldenraspberry\Permissions\Acl\Policy\PolicyInterface;
use Goldenraspberry\Permissions\Acl\Resource\GenericResource;
use GoldenraspberryTest\Permissions\Acl\Mock\GenericRegister;
use GoldenraspberryTest\Permissions\Acl\Mock\NormalPathAssertMock;
use GoldenraspberryTest\Permissions\Acl\Mock\PolicyRegister;
use GoldenraspberryTest\Permissions\Acl\Mock\Role;
use GoldenraspberryTest\Permissions\Acl\Mock\RoleGroup;
use GoldenraspberryTest\Permissions\Acl\Mock\User;
use PHPUnit\Framework\TestCase;

class AclTest extends TestCase {

    public function __construct(string $name = null, array $data = [], $dataName = '') {
        parent::__construct($name, $data, $dataName);
        $this->init();
    }

    /**
     *
     */
    public function init(){
        $acl = new Acl();
        $acl->setPolicyRegister(new PolicyRegister());
        $acl->setAssert(new NormalPathAssertMock());

        $register = new GenericRegister();
        $roleBasic = new Role();
        $register->register($roleBasic);
        $roleBan = new Role();
        $register->register($roleBan);
        $roleRoot = new Role();
        $register->register($roleRoot);
        $roleBlogAdmin = new Role();
        $register->register($roleBlogAdmin);
        $roleUser = new Role();
        $register->register($roleUser);
        $roleWikiAdmin = new Role();
        $register->register($roleWikiAdmin);
        $roleForumAdmin = new Role();
        $register->register($roleForumAdmin);
        $roleUserV1 = new Role();
        $roleUserV2 = new Role();
        $register->register($roleUserV1);
        $register->register($roleUserV2);

        // 注册基础规则
        $acl->addRolePolicy($roleBasic, new GenericResource("/"), PolicyInterface::DENY);
        $acl->addRolePolicy($roleBan, new GenericResource("/"), PolicyInterface::DENY, 99);

        $acl->addRolePolicy($roleRoot, new GenericResource("/root"), PolicyInterface::ALLOW);
        $acl->addRolePolicy($roleBlogAdmin, new GenericResource("/root/blog"), PolicyInterface::ALLOW);
        $acl->addRolePolicy($roleWikiAdmin, new GenericResource("/root/wiki"), PolicyInterface::ALLOW);
        $acl->addRolePolicy($roleForumAdmin, new GenericResource("/root/forum"), PolicyInterface::ALLOW);

        $groupBlogWiki = new RoleGroup();
        $groupBlogWiki->addRole($roleBlogAdmin);
        $groupBlogWiki->addRole($roleWikiAdmin);

        $groupWikiForum1 = new RoleGroup();
        $groupWikiForum1->addRole($roleWikiAdmin);
        $acl->addRolePolicy($groupWikiForum1, new GenericResource("/root/forum/1"), PolicyInterface::ALLOW);


        $list = [];

        $user1 = new User();
        $user2 = new User();
        $user3 = new User();
        $user4 = new User();
        $register->register($user1);
        $register->register($user2);
        $register->register($user3);
        $register->register($user4);

    }


}