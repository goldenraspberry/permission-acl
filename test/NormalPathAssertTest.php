<?php


namespace GoldenraspberryTest\Permissions\Acl;


use Goldenraspberry\Permissions\Acl\Policy\Policy;
use Goldenraspberry\Permissions\Acl\Policy\PolicyInterface;
use Goldenraspberry\Permissions\Acl\Policy\RolePolicy;
use Goldenraspberry\Permissions\Acl\Policy\UserPolicy;
use Goldenraspberry\Permissions\Acl\Resource\GenericResource;
use GoldenraspberryTest\Permissions\Acl\Mock\GenericRegister;
use GoldenraspberryTest\Permissions\Acl\Mock\NormalPathAssertMock;
use GoldenraspberryTest\Permissions\Acl\Mock\PolicyRegister;
use GoldenraspberryTest\Permissions\Acl\Mock\User;
use PHPUnit\Framework\TestCase;

class NormalPathAssertTest extends TestCase {

    public function testMatch() {
        $assert = new NormalPathAssertMock();

        $resource = new GenericResource("/root/abc/123/456");

        $this->assertEquals(true, $assert->isMatchTest(new GenericResource("/root/abc/123"), $resource), '/root/abc/1234');
        $this->assertEquals(true, $assert->isMatchTest(new GenericResource("/root/abc"), $resource), '/root/abc');
        $this->assertEquals(true, $assert->isMatchTest(new GenericResource("/root/abc/"), $resource), '/root/abc/');
        $this->assertEquals(true, $assert->isMatchTest(new GenericResource("/root/abc/*"), $resource), '/root/abc/*');
        $this->assertEquals(true, $assert->isMatchTest(new GenericResource("/root/abc/123/456"), $resource), '/root/abc/123/456');
        $this->assertEquals(true, $assert->isMatchTest(new GenericResource("/root/*/123"), $resource), "/root/*/123");
        $this->assertEquals(true, $assert->isMatchTest(new GenericResource("/root/*/123/456"), $resource), '/root/*/123/456');

        $this->assertEquals(false, $assert->isMatchTest(new GenericResource("/root/abc/123/456/"), $resource),'/root/abc/123/456/');
        $this->assertEquals(false, $assert->isMatchTest(new GenericResource("/root/abc/123/456/*"), $resource), '/root/abc/123/456/*');
        $this->assertEquals(false, $assert->isMatchTest(new GenericResource("/root/bc/123"), $resource), "/root/bc/123");
        $this->assertEquals(false, $assert->isMatchTest(new GenericResource("/root/ab"), $resource), '/root/ab');
        $this->assertEquals(false, $assert->isMatchTest(new GenericResource("/root/abc/12"), $resource), '/root/abc/12');
        $this->assertEquals(false, $assert->isMatchTest(new GenericResource("/root/abc/123/45"), $resource), '/root/abc/123/45');
    }

    public function testLess() {
        $assert = new NormalPathAssertMock();
        $register = new GenericRegister();

        $up1 = new UserPolicy();
        $up2 = new UserPolicy();
        $rp1 = new RolePolicy();
        $rp2 = new RolePolicy();

        $up1->setPriority(2)->setResource(new GenericResource("/root/abc/123"));
        $up2->setPriority(0)->setResource(new GenericResource("/root/abc/123/456"));

        // test priority
        $this->assertEquals(false, $assert->lessTest($up1, $up2), "test priority 1");
        $this->assertEquals(true, $assert->lessTest($up2, $up1), "test priority 2");

        // test dep
        $up1->setPriority(0);
        $up2->setPriority(0);
        $up1->setResource(new GenericResource("/root/abc/123"));
        $up2->setResource(new GenericResource("/root/abc/123/456"));
        $this->assertEquals(true, $assert->lessTest($up1, $up2), "test dep 1");
        $this->assertEquals(false, $assert->lessTest($up2, $up1), "test dep 2");
        $up1->setResource(new GenericResource("/root/abc/123/"));
        $up2->setResource(new GenericResource("/root/abc/123/456"));
        $this->assertEquals(true, $assert->lessTest($up1, $up2), "test dep 3");
        $this->assertEquals(false, $assert->lessTest($up2, $up1), "test dep 4");

        // test user & role
        $user = new User();
        $register->register($user);
        $up1->setPriority(0)->setResource(new GenericResource('/root/abc/123'))->setUser($user);
        $up2->setPriority(0)->setResource(new GenericResource('/root/abc/123'))->setUser($user);
        $rp1->setPriority(0)->setResource(new GenericResource('/root/abc/123'));
        $rp2->setPriority(0)->setResource(new GenericResource('/root/abc/123'));
        $register->register($up1);
        $register->register($up2);
        $register->register($rp1);
        $register->register($rp2);
        $this->assertEquals(true, $assert->lessTest($rp1, $up1), 'test user 1');
        $this->assertEquals(false, $assert->lessTest($up1, $rp1), 'test user 2');
        $this->assertEquals(true, $assert->lessTest($rp1, $rp2), 'test user 3');
        $this->assertEquals(true, $assert->lessTest($up1, $up2), 'test user 4');
    }

    public function testIsAllowTrue(){
        $assert = new NormalPathAssertMock();
        $register = new GenericRegister();
        $policyPool = new PolicyRegister();

        $resource = new GenericResource("/root/abc/123");

        $list = [];
        $list [] = (new RolePolicy())->setResource(new GenericResource("/root/abc/123/45"))->setPriority(0)->setRule(PolicyInterface::ALLOW);
        $list [] = (new RolePolicy())->setResource(new GenericResource("/root/abc"))->setPriority(0)->setRule(PolicyInterface::DENY);
        $list [] = (new RolePolicy())->setResource(new GenericResource("/root"))->setPriority(0)->setRule(PolicyInterface::DENY);
        $list [] = (new RolePolicy())->setResource(new GenericResource("/root/abc/"))->setPriority(0)->setRule(PolicyInterface::ALLOW);

        foreach($list as $p){
            $policyPool->register($p);
        }

        $this->assertEquals(true, $assert->isAllow($list, $resource, PolicyInterface::DENY));

    }

    public function testIsAllowFalse(){
        $assert = new NormalPathAssertMock();
        $register = new GenericRegister();
        $policyPool = new PolicyRegister();

        $resource = new GenericResource("/root/abc/123");

        $list = [];
        $list [] = (new RolePolicy())->setResource(new GenericResource("/root/abc/123/45"))->setPriority(0)->setRule(PolicyInterface::ALLOW);
        $list [] = (new RolePolicy())->setResource(new GenericResource("/root/abc"))->setPriority(0)->setRule(PolicyInterface::DENY);
        $list [] = (new RolePolicy())->setResource(new GenericResource("/root"))->setPriority(1)->setRule(PolicyInterface::DENY);
        $list [] = (new RolePolicy())->setResource(new GenericResource("/root/abc/"))->setPriority(0)->setRule(PolicyInterface::ALLOW);

        foreach($list as $p){
            $policyPool->register($p);
        }

        $this->assertEquals(true, $assert->isMatchTest($list[2]->getResource(), $resource), 'test is_match');
        $this->assertEquals(true, $assert->lessTest($list[0], $list[2]), 'test less');
        $this->assertEquals(false, $assert->isAllow($list, $resource, PolicyInterface::DENY), "test is_allow false");
    }
}