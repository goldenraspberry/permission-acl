<?php


namespace Goldenraspberry\Permissions\Acl\Assert;


use Goldenraspberry\Permissions\Acl\Resource\ResourceInterface;

interface AssertInterface {

    /**
     * @param array $listPolicy []PolicyInterface
     * @param ResourceInterface $resource
     * @param int $defaultRule
     * @return bool
     */
    public function isAllow(array $listPolicy, ResourceInterface $resource, $defaultRule);

}