<?php


namespace GoldenraspberryTest\Permissions\Acl\Mock;


use Goldenraspberry\Permissions\Acl\Assert\NormalPathAssert;
use Goldenraspberry\Permissions\Acl\Policy\PolicyInterface;
use Goldenraspberry\Permissions\Acl\Resource\ResourceInterface;

class NormalPathAssertMock extends NormalPathAssert {

    public function isMatchTest(ResourceInterface $policyResource, ResourceInterface $resource){
        return $this->isMatch($policyResource, $resource);
    }

    public function lessTest(PolicyInterface $p1, PolicyInterface $p2){
        return $this->less($p1, $p2);
    }

}