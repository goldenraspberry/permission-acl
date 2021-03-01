<?php


namespace Goldenraspberry\Permissions\Acl\Assert;


use Goldenraspberry\Permissions\Acl\Policy\PolicyInterface;
use Goldenraspberry\Permissions\Acl\Policy\RolePolicyInterface;
use Goldenraspberry\Permissions\Acl\Policy\UserPolicyInterface;
use Goldenraspberry\Permissions\Acl\Resource\ResourceInterface;

class NormalPathAssert implements AssertInterface {

    protected $delimiter = "/";

    private $mapPolicyDep = [];

    public function isAllow(array $listPolicy, ResourceInterface $resource, $defaultRule) {
        $valid = $this->getValidPolicy($listPolicy, $resource);
        $rule = is_null($valid) ? $defaultRule : $valid->getRule();
        return $rule == PolicyInterface::ALLOW;
    }

    /**
     * @param ResourceInterface $policyResource
     * @param ResourceInterface $resource
     * @return bool
     */
    protected function isMatch(ResourceInterface $policyResource, ResourceInterface $resource){
        $pId = $policyResource->getId();
        $rId = $resource->getId();
        if ($pId == $rId){
            return true;
        }
        if (fnmatch($pId, $rId)){
            return true;
        }
        if (substr($pId, -1) != "*"){
            if (substr($pId, -1) != $this->delimiter){
                $pId .= $this->delimiter;
            }
            $pId .= "*";
        }
        if (fnmatch($pId, $rId)){
            return true;
        }
        return false;
    }

    protected function getValidPolicy(array $listPolicy, ResourceInterface $resource){
        $valid = null;
        foreach($listPolicy as $policy){
            if (! $policy instanceof PolicyInterface){
                continue;
            }
            if ($this->isMatch($policy->getResource(),$resource)){
                if ($valid == null){
                    $valid = $policy;
                    continue;
                }

                if ($this->less($valid, $policy)){
                    $valid = $policy;
                }
            }
        }

        return $valid;
    }

    protected function less(PolicyInterface $p1, PolicyInterface $p2){
        // 优先级高的优先
        {
            $priorityDiff = $p1->getPriority() - $p2->getPriority();
            if ($priorityDiff > 0){
                return false;
            }
            if ($priorityDiff < 0){
                return true;
            }
        }

        // 深度高的优先
        {
            $dep1 = $this->getPolicyDepth($p1);
            $dep2 = $this->getPolicyDepth($p2);

            if ($dep1 > $dep2){
                return false;
            }
            if ($dep1 < $dep2){
                return true;
            }
        }

        // 用户级规则>角色级规则
        {
            $isP1User = $p1 instanceof UserPolicyInterface && $p1->getUser()->getId() > 0;
            $isP2User = $p2 instanceof UserPolicyInterface && $p2->getUser()->getId() > 0;
            if ($isP1User && !$isP2User){
                return false;
            }
            if (!$isP1User && $isP2User){
                return true;
            }
        }

        // 新策略大于旧策略
        {
            return $p1->getId() < $p2->getId();
        }
    }

    protected function getPolicyDepth(PolicyInterface $policy){
        if ($policy->getId() > 0 && isset($this->mapPolicyDep[$policy->getId()])){
            $dep = $this->mapPolicyDep[$policy->getId()];
        }else{
            $dep = count(explode($this->delimiter, trim($policy->getResource()->getId(), $this->delimiter)));
            $policy->getId() > 0 && $this->mapPolicyDep[$policy->getId()] = $dep;
        }
        return $dep;
    }

}